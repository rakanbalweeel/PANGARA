// Admin Dashboard JavaScript - Real Data Implementation
// Setup CSRF Token for AJAX
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// API Base URL
const API_BASE = '/api';

// Global Data Storage
let usersData = [];
let productsData = [];
let categoriesData = [];
let currentEditId = null;

// ===========================================
// INITIALIZATION
// ===========================================
document.addEventListener('DOMContentLoaded', function() {
    loadDashboardData();
    setupEventListeners();

    // Load store settings
    loadStoreSettings();

    // Notifikasi & Pesan
    setupNotificationDropdown();
    setupMessageDropdown();
});
// =============================
// NOTIFIKASI & PESAN HEADER
// =============================
function setupNotificationDropdown() {
    const bellBtn = document.querySelector('button .fa-bell')?.parentElement;
    if (!bellBtn) return;
    let notifDropdown = null;
    bellBtn.addEventListener('click', async function(e) {
        e.stopPropagation();
        // Remove existing dropdown
        document.querySelectorAll('.notif-dropdown').forEach(el => el.remove());
        notifDropdown = document.createElement('div');
        notifDropdown.className = 'notif-dropdown absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl z-50 border border-gray-200';
        notifDropdown.innerHTML = '<div class="p-4 font-bold text-gray-900 border-b">Notifikasi</div><div class="p-4 text-center text-gray-400">Memuat...</div>';
        bellBtn.appendChild(notifDropdown);
        // Fetch notifications
        try {
            const res = await fetch('/api/notifications', { headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } });
            const data = await res.json();
            let html = '';
            if (data.length === 0) {
                html = '<div class="p-4 text-center text-gray-400">Tidak ada notifikasi baru.</div>';
            } else {
                html = data.map(n => `
                    <div class="px-4 py-3 border-b last:border-0 flex items-start gap-3 ${n.is_read ? '' : 'bg-purple-50'}">
                        <div class="mt-1"><i class="fas fa-bell text-purple-500"></i></div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">${n.title}</div>
                            <div class="text-sm text-gray-600">${n.body || ''}</div>
                            <div class="text-xs text-gray-400 mt-1">${new Date(n.created_at).toLocaleString('id-ID')}</div>
                        </div>
                        ${!n.is_read ? `<button onclick="markNotifRead(${n.id}, this)" class="ml-2 text-xs text-purple-600 underline">Tandai dibaca</button>` : ''}
                    </div>
                `).join('');
            }
            notifDropdown.innerHTML = '<div class="p-4 font-bold text-gray-900 border-b">Notifikasi</div>' + html;
        } catch (err) {
            notifDropdown.innerHTML = '<div class="p-4 text-center text-red-500">Gagal memuat notifikasi</div>';
        }
    });
    // Close dropdown on click outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.notif-dropdown').forEach(el => el.remove());
    });
}

window.markNotifRead = async function(id, btn) {
    try {
        await fetch(`/api/notifications/${id}/read`, { method: 'PUT', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } });
        btn.closest('.bg-purple-50')?.classList.remove('bg-purple-50');
        btn.remove();
    } catch (err) {
        showNotification('error', 'Gagal update notifikasi');
    }
}

function setupMessageDropdown() {
    const msgBtn = document.querySelector('button .fa-envelope')?.parentElement;
    if (!msgBtn) return;
    let msgDropdown = null;
    msgBtn.addEventListener('click', async function(e) {
        e.stopPropagation();
        document.querySelectorAll('.msg-dropdown').forEach(el => el.remove());
        msgDropdown = document.createElement('div');
        msgDropdown.className = 'msg-dropdown absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl z-50 border border-gray-200';
        msgDropdown.innerHTML = '<div class="p-4 font-bold text-gray-900 border-b">Pesan</div><div class="p-4 text-center text-gray-400">Memuat...</div>';
        msgBtn.appendChild(msgDropdown);
        // Fetch messages
        try {
            const res = await fetch('/api/messages', { headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } });
            const data = await res.json();
            let html = '';
            if (data.length === 0) {
                html = '<div class="p-4 text-center text-gray-400">Tidak ada pesan baru.</div>';
            } else {
                html = data.map(m => `
                    <div class="px-4 py-3 border-b last:border-0 flex items-start gap-3 ${m.is_read ? '' : 'bg-blue-50'}">
                        <div class="mt-1"><i class="fas fa-envelope text-blue-500"></i></div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">${m.subject || 'Pesan Baru'}</div>
                            <div class="text-sm text-gray-600">${m.body.slice(0, 60)}${m.body.length > 60 ? '...' : ''}</div>
                            <div class="text-xs text-gray-400 mt-1">${new Date(m.created_at).toLocaleString('id-ID')}</div>
                        </div>
                        ${!m.is_read ? `<button onclick="markMsgRead(${m.id}, this)" class="ml-2 text-xs text-blue-600 underline">Tandai dibaca</button>` : ''}
                    </div>
                `).join('');
            }
            msgDropdown.innerHTML = '<div class="p-4 font-bold text-gray-900 border-b">Pesan</div>' + html;
        } catch (err) {
            msgDropdown.innerHTML = '<div class="p-4 text-center text-red-500">Gagal memuat pesan</div>';
        }
    });
    document.addEventListener('click', function() {
        document.querySelectorAll('.msg-dropdown').forEach(el => el.remove());
    });
}

