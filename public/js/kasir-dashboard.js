// Kasir Dashboard JavaScript - Real Data Implementation
// Setup CSRF Token for AJAX
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// API Base URL
const API_BASE = '/api';

// Global Data Storage
let transactionsData = [];
let dashboardStats = {};

// ===========================================
// INITIALIZATION
// ===========================================
document.addEventListener('DOMContentLoaded', function() {
    loadDashboardData();
    setupEventListeners();
});

function setupEventListeners() {
    // Add event listeners here if needed
}

// ===========================================
// LOAD DASHBOARD DATA
// ===========================================
async function loadDashboardData() {
    await Promise.all([
        loadStats(),
        loadRecentTransactions()
    ]);
}

async function loadStats() {
    try {
        const response = await fetch(`${API_BASE}/dashboard/stats`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) throw new Error('Gagal memuat statistik');
        
        dashboardStats = await response.json();
        updateStatsCards();
    } catch (error) {
        console.error('Error loading stats:', error);
        showNotification('error', 'Gagal memuat statistik dashboard');
    }
}

async function loadRecentTransactions() {
    try {
        const response = await fetch(`${API_BASE}/transactions?limit=5&sort=desc`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) throw new Error('Gagal memuat transaksi');
        
        const result = await response.json();
        transactionsData = result.data || result;
        updateTransactionsTable();
    } catch (error) {
        console.error('Error loading transactions:', error);
        showNotification('error', 'Gagal memuat transaksi terbaru');
    }
}

// ===========================================
// UPDATE UI COMPONENTS
// ===========================================
function updateStatsCards() {
    // Update Penjualan Hari Ini
    const salesElement = document.querySelector('[data-stat="sales"]');
    if (salesElement && dashboardStats.today_sales !== undefined) {
        salesElement.textContent = formatCurrency(dashboardStats.today_sales);
    }
    
    // Update Transaksi Hari Ini
    const transactionsElement = document.querySelector('[data-stat="transactions"]');
    if (transactionsElement && dashboardStats.today_transactions !== undefined) {
        transactionsElement.textContent = dashboardStats.today_transactions;
    }
    
    // Update Rata-rata per Transaksi
    const avgElement = document.querySelector('[data-stat="average"]');
    if (avgElement && dashboardStats.average_transaction !== undefined) {
        avgElement.textContent = formatCurrency(dashboardStats.average_transaction);
    }
    
    // Update Item Terjual
    const itemsElement = document.querySelector('[data-stat="items"]');
    if (itemsElement && dashboardStats.today_items_sold !== undefined) {
        itemsElement.textContent = dashboardStats.today_items_sold;
    }
}

