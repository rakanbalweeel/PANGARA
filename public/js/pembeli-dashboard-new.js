// Pembeli Dashboard JavaScript - Complete Implementation
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const API_BASE = '/api';

// Global Data
let productsData = [];
let purchaseHistory = [];
let cartItems = [];
let favoriteProducts = [];
let allCategories = [];

// ===========================================
// INITIALIZATION
// ===========================================
document.addEventListener('DOMContentLoaded', function() {
    loadDashboardData();
    loadCategories();
    setupEventListeners();
});

function setupEventListeners() {
    // Cart button
    const cartBtn = document.querySelector('[data-cart-btn]');
    if (cartBtn) {
        cartBtn.addEventListener('click', openCart);
    }
    
    // Search product
    const searchInput = document.getElementById('search-product');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(filterProducts, 300));
    }
    
    // Category filter
    const categoryFilter = document.getElementById('category-filter');
    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterProducts);
    }
    
    // Sort product
    const sortProduct = document.getElementById('sort-product');
    if (sortProduct) {
        sortProduct.addEventListener('change', filterProducts);
    }
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ===========================================
// SECTION NAVIGATION
// ===========================================
function showSection(event, sectionName) {
    if (event) event.preventDefault();
    
    // Hide all sections
    document.querySelectorAll('.pembeli-section').forEach(section => {
        section.style.display = 'none';
    });
    
    // Show selected section
    const targetSection = document.getElementById(sectionName + '-section');
    if (targetSection) {
        targetSection.style.display = 'block';
    }
    
    // Update sidebar active state
    document.querySelectorAll('.sidebar-link').forEach(link => {
        link.classList.remove('bg-purple-600');
        link.classList.add('hover:bg-gray-800');
    });
    
    const activeLink = document.querySelector(`[data-section="${sectionName}"]`);
    if (activeLink) {
        activeLink.classList.add('bg-purple-600');
        activeLink.classList.remove('hover:bg-gray-800');
    }
    
    // Load data for specific sections
    if (sectionName === 'belanja') {
        loadAllProducts();
    } else if (sectionName === 'riwayat') {
        loadAllPurchaseHistory();
    } else if (sectionName === 'favorit') {
        loadFavoriteProducts();
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
        showNotification('error', 'Gagal memuat statistik');
    }
}

function updateStatsCards(stats) {
    // Update purchases
    const purchasesEl = document.querySelector('[data-stat="purchases"]');
    if (purchasesEl) {
        purchasesEl.textContent = stats.total_purchases || 0;
    }
    
    // Update spending
    const spendingEl = document.querySelector('[data-stat="spending"]');
    if (spendingEl) {
        spendingEl.textContent = formatCurrency(stats.total_spending || 0);
    }
    
    // Update favorites
    const favoritesEl = document.querySelector('[data-stat="favorites"]');
    if (favoritesEl) {
        favoritesEl.textContent = stats.favorite_count || 0;
    }
    
    // Update rewards
    const rewardsEl = document.querySelector('[data-stat="rewards"]');
    if (rewardsEl) {
        rewardsEl.textContent = stats.reward_points || 0;
    }
}

// ===========================================
// LOAD PRODUCTS
// ===========================================
async function loadProducts() {
    try {
        const response = await fetch(`${API_BASE}/products?limit=8&sort=popular`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) throw new Error('Gagal memuat produk');
        
        const data = await response.json();
        productsData = data.data || data;
        updateProductsGrid(productsData);
    } catch (error) {
        console.error('Error loading products:', error);
        const grid = document.getElementById('products-grid');
        if (grid) {
            grid.innerHTML = '<div class="col-span-4 text-center py-12"><p class="text-red-500">Gagal memuat produk</p></div>';
        }
    }
}

async function loadAllProducts() {
    try {
        const response = await fetch(`${API_BASE}/products`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) throw new Error('Gagal memuat produk');
        
        const data = await response.json();
        productsData = data.data || data;
        updateAllProductsGrid(productsData);
    } catch (error) {
        console.error('Error loading all products:', error);
        const grid = document.getElementById('all-products-grid');
        if (grid) {
            grid.innerHTML = '<div class="col-span-4 text-center py-12"><p class="text-red-500">Gagal memuat produk</p></div>';
        }
    }
}