window.markMsgRead = async function(id, btn) {
    try {
        await fetch(`/api/messages/${id}/read`, { method: 'PUT', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } });
        btn.closest('.bg-blue-50')?.classList.remove('bg-blue-50');
        btn.remove();
    } catch (err) {
        showNotification('error', 'Gagal update pesan');
    }
}
// =============================
// STORE SETTINGS (Toko & Notifikasi)
// =============================
async function loadStoreSettings() {
    try {
        const res = await fetch(`${API_BASE}/settings`, {
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        });
        if (!res.ok) throw new Error('Gagal mengambil pengaturan toko');
        const data = await res.json();
        // Isi form toko
        document.getElementById('store_name').value = data.store_name || '';
        document.getElementById('address').value = data.address || '';
        document.getElementById('phone').value = data.phone || '';
        // Isi notifikasi
        document.getElementById('notif_email').checked = !!data.notif_email;
        document.getElementById('notif_stock').checked = !!data.notif_stock;
        document.getElementById('notif_daily_report').checked = !!data.notif_daily_report;
    } catch (err) {
        showNotification('error', err.message);
    }
}

// Simpan pengaturan toko & notifikasi
document.addEventListener('DOMContentLoaded', function() {
    const storeForm = document.getElementById('store-settings-form');
    const notifForm = document.getElementById('notification-settings-form');
    if (storeForm) {
        storeForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            await saveStoreSettings();
        });
    }
    if (notifForm) {
        notifForm.addEventListener('change', async function(e) {
            // Auto-save on toggle
            await saveStoreSettings();
        });
    }
});

async function saveStoreSettings() {
    const store_name = document.getElementById('store_name').value;
    const address = document.getElementById('address').value;
    const phone = document.getElementById('phone').value;
    const notif_email = document.getElementById('notif_email').checked ? 1 : 0;
    const notif_stock = document.getElementById('notif_stock').checked ? 1 : 0;
    const notif_daily_report = document.getElementById('notif_daily_report').checked ? 1 : 0;
    try {
        const res = await fetch(`${API_BASE}/settings`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ store_name, address, phone, notif_email, notif_stock, notif_daily_report })
        });
        const data = await res.json();
        if (!res.ok || !data.success) throw new Error('Gagal menyimpan pengaturan');
        showNotification('success', 'Pengaturan berhasil disimpan!');
    } catch (err) {
        showNotification('error', err.message);
    }
}

// ===========================================
// DATA LOADING FUNCTIONS
// ===========================================
async function loadDashboardData() {
    try {
        await Promise.all([
            loadStats(),
            loadUsers(),
            loadProducts(),
            loadCategories(),
            loadTransactions()
        ]);
    } catch (error) {
        console.error('Error loading dashboard data:', error);
        showNotification('error', 'Gagal memuat data dashboard');
    }
}

async function loadStats() {
    try {
        const response = await fetch(`${API_BASE}/dashboard/stats`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) throw new Error('Failed to fetch stats');
        
        const data = await response.json();
        updateStatsDisplay(data);
    } catch (error) {
        console.error('Error loading stats:', error);
    }
}

async function loadUsers() {
    try {
        const response = await fetch(`${API_BASE}/users`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) throw new Error('Failed to fetch users');
        
    usersData = await response.json();
    updateUsersTable();
    updateRecentUsers();
    // Update sidebar badge
    const badge = document.getElementById('sidebar-users-count');
    if (badge) badge.textContent = usersData.length.toLocaleString('id-ID');
    } catch (error) {
        console.error('Error loading users:', error);
        updateRecentUsers();
    }
}

