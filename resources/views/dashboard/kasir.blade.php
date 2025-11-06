<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Kasir - Pangara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        
        /* Prevent autocomplete styling */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px white inset !important;
            -webkit-text-fill-color: #111827 !important;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #9333ea;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #7c3aed;
        }
    </style>
</head>
<body class="bg-gray-50">
    
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0">
            <div class="p-6">
                <div class="flex items-center mb-8">
                    <i class="fas fa-cash-register text-2xl mr-2"></i>
                    <span class="text-xl font-bold">Pangara</span>
                </div>
                
                <nav class="space-y-2">
                    <a href="{{ route('kasir.dashboard') }}" class="flex items-center px-4 py-3 bg-purple-600 rounded-lg sidebar-link" data-section="dashboard">
                        <i class="fas fa-home mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" onclick="showSection(event, 'transaction-new')" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition sidebar-link" data-section="transaction-new">
                        <i class="fas fa-shopping-cart mr-3"></i>
                        <span>Transaksi Baru</span>
                    </a>
                    <a href="#" onclick="showSection(event, 'transaction-history')" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition sidebar-link" data-section="transaction-history">
                        <i class="fas fa-receipt mr-3"></i>
                        <span>Riwayat Transaksi</span>
                    </a>
                    <a href="#" onclick="showSection(event, 'product-stock')" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition sidebar-link" data-section="product-stock">
                        <i class="fas fa-box mr-3"></i>
                        <span>Cek Stok Produk</span>
                    </a>
                    <a href="#" onclick="showSection(event, 'daily-report')" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition sidebar-link" data-section="daily-report">
                        <i class="fas fa-chart-bar mr-3"></i>
                        <span>Laporan Harian</span>
                    </a>
                </nav>
            </div>
            
            <div class="absolute bottom-0 w-64 p-6 border-t border-gray-800">
                <div class="flex items-center mb-3">
                    <img id="profilePhoto" src="{{ Auth::user()->photo_url ?? 'https://i.pravatar.cc/40?img=7' }}" class="w-10 h-10 rounded-full mr-3 object-cover" alt="Kasir">
                    <div class="flex-1">
                        <div class="font-medium" id="profileName">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-400">Kasir</div>
                    </div>
                    <button onclick="openProfileModal()" class="ml-2 text-gray-400 hover:text-purple-600" title="Edit Profile"><i class="fas fa-user-edit"></i></button>
    <!-- Modal Edit Profile -->
    <div id="profileModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
            <!-- Header -->
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-6 text-white relative">
                <button onclick="closeProfileModal()" class="absolute top-4 right-4 text-white hover:text-gray-200 text-2xl transition">
                    <i class="fas fa-times"></i>
                </button>
                <div class="flex items-center">
                    <i class="fas fa-user-circle text-3xl mr-3"></i>
                    <div>
                        <h2 class="text-2xl font-bold">Edit Profile</h2>
                        <p class="text-sm text-purple-100">Perbarui informasi profile Anda</p>
                    </div>
                </div>
            </div>
            
            <!-- Body -->
            <form id="profileForm" onsubmit="saveProfile(event)" class="p-6">
                <!-- Foto Profile -->
                <div class="mb-6 flex flex-col items-center">
                    <div class="relative group">
                        <img id="editProfilePhoto" src="{{ Auth::user()->photo_url ?? 'https://i.pravatar.cc/120?img=7' }}" class="w-32 h-32 rounded-full object-cover border-4 border-purple-100 shadow-lg" alt="Profile Preview">
                        <div class="absolute inset-0 rounded-full bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer" onclick="document.getElementById('photoInput').click()">
                            <i class="fas fa-camera text-white text-2xl"></i>
                        </div>
                    </div>
                    <input type="file" id="photoInput" name="photo" accept="image/*" class="hidden" onchange="previewProfilePhoto(event)">
                    <button type="button" onclick="document.getElementById('photoInput').click()" class="mt-4 px-6 py-2 bg-purple-50 text-purple-700 rounded-full hover:bg-purple-100 transition font-semibold text-sm">
                        <i class="fas fa-upload mr-2"></i>Pilih Foto
                    </button>
                    <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG (Max 2MB)</p>
                </div>
                
                <!-- Nama Lengkap -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user text-purple-600 mr-2"></i>Nama Lengkap
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="editProfileName" 
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition text-gray-900 bg-white" 
                        value="{{ Auth::user()->name }}" 
                        placeholder="Masukkan nama lengkap" 
                        required
                        autocomplete="off">
                </div>
                
                <!-- Email (Read-only) -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope text-purple-600 mr-2"></i>Email
                    </label>
                    <input 
                        type="email" 
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-50 text-gray-600 cursor-not-allowed" 
                        value="{{ Auth::user()->email }}" 
                        disabled
                        readonly>
                    <p class="text-xs text-gray-500 mt-1"><i class="fas fa-info-circle mr-1"></i>Email tidak dapat diubah</p>
                </div>
                
                <!-- Buttons -->
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeProfileModal()" class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-semibold">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit" class="flex-1 bg-gradient-to-r from-purple-600 to-purple-700 text-white px-6 py-3 rounded-xl hover:shadow-lg transition font-semibold">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg transition">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between px-8 py-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard Kasir</h1>
                        <p class="text-sm text-gray-600">Kelola transaksi penjualan Anda</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <div class="text-sm text-gray-600">Shift Hari Ini</div>
                            <div class="font-semibold text-gray-900">08:00 - 16:00</div>
                        </div>
                        <button onclick="showSection(event, 'transaction-new')" class="gradient-bg text-white px-6 py-2 rounded-lg font-medium hover:shadow-lg transition">
                            <i class="fas fa-plus mr-2"></i>
                            Transaksi Baru
                        </button>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-8">
                <!-- SECTION: DASHBOARD -->
                <section id="dashboard-section" class="kasir-section">
                    <!-- Stats Cards -->
                    <div class="grid md:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-dollar-sign text-2xl text-blue-600"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 mb-1" data-stat="sales">Rp 0</div>
                            <div class="text-sm text-gray-600">Penjualan Hari Ini</div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-shopping-cart text-2xl text-green-600"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 mb-1" data-stat="transactions">0</div>
                            <div class="text-sm text-gray-600">Transaksi Hari Ini</div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-clock text-2xl text-purple-600"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 mb-1" data-stat="average">Rp 0</div>
                            <div class="text-sm text-gray-600">Rata-rata per Transaksi</div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-box text-2xl text-yellow-600"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 mb-1" data-stat="items">0</div>
                            <div class="text-sm text-gray-600">Item Terjual</div>
                        </div>
                    </div>
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                        <div class="grid md:grid-cols-4 gap-4">
                            <button onclick="showSection(event, 'transaction-new')" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 rounded-xl hover:border-purple-600 hover:bg-purple-50 transition">
                                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-cash-register text-3xl text-purple-600"></i>
                                </div>
                                <span class="font-medium text-gray-900">Transaksi Baru</span>
                            </button>
                            <button onclick="openProductSearchModal()" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 rounded-xl hover:border-green-600 hover:bg-green-50 transition">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-search text-3xl text-green-600"></i>
                                </div>
                                <span class="font-medium text-gray-900">Cari Produk</span>
                            </button>
                            <button onclick="showSection(event, 'product-stock')" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 rounded-xl hover:border-blue-600 hover:bg-blue-50 transition">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-box text-3xl text-blue-600"></i>
                                </div>
                                <span class="font-medium text-gray-900">Cek Stok Produk</span>
                            </button>
                            <button onclick="showSection(event, 'daily-report')" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 rounded-xl hover:border-yellow-600 hover:bg-yellow-50 transition">
                                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-print text-3xl text-yellow-600"></i>
                                </div>
                                <span class="font-medium text-gray-900">Cetak Laporan</span>
                            </button>
    <!-- Modal Cari Produk -->
    <div id="productSearchModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6 relative">
            <button onclick="closeProductSearchModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl"><i class="fas fa-times"></i></button>
            <h2 class="text-xl font-bold mb-4">Cari Produk</h2>
            <input type="text" id="productSearchInput" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 mb-4" placeholder="Ketik nama atau kode produk..." oninput="searchProductLive()">
            <div id="productSearchResults" class="max-h-64 overflow-y-auto"></div>
        </div>
    </div>
                        </div>
                    </div>
                    <!-- Recent Transactions -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Transaksi Terbaru</h3>
                            <a href="#" class="text-sm text-purple-600 hover:text-purple-700">Lihat Semua</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">No. Transaksi</th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Waktu</th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Pelanggan</th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Item</th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Total</th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Metode</th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Status</th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="transactions-table-body">
                                    <tr>
                                        <td colspan="8" class="py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <i class="fas fa-spinner fa-spin text-4xl mb-3"></i>
                                                <p>Memuat data transaksi...</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- SECTION: TRANSAKSI BARU -->
                <section id="transaction-new-section" class="kasir-section hidden">
                    <div class="bg-white rounded-xl shadow-sm p-8 flex flex-col items-center justify-center min-h-[300px]">
                        <i class="fas fa-cash-register text-5xl text-purple-500 mb-4"></i>
                        <h2 class="text-2xl font-bold mb-2">Transaksi Baru</h2>
                        <p class="text-gray-600 mb-4">Fitur transaksi baru akan segera hadir di update berikutnya.</p>
                    </div>
                </section>

                <!-- SECTION: RIWAYAT TRANSAKSI -->
                <section id="transaction-history-section" class="kasir-section hidden">
                    <div class="bg-white rounded-xl shadow-sm p-8 flex flex-col items-center justify-center min-h-[300px]">
                        <i class="fas fa-receipt text-5xl text-green-500 mb-4"></i>
                        <h2 class="text-2xl font-bold mb-2">Riwayat Transaksi</h2>
                        <p class="text-gray-600 mb-4">Fitur riwayat transaksi akan segera hadir di update berikutnya.</p>
                    </div>
                </section>

                <!-- SECTION: CEK STOK PRODUK -->
                <section id="product-stock-section" class="kasir-section hidden">
                    <div class="bg-white rounded-xl shadow-sm p-8 flex flex-col items-center justify-center min-h-[300px]">
                        <i class="fas fa-box text-5xl text-blue-500 mb-4"></i>
                        <h2 class="text-2xl font-bold mb-2">Cek Stok Produk</h2>
                        <p class="text-gray-600 mb-4">Fitur cek stok produk akan segera hadir di update berikutnya.</p>
                    </div>
                </section>

                <!-- SECTION: LAPORAN HARIAN -->
                <section id="daily-report-section" class="kasir-section hidden">
                    <div class="bg-white rounded-xl shadow-sm p-8 flex flex-col items-center justify-center min-h-[300px]">
                        <i class="fas fa-chart-bar text-5xl text-yellow-500 mb-4"></i>
                        <h2 class="text-2xl font-bold mb-2">Laporan Harian</h2>
                        <p class="text-gray-600 mb-4">Fitur laporan harian akan segera hadir di update berikutnya.</p>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <script src="{{ asset('js/kasir-dashboard.js') }}"></script>
</body>
</html>
