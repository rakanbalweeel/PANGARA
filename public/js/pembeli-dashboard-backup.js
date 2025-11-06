// Pembeli Dashboard JavaScript - Real Data Implementation
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const API_BASE = '/api';

// Global Data
let productsData = [];
let purchaseHistory = [];
let cartItems = [];
let favoriteProducts = [];

// ===========================================
// INITIALIZATION
// ===========================================
document.addEventListener('DOMContentLoaded', function() {
    loadDashboardData();
    setupEventListeners();
});

function setupEventListeners() {
    // Cart button
    const cartBtn = document.querySelector('[data-cart-btn]');
    if (cartBtn) {
        cartBtn.addEventListener('click', openCart);
    }
}

// ===========================================
// LOAD DASHBOARD DATA
// ===========================================
async function loadDashboardData() {
    await Promise.all([
        loadStats(),
        loadProducts(),
        loadPurchaseHistory()
    ]);
}

async function loadStats() {
    try {
        const response = await fetch(`${API_BASE}/pembeli/stats`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) throw new Error('Gagal memuat statistik');
        
        const stats = await response.json();
        updateStatsCards(stats);
    } catch (error) {
        console.error('Error loading stats:', error);
        // Use default values if API fails
        updateStatsCards({
            total_purchases: 0,
            total_spending: 0,
            favorite_count: 0,
            reward_points: 0
        });
    }
}

async function loadProducts() {
    try {
        const response = await fetch(`${API_BASE}/products?limit=8&sort=popular`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) throw new Error('Gagal memuat produk');
        
        const result = await response.json();
        productsData = result.data || result;
        updateProductsGrid();
    } catch (error) {
        console.error('Error loading products:', error);
        showNotification('error', 'Gagal memuat produk');
    }
}

async function loadPurchaseHistory() {
    try {
        const response = await fetch(`${API_BASE}/pembeli/purchases?limit=5`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) throw new Error('Gagal memuat riwayat');
        
        const result = await response.json();
        purchaseHistory = result.data || result;
        updatePurchaseHistory();
    } catch (error) {
        console.error('Error loading purchase history:', error);
    }
}

// ===========================================
// UPDATE UI
// ===========================================
function updateStatsCards(stats) {
    const totalPurchasesEl = document.querySelector('[data-stat="purchases"]');
    const totalSpendingEl = document.querySelector('[data-stat="spending"]');
    const favoritesEl = document.querySelector('[data-stat="favorites"]');
    const rewardPointsEl = document.querySelector('[data-stat="rewards"]');
    
    if (totalPurchasesEl) totalPurchasesEl.textContent = stats.total_purchases || 0;
    if (totalSpendingEl) totalSpendingEl.textContent = formatCurrency(stats.total_spending || 0);
    if (favoritesEl) favoritesEl.textContent = stats.favorite_count || 0;
    if (rewardPointsEl) rewardPointsEl.textContent = stats.reward_points || 0;
}