async function loadProducts() {
    try {
        const response = await fetch(`${API_BASE}/products`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) throw new Error('Failed to fetch products');
        
    productsData = await response.json();
    updateProductsGrid();
    // Refresh chart Produk Terlaris jika ada chart.js
    if (typeof Chart !== 'undefined') {
        const productCtx = document.getElementById('productChart');
        if (productCtx) {
            // Hapus chart lama jika ada
            if (window.productChartInstance) { window.productChartInstance.destroy(); }
            // Ambil top 5 produk terlaris
            const sorted = [...productsData].sort((a, b) => (b.sold || b.qty_sold || 0) - (a.sold || a.qty_sold || 0));
            const topProducts = sorted.slice(0, 5);
            const labels = topProducts.map(p => p.name);
            const data = topProducts.map(p => p.sold || p.qty_sold || 0);
            window.productChartInstance = new Chart(productCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Terjual (unit)',
                        data: data,
                        backgroundColor: [
                            'rgba(102, 126, 234, 0.8)',
                            'rgba(118, 75, 162, 0.8)',
                            'rgba(240, 147, 251, 0.8)',
                            'rgba(79, 172, 254, 0.8)',
                            'rgba(67, 233, 123, 0.8)'
                        ],
                        borderColor: [
                            '#667eea',
                            '#764ba2',
                            '#f093fb',
                            '#4facfe',
                            '#43e97b'
                        ],
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                font: { size: 12, family: 'Poppins' },
                                padding: 15
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: { size: 14, family: 'Poppins' },
                            bodyFont: { size: 13, family: 'Poppins' }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { font: { size: 11, family: 'Poppins' } },
                            grid: { color: 'rgba(0, 0, 0, 0.05)' }
                        },
                        x: {
                            ticks: { font: { size: 11, family: 'Poppins' } },
                            grid: { display: false }
                        }
                    }
                }
            });
        }
    }
    // Update sidebar badge
    const badge = document.getElementById('sidebar-products-count');
    if (badge) badge.textContent = productsData.length.toLocaleString('id-ID');
    } catch (error) {
        console.error('Error loading products:', error);
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
        
        if (!response.ok) throw new Error('Failed to fetch categories');
        
    categoriesData = await response.json();
    updateCategoriesGrid();
    updateCategoryOptions();
    // Update sidebar badge kategori
    const badge = document.getElementById('sidebar-categories-count');
    if (badge) badge.textContent = categoriesData.length.toLocaleString('id-ID');
    } catch (error) {
        console.error('Error loading categories:', error);
    }
}


