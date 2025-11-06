<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Pembeli - Pangara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
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
                    <a href="#" onclick="showSection(event, 'dashboard')" class="flex items-center px-4 py-3 bg-purple-600 rounded-lg sidebar-link" data-section="dashboard">
                        <i class="fas fa-home mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" onclick="showSection(event, 'belanja')" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition sidebar-link" data-section="belanja">
                        <i class="fas fa-shopping-bag mr-3"></i>
                        <span>Belanja</span>
                    </a>
                    <a href="#" onclick="showSection(event, 'riwayat')" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition sidebar-link" data-section="riwayat">
                        <i class="fas fa-history mr-3"></i>
                        <span>Riwayat Pembelian</span>
                    </a>
                    <a href="#" onclick="showSection(event, 'favorit')" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition sidebar-link" data-section="favorit">
                        <i class="fas fa-heart mr-3"></i>
                        <span>Favorit</span>
                    </a>
                    <a href="#" onclick="showSection(event, 'profil')" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition sidebar-link" data-section="profil">
                        <i class="fas fa-user mr-3"></i>
                        <span>Profil</span>
                    </a>
                </nav>
            </div>
            
            <div class="absolute bottom-0 w-64 p-6 border-t border-gray-800">
                <div class="flex items-center mb-3">
                    <img src="https://i.pravatar.cc/40?img=9" class="w-10 h-10 rounded-full mr-3" alt="Pembeli">
                    <div class="flex-1">
                        <div class="font-medium">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-400">Pembeli</div>
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
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard Pembeli</h1>
                        <p class="text-sm text-gray-600">Selamat berbelanja, {{ Auth::user()->name }}!</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button data-cart-btn class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <span data-cart-badge class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center" style="display: none;">0</span>
                        </button>
                        <button onclick="showSection(event, 'belanja')" class="gradient-bg text-white px-6 py-2 rounded-lg font-medium hover:shadow-lg transition">
                            <i class="fas fa-shopping-bag mr-2"></i>
                            Mulai Belanja
                        </button>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-8">
                
                <!-- Dashboard Section -->
                <div id="dashboard-section" class="pembeli-section">
                <!-- Stats Cards -->
                <div class="grid md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-shopping-bag text-2xl text-blue-600"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 mb-1" data-stat="purchases">0</div>
                        <div class="text-sm text-gray-600">Total Pembelian</div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-dollar-sign text-2xl text-green-600"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 mb-1" data-stat="spending">Rp 0</div>
                        <div class="text-sm text-gray-600">Total Belanja</div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-heart text-2xl text-purple-600"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 mb-1" data-stat="favorites">0</div>
                        <div class="text-sm text-gray-600">Produk Favorit</div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-star text-2xl text-yellow-600"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 mb-1" data-stat="rewards">0</div>
                        <div class="text-sm text-gray-600">Poin Reward</div>
                    </div>
                </div>

                <!-- Promo Banner -->
                <div class="gradient-bg rounded-xl shadow-lg p-8 mb-8 text-white">
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <div>
                            <h2 class="text-3xl font-bold mb-4">Promo Spesial Hari Ini!</h2>
                            <p class="text-purple-100 mb-6">Dapatkan diskon hingga 50% untuk produk pilihan. Buruan sebelum kehabisan!</p>
                            <button onclick="showPromoModal()" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-medium hover:bg-purple-50 transition">
                                Lihat Promo
                            </button>
                        </div>
                        <div class="text-right">
                            <div class="text-6xl font-bold mb-2">50%</div>
                            <div class="text-xl">Diskon Maksimal</div>
                        </div>
                    </div>
                </div>

                <!-- Products -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">Produk Terpopuler</h3>
                        <a href="#" onclick="showSection(event, 'belanja')" class="text-sm text-purple-600 hover:text-purple-700">Lihat Semua</a>
                    </div>
                    <div id="products-grid" class="grid md:grid-cols-4 gap-6">
                        <div class="col-span-4 text-center py-12">
                            <i class="fas fa-spinner fa-spin text-4xl text-purple-500 mb-3"></i>
                            <p class="text-gray-500">Memuat produk...</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Purchases -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Riwayat Pembelian Terakhir</h3>
                        <a href="#" onclick="showSection(event, 'riwayat')" class="text-sm text-purple-600 hover:text-purple-700">Lihat Semua</a>
                    </div>
                    <div id="purchase-history" class="space-y-4">
                        <div class="text-center py-12">
                            <i class="fas fa-spinner fa-spin text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-500">Memuat riwayat pembelian...</p>
                        </div>
                    </div>
                </div>
                </div>
                <!-- End Dashboard Section -->

                <!-- Belanja Section -->
                <div id="belanja-section" class="pembeli-section" style="display: none;">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Belanja Produk</h2>
                        
                        <!-- Search and Filter -->
                        <div class="flex gap-4 mb-6">
                            <div class="flex-1 relative">
                                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" id="search-product" placeholder="Cari produk..." class="w-full pl-12 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
                            </div>
                            <select id="category-filter" class="px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
                                <option value="">Semua Kategori</option>
                            </select>
                            <select id="sort-product" class="px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
                                <option value="popular">Terpopuler</option>
                                <option value="newest">Terbaru</option>
                                <option value="price-low">Harga Terendah</option>
                                <option value="price-high">Harga Tertinggi</option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="all-products-grid" class="grid md:grid-cols-4 gap-6">
                        <div class="col-span-4 text-center py-12">
                            <i class="fas fa-spinner fa-spin text-4xl text-purple-500 mb-3"></i>
                            <p class="text-gray-500">Memuat produk...</p>
                        </div>
                    </div>
                </div>
                <!-- End Belanja Section -->

                <!-- Riwayat Section -->
                <div id="riwayat-section" class="pembeli-section" style="display: none;">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Riwayat Pembelian</h2>
                        <div id="all-purchase-history" class="space-y-4">
                            <div class="text-center py-12">
                                <i class="fas fa-spinner fa-spin text-4xl text-gray-400 mb-3"></i>
                                <p class="text-gray-500">Memuat riwayat pembelian...</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Riwayat Section -->

                <!-- Favorit Section -->
                <div id="favorit-section" class="pembeli-section" style="display: none;">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Produk Favorit</h2>
                        <div id="favorite-products" class="grid md:grid-cols-4 gap-6">
                            <div class="col-span-4 text-center py-12">
                                <i class="fas fa-heart text-6xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500 mb-2">Belum ada produk favorit</p>
                                <button onclick="showSection(event, 'belanja')" class="text-purple-600 hover:text-purple-700 font-medium">
                                    Mulai Belanja
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Favorit Section -->

                <!-- Profil Section -->
                <div id="profil-section" class="pembeli-section" style="display: none;">
                    <div class="max-w-2xl mx-auto">
                        <div class="bg-white rounded-xl shadow-sm p-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Profil Saya</h2>
                            
                            <div class="flex items-center mb-8">
                                <div class="relative">
                                    <img id="profile-photo-display" src="https://i.pravatar.cc/100?img=9" class="w-24 h-24 rounded-full object-cover" alt="Profile">
                                    <button onclick="document.getElementById('profile-photo-input').click()" class="absolute bottom-0 right-0 w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center hover:bg-purple-700">
                                        <i class="fas fa-camera text-sm"></i>
                                    </button>
                                    <input type="file" id="profile-photo-input" accept="image/*" class="hidden" onchange="previewProfilePhoto(event)">
                                </div>
                                <div class="ml-6">
                                    <h3 class="text-xl font-semibold text-gray-900">{{ Auth::user()->name }}</h3>
                                    <p class="text-gray-600">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            
                            <form id="profile-form" onsubmit="saveProfile(event)">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                        <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500" required>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500" required>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                        <input type="tel" name="phone" value="{{ Auth::user()->phone ?? '' }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500" placeholder="08xxxxxxxxxx">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                        <textarea name="address" rows="3" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500" placeholder="Masukkan alamat lengkap">{{ Auth::user()->address ?? '' }}</textarea>
                                    </div>
                                    
                                    <div class="border-t pt-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ubah Password</h3>
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                                <input type="password" name="password" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500" placeholder="Kosongkan jika tidak ingin mengubah">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                                                <input type="password" name="password_confirmation" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500" placeholder="Ulangi password baru">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex gap-4 pt-4">
                                        <button type="submit" class="flex-1 gradient-bg text-white px-6 py-3 rounded-lg font-medium hover:shadow-lg transition">
                                            <i class="fas fa-save mr-2"></i>
                                            Simpan Perubahan
                                        </button>
                                        <button type="button" onclick="showSection(event, 'dashboard')" class="px-6 py-3 border border-gray-300 rounded-lg font-medium hover:bg-gray-50 transition">
                                            Batal
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Profil Section -->

            </main>
        </div>
    </div>

    <!-- Promo Modal -->
    <div id="promoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-hidden">
            <div class="gradient-bg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-3xl font-bold mb-2">🎉 Promo Spesial Hari Ini!</h3>
                        <p class="text-purple-100">Jangan lewatkan penawaran terbaik kami</p>
                    </div>
                    <button onclick="closePromoModal()" class="text-white hover:text-purple-200 transition">
                        <i class="fas fa-times text-3xl"></i>
                    </button>
                </div>
            </div>
            
            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <div class="grid md:grid-cols-2 gap-6" id="promo-products-grid">
                    <!-- Promo products will be loaded here -->
                    <div class="col-span-2 text-center py-12">
                        <i class="fas fa-spinner fa-spin text-4xl text-purple-500 mb-3"></i>
                        <p class="text-gray-500">Memuat produk promo...</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6 bg-gray-50 border-t">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-clock mr-2"></i>
                        Promo berlaku hari ini saja!
                    </div>
                    <button onclick="showSection(event, 'belanja'); closePromoModal();" class="gradient-bg text-white px-6 py-3 rounded-lg font-medium hover:shadow-lg transition">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Lihat Semua Produk
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/pembeli-dashboard.js') }}"></script>
</body>
</html>