function updateProductsGrid() {
    const grid = document.getElementById('products-grid');
    if (!grid) return;
    
    if (!productsData || productsData.length === 0) {
        grid.innerHTML = `
            <div class="col-span-4 text-center py-12">
                <i class="fas fa-box-open text-5xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Belum ada produk tersedia</p>
            </div>
        `;
        return;
    }
    
    grid.innerHTML = productsData.map(product => `
        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition cursor-pointer" onclick="viewProduct(${product.id})">
            <img src="${product.image_url || 'https://via.placeholder.com/300'}" alt="${product.name}" class="w-full h-48 object-cover">
            <div class="p-4">
                <h4 class="font-semibold text-gray-900 mb-2">${product.name}</h4>
                <div class="flex items-center mb-2">
                    <div class="flex text-yellow-400 text-sm">
                        ${generateStars(product.rating || 4.5)}
                    </div>
                    <span class="text-xs text-gray-500 ml-2">(${product.rating || 4.5})</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-lg font-bold text-purple-600">${formatCurrency(product.price)}</div>
                        ${product.original_price ? `<div class="text-xs text-gray-400 line-through">${formatCurrency(product.original_price)}</div>` : ''}
                    </div>
                    <button onclick="addToCart(event, ${product.id})" class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center hover:bg-purple-600 hover:text-white transition">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

function updatePurchaseHistory() {
    const container = document.getElementById('purchase-history');
    if (!container) return;
    
    if (!purchaseHistory || purchaseHistory.length === 0) {
        container.innerHTML = `
            <div class="text-center py-12">
                <i class="fas fa-shopping-bag text-5xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Belum ada riwayat pembelian</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = purchaseHistory.map(purchase => `
        <div class="flex items-center justify-between pb-4 border-b">
            <div class="flex items-center">
                <img src="${purchase.product_image || 'https://via.placeholder.com/80'}" class="w-16 h-16 rounded-lg mr-4 object-cover" alt="${purchase.product_name}">
                <div>
                    <div class="font-medium text-gray-900">${purchase.product_name}</div>
                    <div class="text-sm text-gray-500">${formatDate(purchase.created_at)}</div>
                    <div class="text-sm font-semibold text-purple-600">${formatCurrency(purchase.amount)}</div>
                </div>
            </div>
            <div class="flex space-x-2">
                <button onclick="buyAgain(${purchase.product_id})" class="px-4 py-2 border border-purple-600 text-purple-600 rounded-lg hover:bg-purple-50 transition">
                    Beli Lagi
                </button>
                <button onclick="reviewProduct(${purchase.product_id})" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    Review
                </button>
            </div>
        </div>
    `).join('');
}

function updateCartBadge() {
    const badge = document.querySelector('[data-cart-badge]');
    if (badge) {
        badge.textContent = cartItems.length;
        badge.style.display = cartItems.length > 0 ? 'flex' : 'none';
    }
}

// ===========================================
// ACTIONS
// ===========================================
function viewProduct(productId) {
    // Redirect to product detail page or open modal
    showNotification('info', 'Detail produk akan segera hadir!');
}

function addToCart(event, productId) {
    event.stopPropagation();
    const product = productsData.find(p => p.id === productId);
    if (!product) return;
    
    const existing = cartItems.find(item => item.id === productId);
    if (existing) {
        existing.quantity++;
    } else {
        cartItems.push({ ...product, quantity: 1 });
    }
    
    updateCartBadge();
    showNotification('success', `${product.name} ditambahkan ke keranjang!`);
}

function openCart() {
    if (cartItems.length === 0) {
        showNotification('info', 'Keranjang belanja Anda kosong');
        return;
    }
    showNotification('info', 'Halaman keranjang belanja akan segera hadir!');
}

function buyAgain(productId) {
    const product = productsData.find(p => p.id === productId);
    if (product) {
        addToCart(event, productId);
    } else {
        showNotification('info', 'Produk tidak tersedia');
    }
}

function reviewProduct(productId) {
    showNotification('info', 'Fitur review produk akan segera hadir!');
}

// ===========================================
// SECTION NAVIGATION
// ===========================================
function showSection(event, sectionName) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    
    // Hide all sections
    document.querySelectorAll('.pembeli-section').forEach(section => {
        section.classList.add('hidden');
    });
    
    // Show selected section
    const activeSection = document.getElementById(sectionName + '-section');
    if (activeSection) {
        activeSection.classList.remove('hidden');
    }
    
    // Update active sidebar link
    document.querySelectorAll('.sidebar-link').forEach(link => {
        link.classList.remove('bg-purple-600');
        link.classList.add('hover:bg-gray-800');
    });
    
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('bg-purple-600');
        event.currentTarget.classList.remove('hover:bg-gray-800');
    } else {
        const activeLink = document.querySelector(`.sidebar-link[data-section="${sectionName}"]`);
        if (activeLink) {
            activeLink.classList.add('bg-purple-600');
            activeLink.classList.remove('hover:bg-gray-800');
        }
    }
    
    // Load section data
    if (sectionName === 'dashboard') {
        loadDashboardData();
    } else if (sectionName === 'belanja') {
        loadProducts();
    } else if (sectionName === 'riwayat') {
        loadPurchaseHistory();
    } else if (sectionName === 'favorit') {
        loadFavorites();
    }
}

async function loadFavorites() {
    showNotification('info', 'Memuat produk favorit...');
}

// ===========================================
// HELPER FUNCTIONS
// ===========================================
function formatCurrency(amount) {
    if (amount === null || amount === undefined) return 'Rp 0';
    return 'Rp ' + parseFloat(amount).toLocaleString('id-ID');
}

function formatDate(dateStr) {
    if (!dateStr) return '-';
    const date = new Date(dateStr);
    const now = new Date();
    const diff = Math.floor((now - date) / (1000 * 60 * 60 * 24));
    
    if (diff === 0) return 'Hari ini';
    if (diff === 1) return 'Kemarin';
    if (diff < 7) return `${diff} hari yang lalu`;
    
    return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
}

function generateStars(rating) {
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 >= 0.5;
    const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
    
    let stars = '';
    for (let i = 0; i < fullStars; i++) {
        stars += '<i class="fas fa-star"></i>';
    }
    if (hasHalfStar) {
        stars += '<i class="fas fa-star-half-alt"></i>';
    }
    for (let i = 0; i < emptyStars; i++) {
        stars += '<i class="far fa-star"></i>';
    }
    
    return stars;
}

// ===========================================
// NOTIFICATION
// ===========================================
function showNotification(type, message) {
    const colors = {
        'success': 'bg-green-500',
        'error': 'bg-red-500',
        'info': 'bg-blue-500',
        'warning': 'bg-yellow-500'
    };
    
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-circle',
        'info': 'info-circle',
        'warning': 'exclamation-triangle'
    };
    
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg ${colors[type] || 'bg-gray-500'} text-white transform transition-all duration-300 translate-x-full`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${icons[type] || 'info-circle'} mr-3"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Make functions globally available
window.showSection = showSection;
window.viewProduct = viewProduct;
window.addToCart = addToCart;
window.buyAgain = buyAgain;
window.reviewProduct = reviewProduct;
window.openCart = openCart;
