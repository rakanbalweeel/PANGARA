<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Kasir Pangara</title>
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
                    <a href="{{ route('kasir.dashboard') }}" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition">
                        <i class="fas fa-home mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition">
                        <i class="fas fa-shopping-cart mr-3"></i>
                        <span>Transaksi Baru</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition">
                        <i class="fas fa-receipt mr-3"></i>
                        <span>Riwayat Transaksi</span>
                    </a>
                    <a href="{{ route('kasir.products') }}" class="flex items-center px-4 py-3 bg-purple-600 rounded-lg">
                        <i class="fas fa-box mr-3"></i>
                        <span>Daftar Produk</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition">
                        <i class="fas fa-chart-bar mr-3"></i>
                        <span>Laporan Harian</span>
                    </a>
                </nav>
            </div>
            
            <div class="absolute bottom-0 w-64 p-6 border-t border-gray-800">
                <div class="flex items-center mb-3">
                    <img src="https://i.pravatar.cc/40?img=7" class="w-10 h-10 rounded-full mr-3" alt="Kasir">
                    <div class="flex-1">
                        <div class="font-medium">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-400">Kasir</div>
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
                        <h1 class="text-2xl font-bold text-gray-900">Daftar Produk</h1>
                        <p class="text-sm text-gray-600">Cari dan pilih produk untuk transaksi</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right bg-purple-50 px-4 py-2 rounded-lg">
                            <div class="text-sm text-gray-600">Keranjang</div>
                            <div class="text-lg font-bold text-purple-600">0 Item</div>
                        </div>
                        <button class="gradient-bg text-white px-6 py-2 rounded-lg font-medium hover:shadow-lg transition">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Lihat Keranjang
                        </button>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-8">
                <!-- Search & Filter -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="grid md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <div class="relative">
                                <input type="text" placeholder="Cari produk atau scan barcode..." class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent outline-none text-lg">
                                <i class="fas fa-search absolute left-3 top-4 text-gray-400"></i>
                            </div>
                        </div>
                        <select class="px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent outline-none">
                            <option>Semua Kategori</option>
                            <option>Audio</option>
                            <option>Computer</option>
                            <option>Fashion</option>
                            <option>Electronics</option>
                            <option>Accessories</option>
                        </select>
                        <button class="flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-barcode mr-2"></i>
                            Scan Barcode
                        </button>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-blue-500">
                        <div class="text-sm text-gray-600 mb-1">Total Produk</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $products->total() }}</div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-green-500">
                        <div class="text-sm text-gray-600 mb-1">Stok Tersedia</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $products->sum('stock') }}</div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-purple-500">
                        <div class="text-sm text-gray-600 mb-1">Kategori</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $products->unique('category')->count() }}</div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-yellow-500">
                        <div class="text-sm text-gray-600 mb-1">Promo Aktif</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $products->whereNotNull('discount_price')->count() }}</div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                    @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition cursor-pointer group">
                        <div class="relative">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                            <div class="absolute top-2 right-2 flex flex-col space-y-2">
                                @if($product->discount_price)
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    -{{ number_format((($product->price - $product->discount_price) / $product->price) * 100) }}%
                                </span>
                                @endif
                                <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    Stok: {{ $product->stock }}
                                </span>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-3 opacity-0 group-hover:opacity-100 transition">
                                <button class="w-full gradient-bg text-white py-2 rounded-lg font-medium hover:shadow-lg transition">
                                    <i class="fas fa-plus mr-2"></i>
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full font-medium">{{ $product->category }}</span>
                                <span class="text-xs text-gray-500 font-mono">{{ $product->sku }}</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                            <div class="flex items-end justify-between">
                                <div>
                                    @if($product->discount_price)
                                    <div class="text-xl font-bold text-purple-600">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</div>
                                    <div class="text-xs text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                    @else
                                    <div class="text-xl font-bold text-purple-600">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                    @endif
                                </div>
                                <button class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center hover:bg-purple-600 hover:text-white transition">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    {{ $products->links() }}
                </div>
            </main>
        </div>
    </div>

</body>
</html>