async function loadCategories() {
    try {
        const response = await fetch(`${API_BASE}/categories`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) throw new Error('Gagal memuat kategori');
        
        const data = await response.json();
        allCategories = data.data || data;
        
        const categoryFilter = document.getElementById('category-filter');
        if (categoryFilter) {
            allCategories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categoryFilter.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error loading categories:', error);
    }
}

function filterProducts() {
    const searchTerm = document.getElementById('search-product')?.value.toLowerCase() || '';
    const categoryId = document.getElementById('category-filter')?.value || '';
    const sortBy = document.getElementById('sort-product')?.value || 'popular';
    
    let filtered = productsData.filter(product => {
        const matchSearch = product.name.toLowerCase().includes(searchTerm) || 
                          (product.description && product.description.toLowerCase().includes(searchTerm));
        const matchCategory = !categoryId || product.category_id == categoryId;
        return matchSearch && matchCategory;
    });
    
    // Sort products
    if (sortBy === 'price-low') {
        filtered.sort((a, b) => parseFloat(a.price) - parseFloat(b.price));
    } else if (sortBy === 'price-high') {
        filtered.sort((a, b) => parseFloat(b.price) - parseFloat(a.price));
    } else if (sortBy === 'newest') {
        filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
    }
    
    updateAllProductsGrid(filtered);
}

function updateProductsGrid(products) {
    const grid = document.getElementById('products-grid');
    if (!grid) return;
    
    if (!products || products.length === 0) {
        grid.innerHTML = '<div class="col-span-4 text-center py-12"><i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i><p class="text-gray-500">Belum ada produk</p></div>';
        return;
    }
    
    grid.innerHTML = products.map(product => `
        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition cursor-pointer">
            <img src="${product.image || 'https://via.placeholder.com/300'}" alt="${product.name}" class="w-full h-48 object-cover" onclick="viewProduct(${product.id})">
            <div class="p-4">
                <h4 class="font-semibold text-gray-900 mb-2">${product.name}</h4>
                <div class="flex items-center mb-2">
                    ${generateStars(4.5)}
                    <span class="text-xs text-gray-500 ml-2">(4.5)</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-lg font-bold text-purple-600">${formatCurrency(product.price)}</div>
                        ${product.stock ? `<div class="text-xs text-gray-400">Stok: ${product.stock}</div>` : ''}
                    </div>
                    <button onclick="addToCart(event, ${product.id})" class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center hover:bg-purple-600 hover:text-white transition">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

function updateAllProductsGrid(products) {
    const grid = document.getElementById('all-products-grid');
    if (!grid) return;
    
    if (!products || products.length === 0) {
        grid.innerHTML = '<div class="col-span-4 text-center py-12"><i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i><p class="text-gray-500">Tidak ada produk ditemukan</p></div>';
        return;
    }
    
    grid.innerHTML = products.map(product => `
        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition cursor-pointer">
            <img src="${product.image || 'https://via.placeholder.com/300'}" alt="${product.name}" class="w-full h-48 object-cover" onclick="viewProduct(${product.id})">
            <div class="p-4">
                <h4 class="font-semibold text-gray-900 mb-2">${product.name}</h4>
                <div class="flex items-center mb-2">
                    ${generateStars(4.5)}
                    <span class="text-xs text-gray-500 ml-2">(4.5)</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-lg font-bold text-purple-600">${formatCurrency(product.price)}</div>
                        ${product.stock ? `<div class="text-xs text-gray-400">Stok: ${product.stock}</div>` : ''}
                    </div>
                    <button onclick="addToCart(event, ${product.id})" class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center hover:bg-purple-600 hover:text-white transition">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

// ===========================================
// LOAD PURCHASE HISTORY
// ===========================================
async function loadPurchaseHistory() {
    try {
        const response = await fetch(`${API_BASE}/pembeli/purchases?limit=5`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) throw new Error('Gagal memuat riwayat');
        
        const data = await response.json();
        purchaseHistory = data.data || data;
        updatePurchaseHistory(purchaseHistory, 'purchase-history');
    } catch (error) {
        console.error('Error loading purchase history:', error);
        const container = document.getElementById('purchase-history');
        if (container) {
            container.innerHTML = '<div class="text-center py-12"><p class="text-red-500">Gagal memuat riwayat pembelian</p></div>';
        }
    }
}

async function loadAllPurchaseHistory() {
    try {
        const response = await fetch(`${API_BASE}/pembeli/purchases`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) throw new Error('Gagal memuat riwayat');
        
        const data = await response.json();
        purchaseHistory = data.data || data;
        updatePurchaseHistory(purchaseHistory, 'all-purchase-history');
    } catch (error) {
        console.error('Error loading all purchase history:', error);
        const container = document.getElementById('all-purchase-history');
        if (container) {
            container.innerHTML = '<div class="text-center py-12"><p class="text-red-500">Gagal memuat riwayat pembelian</p></div>';
        }
    }
}

function updatePurchaseHistory(purchases, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    
    if (!purchases || purchases.length === 0) {
        container.innerHTML = `
            <div class="text-center py-12">
                <i class="fas fa-shopping-bag text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 mb-2">Belum ada riwayat pembelian</p>
                <button onclick="showSection(event, 'belanja')" class="text-purple-600 hover:text-purple-700 font-medium">
                    Mulai Belanja
                </button>
            </div>
        `;
        return;
    }
    
    container.innerHTML = purchases.map(purchase => `
        <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50 transition">
            <div class="flex items-center flex-1">
                <img src="${purchase.product_image || 'https://via.placeholder.com/60'}" alt="${purchase.product_name}" class="w-16 h-16 rounded-lg object-cover mr-4">
                <div class="flex-1">
                    <div class="font-medium text-gray-900">${purchase.product_name}</div>
                    <div class="text-sm text-gray-600">${formatDate(purchase.created_at)}</div>
                    <div class="text-sm text-purple-600 font-medium">${formatCurrency(purchase.amount)}</div>
                </div>
            </div>
            <div class="flex gap-2">
                <button onclick="buyAgain(${purchase.product_id})" class="px-4 py-2 text-sm bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    <i class="fas fa-redo mr-1"></i> Beli Lagi
                </button>
                <button onclick="reviewProduct(${purchase.product_id})" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-star mr-1"></i> Review
                </button>
            </div>
        </div>
    `).join('');
}

// ===========================================
// CART FUNCTIONS
// ===========================================
function addToCart(event, productId) {
    event.stopPropagation();
    
    const product = productsData.find(p => p.id === productId);
    if (!product) {
        showNotification('error', 'Produk tidak ditemukan');
        return;
    }
    
    const existingItem = cartItems.find(item => item.id === productId);
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cartItems.push({
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            quantity: 1
        });
    }
    
    updateCartBadge();
    showNotification('success', `${product.name} ditambahkan ke keranjang`);
}

function updateCartBadge() {
    const badge = document.querySelector('[data-cart-badge]');
    if (badge) {
        const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
        badge.textContent = totalItems;
        badge.style.display = totalItems > 0 ? 'flex' : 'none';
    }
}

function openCart() {
    if (cartItems.length === 0) {
        showNotification('info', 'Keranjang belanja masih kosong');
        return;
    }
    
    const totalPrice = cartItems.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0);
    
    const cartHTML = `
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 max-h-[80vh] overflow-hidden">
                <div class="p-6 border-b">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold text-gray-900">Keranjang Belanja</h3>
                        <button onclick="closeCart()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-2xl"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6 overflow-y-auto max-h-96">
                    ${cartItems.map(item => `
                        <div class="flex items-center justify-between mb-4 pb-4 border-b">
                            <div class="flex items-center flex-1">
                                <img src="${item.image || 'https://via.placeholder.com/60'}" alt="${item.name}" class="w-16 h-16 rounded-lg object-cover mr-4">
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">${item.name}</div>
                                    <div class="text-sm text-purple-600 font-medium">${formatCurrency(item.price)}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="updateCartQuantity(${item.id}, -1)" class="w-8 h-8 bg-gray-100 rounded-lg hover:bg-gray-200">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span class="w-8 text-center font-medium">${item.quantity}</span>
                                <button onclick="updateCartQuantity(${item.id}, 1)" class="w-8 h-8 bg-gray-100 rounded-lg hover:bg-gray-200">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                                <button onclick="removeFromCart(${item.id})" class="ml-2 w-8 h-8 bg-red-100 text-red-600 rounded-lg hover:bg-red-200">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </div>
                    `).join('')}
                </div>
                <div class="p-6 border-t bg-gray-50">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-lg font-semibold text-gray-900">Total:</span>
                        <span class="text-2xl font-bold text-purple-600">${formatCurrency(totalPrice)}</span>
                    </div>
                    <button onclick="checkout()" class="w-full gradient-bg text-white py-3 rounded-lg font-medium hover:shadow-lg transition">
                        <i class="fas fa-check-circle mr-2"></i>
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', cartHTML);
}

function closeCart() {
    const cartModal = document.querySelector('.fixed.inset-0');
    if (cartModal) {
        cartModal.remove();
    }
}

function updateCartQuantity(productId, change) {
    const item = cartItems.find(i => i.id === productId);
    if (item) {
        item.quantity += change;
        if (item.quantity <= 0) {
            removeFromCart(productId);
        } else {
            closeCart();
            openCart();
            updateCartBadge();
        }
    }
}

function removeFromCart(productId) {
    cartItems = cartItems.filter(item => item.id !== productId);
    updateCartBadge();
    closeCart();
    if (cartItems.length > 0) {
        openCart();
    }
    showNotification('success', 'Produk dihapus dari keranjang');
}

function checkout() {
    showNotification('info', 'Fitur checkout sedang dalam pengembangan');
    closeCart();
}

// ===========================================
// PRODUCT ACTIONS
// ===========================================
function viewProduct(productId) {
    showNotification('info', 'Fitur detail produk sedang dalam pengembangan');
}

function buyAgain(productId) {
    const product = productsData.find(p => p.id === productId);
    if (product) {
        addToCart(new Event('click'), productId);
    } else {
        showNotification('error', 'Produk tidak tersedia');
    }
}

function reviewProduct(productId) {
    showNotification('info', 'Fitur review produk sedang dalam pengembangan');
}

function loadFavoriteProducts() {
    const container = document.getElementById('favorite-products');
    if (container) {
        container.innerHTML = `
            <div class="col-span-4 text-center py-12">
                <i class="fas fa-heart text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 mb-2">Belum ada produk favorit</p>
                <p class="text-sm text-gray-400 mb-4">Klik ikon hati pada produk untuk menambahkan ke favorit</p>
                <button onclick="showSection(event, 'belanja')" class="gradient-bg text-white px-6 py-3 rounded-lg font-medium hover:shadow-lg transition">
                    <i class="fas fa-shopping-bag mr-2"></i>
                    Mulai Belanja
                </button>
            </div>
        `;
    }
}

// ===========================================
// PROFILE FUNCTIONS
// ===========================================
function previewProfilePhoto(event) {
    const file = event.target.files[0];
    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            showNotification('error', 'Ukuran file maksimal 2MB');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('profile-photo-display');
            if (img) {
                img.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
}

async function saveProfile(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    // Check if photo is selected
    const photoInput = document.getElementById('profile-photo-input');
    if (photoInput && photoInput.files[0]) {
        formData.append('photo', photoInput.files[0]);
    }
    
    try {
        const response = await fetch(`${API_BASE}/user/profile`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData
        });
        
        if (!response.ok) throw new Error('Gagal menyimpan profil');
        
        const result = await response.json();
        showNotification('success', 'Profil berhasil diperbarui!');
        
        // Update displayed name
        setTimeout(() => {
            location.reload();
        }, 1500);
    } catch (error) {
        console.error('Error saving profile:', error);
        showNotification('error', 'Gagal menyimpan profil');
    }
}

// ===========================================
// HELPER FUNCTIONS
// ===========================================
function formatCurrency(amount) {
    return 'Rp ' + parseFloat(amount).toLocaleString('id-ID', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffTime = Math.abs(now - date);
    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
    
    if (diffDays === 0) {
        return 'Hari ini';
    } else if (diffDays === 1) {
        return 'Kemarin';
    } else if (diffDays < 7) {
        return `${diffDays} hari yang lalu`;
    } else {
        return date.toLocaleDateString('id-ID', { 
            day: 'numeric', 
            month: 'long', 
            year: 'numeric' 
        });
    }
}

function generateStars(rating) {
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 !== 0;
    const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
    
    let stars = '<div class="flex text-yellow-400 text-sm">';
    
    for (let i = 0; i < fullStars; i++) {
        stars += '<i class="fas fa-star"></i>';
    }
    
    if (hasHalfStar) {
        stars += '<i class="fas fa-star-half-alt"></i>';
    }
    
    for (let i = 0; i < emptyStars; i++) {
        stars += '<i class="far fa-star"></i>';
    }
    
    stars += '</div>';
    return stars;
}

function showNotification(type, message) {
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500',
        warning: 'bg-yellow-500'
    };
    
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Make functions globally available
window.showSection = showSection;
window.addToCart = addToCart;
window.openCart = openCart;
window.closeCart = closeCart;
window.updateCartQuantity = updateCartQuantity;
window.removeFromCart = removeFromCart;
window.checkout = checkout;
window.viewProduct = viewProduct;
window.buyAgain = buyAgain;
window.reviewProduct = reviewProduct;
window.previewProfilePhoto = previewProfilePhoto;
window.saveProfile = saveProfile;