function updateTransactionsTable() {
    const tbody = document.querySelector('#transactions-table-body');
    if (!tbody) return;
    
    if (!transactionsData || transactionsData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8" class="py-12 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-400">
                        <i class="fas fa-receipt text-5xl mb-4"></i>
                        <p class="text-lg font-medium">Belum ada transaksi hari ini</p>
                        <p class="text-sm mt-2">Mulai transaksi baru untuk melihat data di sini</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = transactionsData.map(trx => `
        <tr class="border-b hover:bg-gray-50">
            <td class="py-3 px-4 font-medium">#${trx.transaction_number || trx.id}</td>
            <td class="py-3 px-4 text-sm text-gray-600">${formatTime(trx.created_at)}</td>
            <td class="py-3 px-4 text-sm">${trx.customer_name || 'Umum'}</td>
            <td class="py-3 px-4 text-sm">${trx.total_items || 0} item</td>
            <td class="py-3 px-4 font-semibold">${formatCurrency(trx.total_amount)}</td>
            <td class="py-3 px-4 text-sm">${formatPaymentMethod(trx.payment_method)}</td>
            <td class="py-3 px-4">
                <span class="text-xs ${getStatusClass(trx.status)} px-3 py-1 rounded-full">
                    ${formatStatus(trx.status)}
                </span>
            </td>
            <td class="py-3 px-4">
                <button onclick="printReceipt(${trx.id})" class="text-purple-600 hover:text-purple-700" title="Cetak Struk">
                    <i class="fas fa-print"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

// ===========================================
// HELPER FUNCTIONS
// ===========================================
function formatCurrency(amount) {
    if (amount === null || amount === undefined) return 'Rp 0';
    return 'Rp ' + parseFloat(amount).toLocaleString('id-ID');
}

function formatTime(datetime) {
    if (!datetime) return '-';
    const date = new Date(datetime);
    return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
}

function formatPaymentMethod(method) {
    const methods = {
        'cash': 'Tunai',
        'debit': 'Debit',
        'credit': 'Kredit',
        'qris': 'QRIS',
        'transfer': 'Transfer'
    };
    return methods[method] || method;
}

function formatStatus(status) {
    const statuses = {
        'completed': 'Selesai',
        'pending': 'Pending',
        'cancelled': 'Dibatalkan'
    };
    return statuses[status] || status;
}

function getStatusClass(status) {
    const classes = {
        'completed': 'bg-green-100 text-green-700',
        'pending': 'bg-yellow-100 text-yellow-700',
        'cancelled': 'bg-red-100 text-red-700'
    };
    return classes[status] || 'bg-gray-100 text-gray-700';
}

// ===========================================
// ACTIONS
// ===========================================
async function printReceipt(transactionId) {
    try {
        const response = await fetch(`${API_BASE}/transactions/${transactionId}`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) throw new Error('Gagal memuat detail transaksi');
        
        const transaction = await response.json();
        
        // Create print window
        const printWindow = window.open('', '_blank', 'width=800,height=600');
        printWindow.document.write(generateReceiptHTML(transaction));
        printWindow.document.close();
        
        // Wait for content to load then print
        printWindow.onload = function() {
            printWindow.print();
        };
    } catch (error) {
        console.error('Error printing receipt:', error);
        showNotification('error', 'Gagal mencetak struk');
    }
}

function generateReceiptHTML(transaction) {
    return `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Struk - ${transaction.transaction_number}</title>
            <style>
                body { font-family: monospace; padding: 20px; }
                .receipt { max-width: 300px; margin: 0 auto; }
                .header { text-align: center; margin-bottom: 20px; border-bottom: 2px dashed #000; padding-bottom: 10px; }
                .item { display: flex; justify-content: space-between; margin: 5px 0; }
                .total { border-top: 2px dashed #000; margin-top: 10px; padding-top: 10px; font-weight: bold; }
                .footer { text-align: center; margin-top: 20px; border-top: 2px dashed #000; padding-top: 10px; }
            </style>
        </head>
        <body>
            <div class="receipt">
                <div class="header">
                    <h2>PANGARA</h2>
                    <p>Struk Pembelian</p>
                    <p>${new Date(transaction.created_at).toLocaleString('id-ID')}</p>
                    <p>No: ${transaction.transaction_number}</p>
                </div>
                <div class="items">
                    ${(transaction.items || []).map(item => `
                        <div class="item">
                            <span>${item.product_name} x${item.quantity}</span>
                            <span>${formatCurrency(item.subtotal)}</span>
                        </div>
                    `).join('')}
                </div>
                <div class="total">
                    <div class="item">
                        <span>TOTAL</span>
                        <span>${formatCurrency(transaction.total_amount)}</span>
                    </div>
                    <div class="item">
                        <span>Bayar (${formatPaymentMethod(transaction.payment_method)})</span>
                        <span>${formatCurrency(transaction.paid_amount)}</span>
                    </div>
                    <div class="item">
                        <span>Kembalian</span>
                        <span>${formatCurrency(transaction.change_amount)}</span>
                    </div>
                </div>
                <div class="footer">
                    <p>Terima Kasih</p>
                    <p>Selamat Berbelanja Kembali</p>
                </div>
            </div>
        </body>
        </html>
    `;
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
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg ${colors[type] || 'bg-gray-500'} text-white transform transition-all duration-300 translate-x-full`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${icons[type] || 'info-circle'} mr-3"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// ===========================================
// SECTION NAVIGATION
// ===========================================
function showSection(event, sectionName) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    // Sembunyikan semua section
    document.querySelectorAll('.kasir-section').forEach(section => {
        section.classList.add('hidden');
    });
    // Tampilkan section yang dipilih
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
        // Fallback: cari link by data-section
        const activeLink = document.querySelector(`.sidebar-link[data-section="${sectionName}"]`);
        if (activeLink) {
            activeLink.classList.add('bg-purple-600');
            activeLink.classList.remove('hover:bg-gray-800');
        }
    }
    // Jika dashboard, reload data
    if (sectionName === 'dashboard') {
        loadDashboardData();
    }
}

// Make functions globally available
window.printReceipt = printReceipt;
window.showSection = showSection;
window.openProductSearchModal = openProductSearchModal;
window.closeProductSearchModal = closeProductSearchModal;
window.searchProductLive = searchProductLive;
window.openProfileModal = openProfileModal;
window.closeProfileModal = closeProfileModal;
window.previewProfilePhoto = previewProfilePhoto;
window.saveProfile = saveProfile;
// Modal Edit Profile
function openProfileModal() {
    const modal = document.getElementById('profileModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Reset form to current profile data
    const currentName = document.getElementById('profileName').textContent;
    const currentPhoto = document.getElementById('profilePhoto').src;
    
    document.getElementById('editProfileName').value = currentName;
    document.getElementById('editProfilePhoto').src = currentPhoto;
    
    // Reset file input
    document.getElementById('photoInput').value = '';
    
    // Focus on name input after a delay
    setTimeout(() => {
        document.getElementById('editProfileName').focus();
        document.getElementById('editProfileName').select();
    }, 100);
}
function closeProfileModal() {
    document.getElementById('profileModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    // Reset form
    document.getElementById('profileForm').reset();
    document.getElementById('photoInput').value = '';
}
function previewProfilePhoto(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    // Validasi ukuran file (max 2MB)
    if (file.size > 2 * 1024 * 1024) {
        showNotification('error', 'Ukuran foto maksimal 2MB');
        event.target.value = '';
        return;
    }
    
    // Validasi tipe file
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
        showNotification('error', 'Format foto harus JPG, PNG, atau GIF');
        event.target.value = '';
        return;
    }
    
    // Preview foto
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('editProfilePhoto').src = e.target.result;
    };
    reader.readAsDataURL(file);
}
async function saveProfile(e) {
    e.preventDefault();
    const form = document.getElementById('profileForm');
    const formData = new FormData(form);
    
    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    try {
        const response = await fetch('/api/user/profile', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData
        });
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Gagal update profile');
        
        // Update tampilan sidebar
        document.getElementById('profileName').textContent = result.data.name;
        if (result.data.photo_url) {
            document.getElementById('profilePhoto').src = result.data.photo_url;
            document.getElementById('editProfilePhoto').src = result.data.photo_url;
        }
        
        closeProfileModal();
        showNotification('success', 'Profile berhasil diperbarui!');
    } catch (err) {
        showNotification('error', err.message);
    } finally {
        submitBtn.innerHTML = originalBtnText;
        submitBtn.disabled = false;
    }
}

// Modal Cari Produk
function openProductSearchModal() {
    document.getElementById('productSearchModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    document.getElementById('productSearchInput').value = '';
    document.getElementById('productSearchResults').innerHTML = '';
    setTimeout(() => {
        document.getElementById('productSearchInput').focus();
    }, 100);
}
function closeProductSearchModal() {
    document.getElementById('productSearchModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Live Search Produk
let productSearchTimeout = null;
async function searchProductLive() {
    clearTimeout(productSearchTimeout);
    const query = document.getElementById('productSearchInput').value.trim();
    const resultsDiv = document.getElementById('productSearchResults');
    if (!query) {
        resultsDiv.innerHTML = '';
        return;
    }
    resultsDiv.innerHTML = '<div class="text-center py-4 text-gray-400"><i class="fas fa-spinner fa-spin"></i> Mencari produk...</div>';
    productSearchTimeout = setTimeout(async () => {
        try {
            const response = await fetch(`/api/products?search=${encodeURIComponent(query)}`);
            if (!response.ok) throw new Error('Gagal mencari produk');
            const data = await response.json();
            if (!data || !data.data || data.data.length === 0) {
                resultsDiv.innerHTML = '<div class="text-center py-4 text-gray-400">Produk tidak ditemukan</div>';
                return;
            }
            resultsDiv.innerHTML = data.data.map(prod => `
                <div class='p-3 border-b hover:bg-green-50 cursor-pointer flex items-center' onclick='selectProductFromSearch(${JSON.stringify(prod)})'>
                    <div class='flex-1'>
                        <div class='font-semibold text-gray-900'>${prod.name}</div>
                        <div class='text-xs text-gray-500'>Kode: ${prod.code || '-'} | Stok: ${prod.stock ?? '-'}</div>
                    </div>
                    <div class='font-bold text-green-600 ml-4'>${formatCurrency(prod.price)}</div>
                </div>
            `).join('');
        } catch (err) {
            resultsDiv.innerHTML = '<div class="text-center py-4 text-red-400">Gagal mencari produk</div>';
        }
    }, 300);
}

// Pilih produk dari hasil search (bisa diintegrasi ke transaksi baru)
function selectProductFromSearch(prod) {
    closeProductSearchModal();
    showNotification('success', `Produk <b>${prod.name}</b> dipilih!`);
    // TODO: Integrasi ke transaksi baru jika diperlukan
}
