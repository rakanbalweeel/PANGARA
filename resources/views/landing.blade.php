<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pangara - Sistem Kasir Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .hero-image {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .feature-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Navigation -->
    <nav class="bg-white shadow-sm fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <i class="fas fa-cash-register text-purple-600 text-2xl mr-2"></i>
                    <span class="text-2xl font-bold text-gray-800">Pangara</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-purple-600 font-medium">Home</a>
                    <a href="#features" class="text-gray-700 hover:text-purple-600 font-medium">Fitur</a>
                    <a href="#pricing" class="text-gray-700 hover:text-purple-600 font-medium">Harga</a>
                    <a href="#about" class="text-gray-700 hover:text-purple-600 font-medium">Tentang</a>
                    <a href="#contact" class="text-gray-700 hover:text-purple-600 font-medium">Kontak</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-purple-600 font-medium hover:text-purple-700">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">Daftar Gratis</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="pt-24 pb-12 md:pt-32 md:pb-20 bg-gradient-to-br from-purple-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center bg-purple-100 text-purple-700 px-4 py-2 rounded-full mb-6">
                        <i class="fas fa-store mr-2"></i>
                        <span class="text-sm font-medium">Khusus Toko Sembako</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                        Sistem Kasir <br>
                        <span class="text-purple-600">Toko Sembako</span>
                    </h1>
                    <p class="text-lg text-gray-600 mb-8">
                        Kelola toko sembako Anda dengan lebih mudah. Catat stok barang, transaksi harian, dan laporan penjualan secara digital.
                    </p>
                    <div class="flex items-center space-x-4">
                        <button class="gradient-bg text-white px-8 py-4 rounded-lg font-medium hover:shadow-lg transition flex items-center">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Mulai Sekarang
                        </button>
                        <div class="flex -space-x-2">
                            <img src="https://i.pravatar.cc/40?img=1" class="w-10 h-10 rounded-full border-2 border-white" alt="User">
                            <img src="https://i.pravatar.cc/40?img=2" class="w-10 h-10 rounded-full border-2 border-white" alt="User">
                            <img src="https://i.pravatar.cc/40?img=3" class="w-10 h-10 rounded-full border-2 border-white" alt="User">
                        </div>
                        <div class="flex items-center">
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="ml-2 text-sm text-gray-600">(4.8)</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="hero-image bg-gradient-to-br from-purple-100 to-blue-200 rounded-3xl p-12 shadow-2xl">
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="bg-white p-6 rounded-2xl shadow-lg text-center transform hover:scale-105 transition">
                                <i class="fas fa-shopping-bag text-4xl text-purple-600 mb-3"></i>
                                <div class="text-2xl font-bold text-gray-900">2.4K+</div>
                                <div class="text-xs text-gray-500">Transaksi</div>
                            </div>
                            <div class="bg-white p-6 rounded-2xl shadow-lg text-center transform hover:scale-105 transition">
                                <i class="fas fa-boxes text-4xl text-blue-600 mb-3"></i>
                                <div class="text-2xl font-bold text-gray-900">500+</div>
                                <div class="text-xs text-gray-500">Produk</div>
                            </div>
                            <div class="bg-white p-6 rounded-2xl shadow-lg text-center transform hover:scale-105 transition">
                                <i class="fas fa-users text-4xl text-green-600 mb-3"></i>
                                <div class="text-2xl font-bold text-gray-900">1.2K+</div>
                                <div class="text-xs text-gray-500">Pelanggan</div>
                            </div>
                        </div>
                        <div class="bg-white p-8 rounded-2xl shadow-xl">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-chart-line text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500">Omzet Hari Ini</div>
                                        <div class="text-3xl font-bold text-purple-600">Rp 3.5 Jt</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center text-green-600 font-semibold">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        <span>+25%</span>
                                    </div>
                                    <div class="text-xs text-gray-500">dari kemarin</div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="flex-1 bg-purple-100 rounded-lg p-3 text-center">
                                    <i class="fas fa-receipt text-purple-600 mb-1"></i>
                                    <div class="text-sm font-semibold text-gray-700">148 Transaksi</div>
                                </div>
                                <div class="flex-1 bg-blue-100 rounded-lg p-3 text-center">
                                    <i class="fas fa-clock text-blue-600 mb-1"></i>
                                    <div class="text-sm font-semibold text-gray-700">Buka 24/7</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-white" id="features">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <div class="flex items-center mb-2">
                        <i class="fas fa-th-large text-purple-600 mr-2"></i>
                        <span class="text-purple-600 font-medium">Fitur Unggulan</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Jelajahi Fitur Kami</h2>
                </div>
                <div class="flex space-x-2">
                    <button class="w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center hover:border-purple-600 hover:text-purple-600 transition">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <button class="w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center hover:border-purple-600 hover:text-purple-600 transition">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-6">
                <div class="flex flex-col items-center p-6 bg-gray-50 rounded-xl card-hover cursor-pointer">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-3">
                        <i class="fas fa-receipt text-3xl text-blue-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Transaksi</span>
                </div>
                <div class="flex flex-col items-center p-6 bg-gray-50 rounded-xl card-hover cursor-pointer">
                    <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mb-3">
                        <i class="fas fa-box text-3xl text-purple-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Inventori</span>
                </div>
                <div class="flex flex-col items-center p-6 bg-gray-50 rounded-xl card-hover cursor-pointer">
                    <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mb-3">
                        <i class="fas fa-chart-line text-3xl text-green-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Laporan</span>
                </div>
                <div class="flex flex-col items-center p-6 bg-gray-50 rounded-xl card-hover cursor-pointer">
                    <div class="w-16 h-16 bg-yellow-100 rounded-xl flex items-center justify-center mb-3">
                        <i class="fas fa-users text-3xl text-yellow-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Pelanggan</span>
                </div>
                <div class="flex flex-col items-center p-6 bg-gray-50 rounded-xl card-hover cursor-pointer">
                    <div class="w-16 h-16 bg-red-100 rounded-xl flex items-center justify-center mb-3">
                        <i class="fas fa-qrcode text-3xl text-red-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Barcode</span>
                </div>
                <div class="flex flex-col items-center p-6 bg-gray-50 rounded-xl card-hover cursor-pointer">
                    <div class="w-16 h-16 bg-indigo-100 rounded-xl flex items-center justify-center mb-3">
                        <i class="fas fa-credit-card text-3xl text-indigo-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Pembayaran</span>
                </div>
                <div class="flex flex-col items-center p-6 bg-gray-50 rounded-xl card-hover cursor-pointer">
                    <div class="w-16 h-16 bg-pink-100 rounded-xl flex items-center justify-center mb-3">
                        <i class="fas fa-mobile-alt text-3xl text-pink-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Mobile</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Promo Banner -->
    <section class="py-16 bg-gradient-to-br from-purple-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    <div class="p-12">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-headphones text-purple-600 mr-2"></i>
                            <span class="text-purple-600 font-medium">Best Offer</span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                            Tingkatkan Pengalaman <br>Bisnis Anda
                        </h2>
                        <div class="grid grid-cols-4 gap-4 mb-8">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-gray-900">16</div>
                                <div class="text-sm text-gray-500">Hari</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-gray-900">10</div>
                                <div class="text-sm text-gray-500">Jam</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-gray-900">56</div>
                                <div class="text-sm text-gray-500">Menit</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-gray-900">04</div>
                                <div class="text-sm text-gray-500">Detik</div>
                            </div>
                        </div>
                        <button class="gradient-bg text-white px-8 py-4 rounded-lg font-medium hover:shadow-lg transition">
                            Cek Promo
                        </button>
                    </div>
                    <div class="relative p-12">
                        <div class="bg-gradient-to-br from-purple-100 to-blue-200 rounded-2xl p-8 shadow-2xl">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                                    <i class="fas fa-percentage text-4xl text-purple-600 mb-2"></i>
                                    <div class="text-2xl font-bold text-gray-900">50%</div>
                                    <div class="text-xs text-gray-500">Diskon Max</div>
                                </div>
                                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                                    <i class="fas fa-shipping-fast text-4xl text-blue-600 mb-2"></i>
                                    <div class="text-2xl font-bold text-gray-900">Gratis</div>
                                    <div class="text-xs text-gray-500">Ongkir</div>
                                </div>
                                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                                    <i class="fas fa-shield-alt text-4xl text-green-600 mb-2"></i>
                                    <div class="text-2xl font-bold text-gray-900">100%</div>
                                    <div class="text-xs text-gray-500">Aman</div>
                                </div>
                                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                                    <i class="fas fa-star text-4xl text-yellow-500 mb-2"></i>
                                    <div class="text-2xl font-bold text-gray-900">4.9</div>
                                    <div class="text-xs text-gray-500">Rating</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-16 bg-white" id="pricing">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <div class="flex items-center mb-2">
                        <i class="fas fa-gifts text-purple-600 mr-2"></i>
                        <span class="text-purple-600 font-medium">Paket Sembako Kami</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Pilih Paket Sembako Terbaik</h2>
                </div>
                <div class="flex space-x-2">
                    <button class="w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center hover:border-purple-600 hover:text-purple-600 transition">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <button class="w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center hover:border-purple-600 hover:text-purple-600 transition">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Paket Sembako 1 - Paket Hemat -->
                <div class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1586201375761-83865001e31c?w=400&h=250&fit=crop" 
                             alt="Paket Sembako Hemat - Beras, Minyak, Gula, Telur" 
                             class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3">
                            <span class="bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-full">
                                <i class="fas fa-fire mr-1"></i>Hot
                            </span>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                            </div>
                            <span class="text-gray-600 text-sm font-medium">(458)</span>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Paket Sembako Hemat</h3>
                        <p class="text-sm text-gray-500 mb-4">Paket kebutuhan dasar sehari-hari untuk keluarga kecil</p>
                        
                        <div class="mb-4">
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="text-2xl font-bold text-purple-600">Rp 150K</span>
                                <span class="text-sm text-gray-400 line-through">Rp 175K</span>
                            </div>
                        </div>
                        
                        <div class="space-y-2 mb-5">
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                <span>Beras 5 Kg</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                <span>Minyak Goreng 2 Liter</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                <span>Gula Pasir 1 Kg</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                <span>Telur 1 Kg</span>
                            </div>
                        </div>
                        
                        <button class="w-full bg-purple-600 text-white py-3 rounded-xl font-semibold hover:bg-purple-700 transition-all duration-300 shadow-md hover:shadow-lg">
                            <i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang
                        </button>
                    </div>
                </div>

                <!-- Paket Sembako 2 - Paket Keluarga (Terlaris) -->
                <div class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 relative border-2 border-purple-400">
                    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 z-20">
                        <span class="bg-gradient-to-r from-purple-500 to-purple-600 text-white text-xs font-bold px-5 py-1.5 rounded-full shadow-lg">
                            <i class="fas fa-heart mr-1"></i>Favorit
                        </span>
                    </div>
                    <div class="relative overflow-hidden mt-3">
                        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?w=400&h=250&fit=crop" 
                             alt="Paket Sembako Keluarga - Beras Premium, Minyak, Gula, Telur, Tepung, Kecap" 
                             class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3">
                            <span class="bg-green-500 text-white text-xs font-bold px-3 py-1.5 rounded-full">
                                Save 20%
                            </span>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                            </div>
                            <span class="text-gray-900 text-sm font-bold">(1.234)</span>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Paket Sembako Keluarga</h3>
                        <p class="text-sm text-gray-500 mb-4">Paket lengkap untuk keluarga 4-5 orang</p>
                        
                        <div class="mb-4">
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="text-2xl font-bold text-purple-600">Rp 280K</span>
                                <span class="text-sm text-gray-400 line-through">Rp 350K</span>
                            </div>
                        </div>
                        
                        <div class="space-y-2 mb-5">
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-purple-500 mr-2 text-xs"></i>
                                <span>Beras 10 Kg Premium</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-purple-500 mr-2 text-xs"></i>
                                <span>Minyak Goreng 5 Liter</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-purple-500 mr-2 text-xs"></i>
                                <span>Gula Pasir 2 Kg</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-purple-500 mr-2 text-xs"></i>
                                <span>Telur 2 Kg</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-purple-500 mr-2 text-xs"></i>
                                <span>Tepung Terigu 1 Kg</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-purple-500 mr-2 text-xs"></i>
                                <span>Kecap Manis 600ml</span>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-purple-800 transition-all duration-300 shadow-md hover:shadow-lg">
                            <i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang
                        </button>
                    </div>
                </div>

                <!-- Paket Sembako 3 - Paket Ramadan -->
                <div class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1609220136736-443b28975370?w=400&h=250&fit=crop" 
                             alt="Paket Sembako Ramadan - Beras, Kurma, Susu, Sirup" 
                             class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3">
                            <span class="bg-blue-500 text-white text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1">
                                <i class="fas fa-moon"></i>
                                Ramadan
                            </span>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star-half-alt text-sm"></i>
                            </div>
                            <span class="text-gray-600 text-sm font-medium">(892)</span>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Paket Sembako Ramadan</h3>
                        <p class="text-sm text-gray-500 mb-4">Paket spesial bulan suci Ramadan</p>
                        
                        <div class="mb-4">
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="text-2xl font-bold text-indigo-600">Rp 450K</span>
                                <span class="text-sm text-gray-400 line-through">Rp 550K</span>
                            </div>
                        </div>
                        
                        <div class="space-y-2 mb-5">
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-blue-500 mr-2 text-xs"></i>
                                <span>Beras 15 Kg Premium</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-blue-500 mr-2 text-xs"></i>
                                <span>Minyak Goreng 5 Liter</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-blue-500 mr-2 text-xs"></i>
                                <span>Gula Pasir 3 Kg</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-blue-500 mr-2 text-xs"></i>
                                <span>Kurma 500gr</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-blue-500 mr-2 text-xs"></i>
                                <span>Susu Kental Manis</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-blue-500 mr-2 text-xs"></i>
                                <span>Sirup 1 Liter</span>
                            </div>
                        </div>
                        
                        <button class="w-full bg-indigo-600 text-white py-3 rounded-xl font-semibold hover:bg-indigo-700 transition-all duration-300 shadow-md hover:shadow-lg">
                            <i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang
                        </button>
                    </div>
                </div>

                <!-- Paket Sembako 4 - Paket Premium -->
                <div class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 border-2 border-yellow-400">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1610348725531-843dff563e2c?w=400&h=250&fit=crop" 
                             alt="Paket Sembako Premium - Beras Premium, Daging Ayam, Sayuran Segar" 
                             class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3">
                            <span class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1">
                                <i class="fas fa-crown"></i>
                                Exclusive
                            </span>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                            </div>
                            <span class="text-gray-600 text-sm font-medium">(567)</span>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Paket Sembako Premium</h3>
                        <p class="text-sm text-gray-500 mb-4">Paket super lengkap & berkualitas terbaik</p>
                        
                        <div class="mb-4">
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="text-2xl font-bold text-orange-600">Rp 650K</span>
                            </div>
                        </div>
                        
                        <div class="space-y-2 mb-5">
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-orange-500 mr-2 text-xs"></i>
                                <span>Beras Premium 20 Kg</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-orange-500 mr-2 text-xs"></i>
                                <span>Minyak Goreng 10 Liter</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-orange-500 mr-2 text-xs"></i>
                                <span>Gula Pasir 5 Kg</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-orange-500 mr-2 text-xs"></i>
                                <span>Telur 3 Kg</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-orange-500 mr-2 text-xs"></i>
                                <span>Daging Ayam 2 Kg</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-check-circle text-orange-500 mr-2 text-xs"></i>
                                <span>+ Bumbu Lengkap</span>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-yellow-500 to-orange-500 text-white py-3 rounded-xl font-semibold hover:from-yellow-600 hover:to-orange-600 transition-all duration-300 shadow-md hover:shadow-lg">
                            <i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <button class="border-2 border-purple-600 text-purple-600 px-8 py-3 rounded-lg font-medium hover:bg-purple-600 hover:text-white transition">
                    <i class="fas fa-gifts mr-2"></i>Lihat Semua Paket Sembako
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-cash-register text-purple-500 text-2xl mr-2"></i>
                            </span>
                        </div>
                        <img src="https://images.unsplash.com/photo-1609501676725-7186f017a4b0?w=400&h=300&fit=crop" 
                             alt="Paket Sembako Hemat" 
                             class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <span class="text-gray-600 text-sm ml-2 font-medium">(458)</span>
                            </div>
                            <div class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-fire mr-1"></i>Hot
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Paket Sembako Hemat</h3>
                        <p class="text-sm text-gray-600 mb-4">Paket kebutuhan dasar sehari-hari untuk keluarga kecil</p>
                        <div class="flex items-baseline space-x-2 mb-5">
                            <span class="text-3xl font-bold text-purple-600">Rp 150K</span>
                            <span class="text-base text-gray-400 line-through">Rp 175K</span>
                        </div>
                        <div class="mb-6 space-y-2.5 bg-gray-50 rounded-xl p-4">
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-green-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Beras 5 Kg</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-green-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Minyak Goreng 2 Liter</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-green-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Gula Pasir 1 Kg</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-green-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Telur 1 Kg</span>
                            </div>
                        </div>
                        <button class="w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white py-3.5 rounded-xl font-semibold hover:from-purple-700 hover:to-purple-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang
                        </button>
                    </div>
                </div>

                <!-- Paket Sembako 2 - Paket Keluarga (Terlaris) -->
                <div class="group bg-gradient-to-br from-purple-50 to-blue-50 rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 relative border-2 border-purple-500">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-20">
                        <span class="bg-gradient-to-r from-purple-600 to-purple-700 text-white text-sm font-bold px-6 py-2 rounded-full shadow-xl">
                            <i class="fas fa-crown mr-1"></i>Terlaris
                        </span>
                    </div>
                    <div class="relative overflow-hidden mt-4">
                        <div class="absolute top-4 right-4 z-10">
                            <span class="bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg animate-pulse">
                                <i class="fas fa-medal mr-1"></i>Best Seller
                            </span>
                        </div>
                        <img src="https://images.unsplash.com/photo-1588964895597-cfccd6e2dbf9?w=400&h=300&fit=crop" 
                             alt="Paket Sembako Keluarga" 
                             class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <span class="text-gray-700 text-sm ml-2 font-bold">(1.234)</span>
                            </div>
                            <div class="bg-purple-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-heart mr-1"></i>Favorit
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Paket Sembako Keluarga</h3>
                        <p class="text-sm text-gray-700 mb-4 font-medium">Paket lengkap untuk keluarga 4-5 orang</p>
                        <div class="flex items-baseline space-x-2 mb-5">
                            <span class="text-3xl font-bold text-purple-600">Rp 280K</span>
                            <span class="text-base text-gray-500 line-through">Rp 350K</span>
                            <span class="text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-full">Save 20%</span>
                        </div>
                        <div class="mb-6 space-y-2.5 bg-white rounded-xl p-4 shadow-sm">
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-purple-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Beras 10 Kg Premium</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-purple-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Minyak Goreng 5 Liter</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-purple-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Gula Pasir 2 Kg</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-purple-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Telur 2 Kg</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-purple-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Tepung Terigu 1 Kg</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-purple-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Kecap Manis 600ml</span>
                            </div>
                        </div>
                        <button class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3.5 rounded-xl font-bold hover:from-purple-700 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang
                        </button>
                    </div>
                </div>

                <!-- Paket Sembako 3 - Paket Ramadan -->
                <div class="group bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative overflow-hidden">
                        <div class="absolute top-4 right-4 z-10">
                            <span class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg">
                                <i class="fas fa-gift mr-1"></i>Promo Spesial
                            </span>
                        </div>
                        <img src="https://images.unsplash.com/photo-1609220136736-443b28975370?w=400&h=300&fit=crop" 
                             alt="Paket Sembako Ramadan" 
                             class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star-half-alt text-sm"></i>
                                <span class="text-gray-600 text-sm ml-2 font-medium">(892)</span>
                            </div>
                            <div class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-moon mr-1"></i>Ramadan
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Paket Sembako Ramadan</h3>
                        <p class="text-sm text-gray-600 mb-4">Paket spesial bulan suci Ramadan</p>
                        <div class="flex items-baseline space-x-2 mb-5">
                            <span class="text-3xl font-bold text-indigo-600">Rp 450K</span>
                            <span class="text-base text-gray-400 line-through">Rp 550K</span>
                        </div>
                        <div class="mb-6 space-y-2.5 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-4">
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-indigo-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Beras 15 Kg Premium</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-indigo-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Minyak Goreng 5 Liter</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-indigo-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Gula Pasir 3 Kg</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-indigo-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Kurma 500gr</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-indigo-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Susu Kental Manis</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-indigo-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Sirup 1 Liter</span>
                            </div>
                        </div>
                        <button class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3.5 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang
                        </button>
                    </div>
                </div>

                <!-- Paket Sembako 4 - Paket Premium -->
                <div class="group bg-gradient-to-br from-yellow-50 to-amber-50 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-yellow-300">
                    <div class="relative overflow-hidden">
                        <div class="absolute top-4 right-4 z-10">
                            <span class="bg-gradient-to-r from-yellow-500 to-amber-500 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg">
                                <i class="fas fa-gem mr-1"></i>Premium
                            </span>
                        </div>
                        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?w=400&h=300&fit=crop" 
                             alt="Paket Sembako Premium" 
                             class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-amber-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <span class="text-gray-700 text-sm ml-2 font-medium">(567)</span>
                            </div>
                            <div class="bg-gradient-to-r from-yellow-500 to-amber-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-star mr-1"></i>Exclusive
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Paket Sembako Premium</h3>
                        <p class="text-sm text-gray-700 mb-4 font-medium">Paket super lengkap & berkualitas terbaik</p>
                        <div class="flex items-baseline space-x-2 mb-5">
                            <span class="text-3xl font-bold bg-gradient-to-r from-yellow-600 to-amber-600 bg-clip-text text-transparent">Rp 650K</span>
                        </div>
                        <div class="mb-6 space-y-2.5 bg-white rounded-xl p-4 shadow-sm">
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-amber-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-amber-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Beras Premium 20 Kg</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-amber-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-amber-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Minyak Goreng 10 Liter</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-amber-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-amber-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Gula Pasir 5 Kg</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-amber-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-amber-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Telur 3 Kg</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-amber-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-amber-600 text-xs"></i>
                                </div>
                                <span class="font-medium">Daging Ayam 2 Kg</span>
                            </div>
                            <div class="text-sm text-gray-700 flex items-center">
                                <div class="w-6 h-6 bg-amber-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-amber-600 text-xs"></i>
                                </div>
                                <span class="font-medium">+ Bumbu Lengkap</span>
                            </div>
                        </div>
                        <button class="w-full bg-gradient-to-r from-yellow-500 to-amber-500 text-white py-3.5 rounded-xl font-bold hover:from-yellow-600 hover:to-amber-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <button class="border-2 border-purple-600 text-purple-600 px-8 py-3 rounded-lg font-medium hover:bg-purple-600 hover:text-white transition">
                    <i class="fas fa-gifts mr-2"></i>Lihat Semua Paket Sembako
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-cash-register text-purple-500 text-2xl mr-2"></i>
                        <span class="text-2xl font-bold text-white">Pangara</span>
                    </div>
                    <p class="text-sm mb-4">Solusi kasir digital terbaik untuk bisnis Anda. Mudah, cepat, dan terpercaya.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-purple-600 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-purple-600 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-purple-600 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-purple-600 transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Produk</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-purple-500">Fitur</a></li>
                        <li><a href="#" class="hover:text-purple-500">Harga</a></li>
                        <li><a href="#" class="hover:text-purple-500">Demo</a></li>
                        <li><a href="#" class="hover:text-purple-500">Integrasi</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Perusahaan</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-purple-500">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-purple-500">Karir</a></li>
                        <li><a href="#" class="hover:text-purple-500">Blog</a></li>
                        <li><a href="#" class="hover:text-purple-500">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Dukungan</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-purple-500">Help Center</a></li>
                        <li><a href="#" class="hover:text-purple-500">Dokumentasi</a></li>
                        <li><a href="#" class="hover:text-purple-500">Tutorial</a></li>
                        <li><a href="#" class="hover:text-purple-500">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; 2025 Pangara. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Mobile menu toggle (if needed)
        const mobileMenuBtn = document.createElement('button');
        mobileMenuBtn.className = 'md:hidden text-gray-700 hover:text-purple-600';
        mobileMenuBtn.innerHTML = '<i class="fas fa-bars text-2xl"></i>';

        // Countdown timer for promo
        function updateCountdown() {
            const now = new Date();
            const endOfDay = new Date(now);
            endOfDay.setHours(23, 59, 59, 999);
            
            const diff = endOfDay - now;
            
            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            document.querySelectorAll('.grid.grid-cols-4')[0]?.querySelectorAll('.text-3xl').forEach((el, index) => {
                if (index === 0) el.textContent = '00'; // Days (static for demo)
                if (index === 1) el.textContent = String(hours).padStart(2, '0');
                if (index === 2) el.textContent = String(minutes).padStart(2, '0');
                if (index === 3) el.textContent = String(seconds).padStart(2, '0');
            });
        }

        // Update countdown every second
        setInterval(updateCountdown, 1000);
        updateCountdown();

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all cards
        document.querySelectorAll('.card-hover').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });

        // Buy button handlers
        document.querySelectorAll('button:not([type])').forEach(button => {
            if (button.textContent.includes('Beli Sekarang')) {
                button.addEventListener('click', function() {
                    // Check if user is logged in
                    const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
                    
                    if (!isLoggedIn) {
                        // Redirect to login
                        window.location.href = '{{ route("login") }}';
                    } else {
                        // Redirect to pembeli dashboard
                        window.location.href = '/dashboard/pembeli';
                    }
                });
            }
        });

        // "Mulai Sekarang" button handler
        document.querySelectorAll('.gradient-bg').forEach(button => {
            if (button.textContent.includes('Mulai Sekarang')) {
                button.addEventListener('click', function() {
                    window.location.href = '{{ route("register") }}';
                });
            }
        });

        // Active navigation link on scroll
        window.addEventListener('scroll', () => {
            const sections = document.querySelectorAll('section[id]');
            const scrollY = window.pageYOffset;

            sections.forEach(section => {
                const sectionHeight = section.offsetHeight;
                const sectionTop = section.offsetTop - 100;
                const sectionId = section.getAttribute('id');
                
                if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                    document.querySelectorAll('nav a[href*=' + sectionId + ']').forEach(link => {
                        link.classList.add('text-purple-600');
                    });
                } else {
                    document.querySelectorAll('nav a[href*=' + sectionId + ']').forEach(link => {
                        link.classList.remove('text-purple-600');
                    });
                }
            });
        });

        // Add parallax effect to hero section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroImage = document.querySelector('.hero-image');
            if (heroImage) {
                heroImage.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });
    </script>

</body>
</html>