let transactionsData = [];
async function loadTransactions() {
    try {
        const response = await fetch(`${API_BASE}/transactions`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        if (!response.ok) throw new Error('Gagal mengambil data transaksi');
        transactionsData = await response.json();
        updateTransactionsTable();
    updateRecentTransactions();
        // Update sidebar badge
        const badge = document.getElementById('sidebar-transactions-count');
        if (badge) badge.textContent = transactionsData.length.toLocaleString('id-ID');
    } catch (e) {
        transactionsData = [];
        updateTransactionsTable();
        updateRecentTransactions();
        const badge = document.getElementById('sidebar-transactions-count');
        if (badge) badge.textContent = '0';
    }
}

function updateTransactionsTable() {
    const tbody = document.querySelector('#transactions-table-body');
    if (!tbody) return;
    if (transactionsData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-400">
                        <i class="fas fa-receipt text-5xl mb-4"></i>
                        <p class="text-lg font-medium">Belum ada transaksi</p>
                        <p class="text-sm">Transaksi akan muncul di sini setelah ada pembelian</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    tbody.innerHTML = transactionsData.map(trx => {
        // Format badge pembayaran
        let payBadge = '';
        if (trx.payment_method === 'Cash') payBadge = '<span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-bold">Cash</span>';
        else if (trx.payment_method === 'E-Wallet') payBadge = '<span class="bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-xs font-bold">E-Wallet</span>';
        else if (trx.payment_method === 'Transfer') payBadge = '<span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold">Transfer</span>';
        else payBadge = `<span class='bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold'>${trx.payment_method}</span>`;

        // Format badge status
        let statusBadge = '';
        if (trx.payment_status === 'completed' || trx.payment_status === 'berhasil') statusBadge = '<span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold"><i class="fas fa-check-circle mr-1"></i>Berhasil</span>';
        else if (trx.payment_status === 'pending') statusBadge = '<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold"><i class="fas fa-clock mr-1"></i>Pending</span>';
        else if (trx.payment_status === 'cancelled') statusBadge = '<span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold"><i class="fas fa-times-circle mr-1"></i>Batal</span>';
        else statusBadge = `<span class='bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold'>${trx.payment_status}</span>`;

        // Format waktu (contoh: 2 jam lalu)
        let waktu = '-';
        if (trx.created_at) {
            const created = new Date(trx.created_at);
            const now = new Date();
            const diffMs = now - created;
            const diffH = Math.floor(diffMs / (1000*60*60));
            if (diffH < 1) waktu = 'Baru saja';
            else waktu = diffH + ' jam lalu';
        }

        return `<tr>
            <td class="px-6 py-4 font-semibold text-purple-600">${trx.transaction_code}</td>
            <td class="px-6 py-4 font-medium">${trx.user?.name || '-'}</td>
            <td class="px-6 py-4 font-bold text-gray-900">Rp ${parseInt(trx.total_amount).toLocaleString('id-ID')}</td>
            <td class="px-6 py-4">${payBadge}</td>
            <td class="px-6 py-4">${statusBadge}</td>
            <td class="px-6 py-4">${waktu}</td>
            <td class="px-6 py-4 flex gap-2">
                <button class="text-blue-600 hover:text-blue-700 mr-3" title="Lihat"><i class="fas fa-eye"></i></button>
                <button class="text-purple-600 hover:text-purple-700" title="Print"><i class="fas fa-print"></i></button>
            </td>
        </tr>`;
    }).join('');
}

// ===========================================
// UPDATE DISPLAY FUNCTIONS
// ===========================================
function updateStatsDisplay(data) {
    // Update sales
    document.querySelector('[data-stat="sales"]').textContent = 
        `Rp ${(data.total_sales / 1000000).toFixed(1)} Jt`;
    document.querySelector('[data-growth="sales"]').innerHTML = 
        `<i class="fas fa-arrow-${data.sales_growth >= 0 ? 'up' : 'down'} mr-1"></i>${Math.abs(data.sales_growth)}%`;
    document.querySelector('[data-growth="sales"]').className = 
        `text-sm font-bold ${data.sales_growth >= 0 ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100'} px-3 py-1 rounded-full`;
    
    // Update transactions
    document.querySelector('[data-stat="transactions"]').textContent = data.total_transactions;
    document.querySelector('[data-growth="transactions"]').innerHTML = 
        `<i class="fas fa-arrow-${data.transactions_growth >= 0 ? 'up' : 'down'} mr-1"></i>${Math.abs(data.transactions_growth)}%`;
    document.querySelector('[data-growth="transactions"]').className = 
        `text-sm font-bold ${data.transactions_growth >= 0 ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100'} px-3 py-1 rounded-full`;
    
    // Update products
    document.querySelector('[data-stat="products"]').textContent = data.total_products;
    document.querySelector('[data-growth="products"]').innerHTML = 
        `<i class="fas fa-arrow-${data.products_growth >= 0 ? 'up' : 'down'} mr-1"></i>${Math.abs(data.products_growth)}%`;
    
    // Update users
    document.querySelector('[data-stat="users"]').textContent = data.total_users.toLocaleString('id-ID');
    document.querySelector('[data-growth="users"]').innerHTML = 
        `<i class="fas fa-arrow-${data.users_growth >= 0 ? 'up' : 'down'} mr-1"></i>${Math.abs(data.users_growth)}%`;
}

function updateUsersTable() {
    const tbody = document.querySelector('#users-table-body');
    if (!tbody) return;
    
    if (!usersData || usersData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-400">
                        <i class="fas fa-users text-5xl mb-4"></i>
                        <p class="text-lg font-medium">Belum ada pengguna</p>
                        <p class="text-sm">Tambahkan pengguna pertama dengan klik tombol di atas</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = usersData.map(user => `
        <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4">
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=random" 
                         class="w-10 h-10 rounded-full mr-3 border-2 border-purple-500" alt="${user.name}">
                    <span class="font-semibold">${user.name}</span>
                </div>
            </td>
            <td class="px-6 py-4 text-gray-600">${user.email}</td>
            <td class="px-6 py-4">
                <span class="bg-${getRoleColor(user.role)}-100 text-${getRoleColor(user.role)}-700 px-3 py-1 rounded-full text-sm font-semibold">
                    ${user.role.charAt(0).toUpperCase() + user.role.slice(1)}
                </span>
            </td>
            <td class="px-6 py-4">
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                    <i class="fas fa-check-circle mr-1"></i>Aktif
                </span>
            </td>
            <td class="px-6 py-4">
                <button onclick="editUser(${user.id})" class="text-blue-600 hover:text-blue-700 mr-3">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="deleteUser(${user.id})" class="text-red-600 hover:text-red-700">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

function updateProductsGrid() {
    const grid = document.querySelector('#products-grid');
    if (!grid) return;
    
    if (productsData.length === 0) {
        grid.innerHTML = `
            <div class="col-span-4 text-center py-12">
                <div class="flex flex-col items-center justify-center text-gray-400">
                    <i class="fas fa-box-open text-5xl mb-4"></i>
                    <p class="text-lg font-medium">Belum ada produk</p>
                    <p class="text-sm">Tambahkan produk pertama dengan klik tombol di atas</p>
                </div>
            </div>
        `;
        return;
    }
    
    grid.innerHTML = productsData.map(product => {
        // determine product type badge (prefer explicit type, otherwise infer from category)
        const typeRaw = (product.type || product.category || '').toLowerCase();
        let typeLabel = '';
        let typeColor = 'green';
        if (typeRaw.includes('makanan')) { typeLabel = 'Makanan'; typeColor = 'red'; }
        else if (typeRaw.includes('minuman')) { typeLabel = 'Minuman'; typeColor = 'blue'; }

        return `
        <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-purple-500 hover:shadow-lg transition relative" data-id="${product.id}" data-sku="${product.sku || ''}" data-name="${(product.name || '').toLowerCase()}">
            <img src="${product.image || 'https://via.placeholder.com/200'}" 
                 class="w-full h-40 object-cover rounded-lg mb-3" alt="${product.name}">

            <div class="flex items-start justify-between mb-2">
                <div class="flex items-center gap-2">
                    ${typeLabel ? `<span class="text-xs font-semibold px-2 py-1 rounded-full bg-${typeColor}-100 text-${typeColor}-700">${typeLabel}</span>` : ''}
                    <h3 class="font-bold text-gray-900">${product.name}</h3>
                </div>
                <div class="text-sm text-purple-600 font-semibold">ID: #${product.id}</div>
            </div>

            <div class="flex items-center justify-between mb-2">
                <div class="text-xs text-gray-500">SKU: ${product.sku || '-'}</div>
                <button onclick="copySKU('${product.sku || ''}', ${product.id})" class="text-xs text-gray-600 hover:text-gray-800 bg-gray-100 px-2 py-1 rounded-lg border border-gray-200">
                    <i class="fas fa-copy mr-1"></i> Salin
                </button>
            </div>

            <p class="text-sm text-gray-600 mb-2">Kategori: ${product.category}</p>
            <div class="flex items-center justify-between mb-3">
                <span class="text-lg font-bold text-purple-600">Rp ${parseFloat(product.price).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>
                <span class="text-sm text-gray-500">Stok: ${product.stock}</span>
            </div>
            <div class="flex gap-2">
                <button onclick="editProduct(${product.id})" class="flex-1 bg-blue-100 text-blue-700 py-2 rounded-lg hover:bg-blue-200 transition text-sm font-semibold">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button onclick="deleteProduct(${product.id})" class="flex-1 bg-red-100 text-red-700 py-2 rounded-lg hover:bg-red-200 transition text-sm font-semibold">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        </div>
        `;
    }).join('');
}

// Search / Filter products by name or SKU (client-side)
function setupProductSearch() {
    const input = document.querySelector('header input[placeholder="Cari..."]');
    if (!input) return;

    input.addEventListener('input', function() {
        const q = this.value.trim().toLowerCase();
        const grid = document.querySelector('#products-grid');
        if (!grid) return;
        const cards = Array.from(grid.children);
        if (!q) {
            cards.forEach(c => c.style.display = '');
            return;
        }

        cards.forEach(card => {
            const name = (card.getAttribute('data-name') || '').toLowerCase();
            const sku = (card.getAttribute('data-sku') || '').toLowerCase();
            const idStr = String(card.getAttribute('data-id') || '').toLowerCase();
            // allow partial match on name, sku, or id
            if (name.includes(q) || sku.includes(q) || idStr.includes(q)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
}

function updateCategoriesGrid() {
    const grid = document.querySelector('#categories-grid');
    if (!grid) return;
    
    if (!categoriesData || categoriesData.length === 0) {
        grid.innerHTML = `
            <div class="col-span-4 text-center py-12">
                <div class="flex flex-col items-center justify-center text-gray-400">
                    <i class="fas fa-tags text-5xl mb-4"></i>
                    <p class="text-lg font-medium">Belum ada kategori</p>
                    <p class="text-sm">Tambahkan kategori pertama dengan klik tombol di atas</p>
                </div>
            </div>
        `;
        return;
    }
    
    const colors = ['blue', 'green', 'purple', 'yellow', 'red', 'indigo'];
    
    grid.innerHTML = categoriesData.map((category, index) => {
        const color = colors[index % colors.length];
        return `
            <div class="bg-gradient-to-br from-${color}-50 to-${color}-100 p-6 rounded-xl border-2 border-${color}-200 hover:border-${color}-500 hover:shadow-lg transition">
                <div class="w-16 h-16 bg-${color}-600 rounded-xl flex items-center justify-center mb-4 shadow-lg">
                    <i class="fas ${category.icon} text-3xl text-white"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">${category.name}</h3>
                <p class="text-sm text-gray-600 mb-4">${category.products_count || 0} Produk</p>
                <div class="flex gap-2">
                    <button onclick="editCategory(${category.id})" class="flex-1 bg-white text-${color}-700 py-2 rounded-lg hover:bg-${color}-50 transition text-sm font-semibold">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="deleteCategory(${category.id})" class="flex-1 bg-white text-red-700 py-2 rounded-lg hover:bg-red-50 transition text-sm font-semibold">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
    }).join('');
}

function updateCategoryOptions() {
    const selects = document.querySelectorAll('select[name="category"]');
    selects.forEach(select => {
        select.innerHTML = '<option value="">Pilih Kategori</option>' +
            categoriesData.map(cat => `<option value="${cat.name}">${cat.name}</option>`).join('');
    });
}

function updateRecentUsers() {
    // Update recent users widget on dashboard
    const recentUsersContainer = document.querySelector('#recent-users-list');
    if (!recentUsersContainer) return;
    if (!usersData || usersData.length === 0) {
        recentUsersContainer.innerHTML = '<div class="text-center text-gray-400 py-4">Belum ada pengguna baru.</div>';
        return;
    }
    const recent = usersData.slice(0, 3);
    recentUsersContainer.innerHTML = recent.map(user => `
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
            <div class="flex items-center">
                <img src=\"https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=random\" class=\"w-12 h-12 rounded-full mr-4 border-2 border-purple-500\" alt=\"User\">
                <div>
                    <div class=\"font-semibold text-gray-900\">${user.name}</div>
                    <div class=\"text-sm text-gray-500\">${user.role.charAt(0).toUpperCase() + user.role.slice(1)}</div>
                </div>
            </div>
            <span class=\"text-xs bg-green-100 text-green-700 px-3 py-1.5 rounded-full font-semibold\">
                <i class=\"fas fa-check-circle mr-1\"></i>Aktif
            </span>
        </div>
    `).join('');
}

function updateRecentTransactions() {
    // Update recent transactions widget on dashboard
    const recentTransactionsContainer = document.querySelector('#recent-transactions-list');
    if (!recentTransactionsContainer) return;
    if (!transactionsData || transactionsData.length === 0) {
        recentTransactionsContainer.innerHTML = '<div class="text-center text-gray-400 py-4">Belum ada transaksi terbaru.</div>';
        return;
    }
    const recent = transactionsData.slice(0, 3);
    recentTransactionsContainer.innerHTML = recent.map(trx => {
        // Icon dan warna status
        let icon = 'fa-check';
        let bg = 'from-green-500 to-green-600';
        if (trx.payment_status === 'pending') { icon = 'fa-clock'; bg = 'from-yellow-500 to-yellow-600'; }
        // Format waktu
        let waktu = '-';
        if (trx.created_at) {
            const created = new Date(trx.created_at);
            const now = new Date();
            const diffMs = now - created;
            const diffH = Math.floor(diffMs / (1000*60*60));
            if (diffH < 1) waktu = 'Baru saja';
            else waktu = diffH + ' jam lalu';
        }
        return `
            <div class=\"flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition\">
                <div class=\"flex items-center\">
                    <div class=\"w-12 h-12 bg-gradient-to-br ${bg} rounded-xl flex items-center justify-center mr-4 shadow\">
                        <i class=\"fas ${icon} text-white text-lg\"></i>
                    </div>
                    <div>
                        <div class=\"font-semibold text-gray-900\">${trx.transaction_code}</div>
                        <div class=\"text-sm text-gray-500\">${trx.user?.name || '-'}<\/div>
                    </div>
                </div>
                <div class=\"text-right\">
                    <div class=\"font-bold text-gray-900\">Rp ${parseInt(trx.total_amount).toLocaleString('id-ID')}</div>
                    <div class=\"text-xs text-gray-500\">${waktu}</div>
                </div>
            </div>
        `;
    }).join('');
}

function updateRecentUsers() {
    // Update recent users widget on dashboard
    const recentUsersContainer = document.querySelector('#recent-users-widget');
    if (!recentUsersContainer || usersData.length === 0) return;
    
    const recent = usersData.slice(0, 3);
    // Implementation for recent users widget...
}

// ===========================================
// CRUD OPERATIONS - USERS
// ===========================================
function resetUserForm() {
    currentEditId = null;
    const form = document.getElementById('userForm');
    if (form) {
        form.reset();
        // Make password required for new user
        const passwordField = form.querySelector('[name="password"]');
        if (passwordField) {
            passwordField.setAttribute('required', 'required');
        }
    }
    // Reset modal title
    const modalTitle = document.querySelector('#addUserModal h3');
    if (modalTitle) {
        modalTitle.innerHTML = '<i class="fas fa-user-plus mr-2"></i>Tambah Pengguna Baru';
    }
}

async function saveUser(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    
    // Remove password if empty (for edit)
    if (!data.password) {
        delete data.password;
    }
    
    const method = currentEditId ? 'PUT' : 'POST';
    const url = currentEditId ? `${API_BASE}/users/${currentEditId}` : `${API_BASE}/users`;
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (!response.ok) {
            throw new Error(result.message || 'Gagal menyimpan user');
        }
        
        showNotification('success', result.message);
        // Use global closeModal function
        if (typeof closeModal === 'function') {
            closeModal('addUserModal');
        }
        form.reset();
        currentEditId = null;
        await loadUsers();
    } catch (error) {
        showNotification('error', error.message);
    }
}

async function editUser(id) {
    currentEditId = id;
    const user = usersData.find(u => u.id === id);
    if (!user) return;
    
    // Populate form
    const form = document.querySelector('#addUserModal form');
    form.querySelector('[name="name"]').value = user.name;
    form.querySelector('[name="email"]').value = user.email;
    form.querySelector('[name="role"]').value = user.role;
    
    // Make password optional and clear it
    const passwordField = form.querySelector('[name="password"]');
    passwordField.value = '';
    passwordField.removeAttribute('required');
    
    // Change modal title
    document.querySelector('#addUserModal h3').innerHTML = 
        '<i class="fas fa-user-edit mr-2"></i>Edit Pengguna';
    
    // Use global openModal function
    if (typeof openModal === 'function') {
        openModal('addUserModal');
    }
}

async function deleteUser(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus user ini?')) return;
    
    try {
        const response = await fetch(`${API_BASE}/users/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        const result = await response.json();
        
        if (!response.ok) {
            throw new Error(result.message || 'Gagal menghapus user');
        }
        
        showNotification('success', result.message);
        await loadUsers();
    } catch (error) {
        showNotification('error', error.message);
    }
}

// ===========================================
// CRUD OPERATIONS - PRODUCTS
// ===========================================
async function saveProduct(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    const isEdit = Boolean(currentEditId);
    // If editing, Laravel expects PUT; use POST with _method=PUT in FormData for multipart
    if (isEdit) {
        formData.append('_method', 'PUT');
    }

    const url = isEdit ? `${API_BASE}/products/${currentEditId}` : `${API_BASE}/products`;

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData,
            credentials: 'same-origin'
        });

        let result = {};
        let errorText = '';
        try {
            result = await response.json();
        } catch (e) {
            errorText = await response.text();
        }

        if (!response.ok) {
            // Tampilkan pesan error asli dari backend jika ada
            let msg = (result && result.message) ? result.message : '';
            if (!msg && errorText) msg = errorText;
            if (!msg && response.status === 401) msg = 'Unauthenticated: Silakan login ulang.';
            if (!msg) msg = 'Gagal menyimpan produk';
            showNotification('error', msg);
            alert(msg);
            return;
        }

        showNotification('success', result.message);
        closeModal('addProductModal');
        form.reset();
        currentEditId = null;
        await loadProducts();
    } catch (error) {
        showNotification('error', error.message);
        alert(error.message);
    }
}

async function editProduct(id) {
    currentEditId = id;
    const product = productsData.find(p => p.id === id);
    if (!product) return;
    
    // Populate form
    const form = document.querySelector('#addProductModal form');
    form.querySelector('[name="name"]').value = product.name;
    form.querySelector('[name="description"]').value = product.description || '';
    form.querySelector('[name="category"]').value = product.category;
    form.querySelector('[name="price"]').value = product.price;
    form.querySelector('[name="stock"]').value = product.stock;
    
    // Change modal title
    document.querySelector('#addProductModal h3').innerHTML = 
        '<i class="fas fa-box-open mr-2"></i>Edit Produk';
    
    openModal('addProductModal');
}

async function deleteProduct(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus produk ini?')) return;
    
    try {
        const response = await fetch(`${API_BASE}/products/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        const result = await response.json();
        
        if (!response.ok) {
            throw new Error(result.message || 'Gagal menghapus produk');
        }
        
        showNotification('success', result.message);
        await loadProducts();
    } catch (error) {
        showNotification('error', error.message);
    }
}

// ===========================================
// CRUD OPERATIONS - CATEGORIES
// ===========================================
async function saveCategory(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    
    const method = currentEditId ? 'PUT' : 'POST';
    const url = currentEditId ? `${API_BASE}/categories/${currentEditId}` : `${API_BASE}/categories`;
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (!response.ok) {
            throw new Error(result.message || 'Gagal menyimpan kategori');
        }
        
        showNotification('success', result.message);
        closeModal('addCategoryModal');
        form.reset();
        currentEditId = null;
        await loadCategories();
    } catch (error) {
        showNotification('error', error.message);
    }
}

async function editCategory(id) {
    currentEditId = id;
    const category = categoriesData.find(c => c.id === id);
    if (!category) return;
    
    // Populate form
    const form = document.querySelector('#addCategoryModal form');
    form.querySelector('[name="name"]').value = category.name;
    form.querySelector('[name="description"]').value = category.description || '';
    form.querySelector('[name="icon"]').value = category.icon || '';
    
    // Change modal title
    document.querySelector('#addCategoryModal h3').innerHTML = 
        '<i class="fas fa-tag mr-2"></i>Edit Kategori';
    
    openModal('addCategoryModal');
}

async function deleteCategory(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus kategori ini?')) return;
    
    try {
        const response = await fetch(`${API_BASE}/categories/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        const result = await response.json();
        
        if (!response.ok) {
            throw new Error(result.message || 'Gagal menghapus kategori');
        }
        
        showNotification('success', result.message);
        await loadCategories();
    } catch (error) {
        showNotification('error', error.message);
    }
}

// ===========================================
// UTILITY FUNCTIONS
// ===========================================
function getRoleColor(role) {
    const colors = {
        'admin': 'purple',
        'kasir': 'blue',
        'pembeli': 'green'
    };
    return colors[role] || 'gray';
}

function showNotification(type, message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } text-white font-semibold`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-2"></i>
            ${message}
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Copy SKU to clipboard with feedback
function copySKU(sku, id) {
    if (!sku) {
        showNotification('error', `SKU kosong untuk produk #${id}`);
        return;
    }

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(sku).then(() => {
            showNotification('success', 'SKU disalin ke clipboard');
        }).catch(err => {
            console.error('Clipboard write failed', err);
            fallbackCopy(sku);
        });
    } else {
        fallbackCopy(sku);
    }

    function fallbackCopy(text) {
        try {
            const ta = document.createElement('textarea');
            ta.value = text;
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            ta.remove();
            showNotification('success', 'SKU disalin ke clipboard');
        } catch (e) {
            console.error('Fallback copy failed', e);
            showNotification('error', 'Gagal menyalin SKU');
        }
    }
}

function setupEventListeners() {
    // Form submissions
    document.querySelector('#addUserModal form')?.addEventListener('submit', saveUser);
    document.querySelector('#addProductModal form')?.addEventListener('submit', saveProduct);
    document.querySelector('#addCategoryModal form')?.addEventListener('submit', saveCategory);

    // Reset currentEditId when opening new forms
    document.querySelectorAll('[onclick*="openModal"]').forEach(btn => {
        btn.addEventListener('click', () => {
            currentEditId = null;
            // Reset modal titles
            setTimeout(() => {
                document.querySelector('#addUserModal h3').innerHTML = 
                    '<i class="fas fa-user-plus mr-2"></i>Tambah Pengguna Baru';
                document.querySelector('#addProductModal h3').innerHTML = 
                    '<i class="fas fa-box-open mr-2"></i>Tambah Produk Baru';
                document.querySelector('#addCategoryModal h3').innerHTML = 
                    '<i class="fas fa-tag mr-2"></i>Tambah Kategori Baru';
            }, 100);
        });
    });

    // Setup product search filter
    setupProductSearch();

    // Export transactions to CSV
    const exportBtn = document.getElementById('export-transactions-btn');
    if (exportBtn) {
        exportBtn.addEventListener('click', exportTransactionsToCSV);
    }
// Export transactions to CSV/Excel
function exportTransactionsToCSV() {
    if (!transactionsData || transactionsData.length === 0) {
        showNotification('error', 'Tidak ada data transaksi untuk diexport');
        return;
    }
    // Define CSV headers
    const headers = [
        'ID Transaksi',
        'Pelanggan',
        'Total',
        'Pembayaran',
        'Status',
        'Waktu'
    ];
    // Build CSV rows
    const rows = transactionsData.map(trx => [
        trx.transaction_code,
        trx.user?.name || '-',
        `Rp ${parseInt(trx.total_amount).toLocaleString('id-ID')}`,
        trx.payment_method,
        trx.payment_status,
        trx.created_at || '-'
    ]);
    // Combine headers and rows
    const csvContent = [headers, ...rows]
        .map(e => e.map(field => '"' + String(field).replace(/"/g, '""') + '"').join(','))
        .join('\r\n');
    // Download as file
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.setAttribute('href', url);
    link.setAttribute('download', 'daftar_transaksi.csv');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
    showNotification('success', 'Data transaksi berhasil diexport!');
}
}

// Make functions globally available
window.resetUserForm = resetUserForm;
window.saveUser = saveUser;
window.editUser = editUser;
window.deleteUser = deleteUser;
window.editProduct = editProduct;
window.deleteProduct = deleteProduct;
window.editCategory = editCategory;
window.deleteCategory = deleteCategory;
