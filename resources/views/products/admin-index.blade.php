<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Admin Pangara</title>
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
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition">
                        <i class="fas fa-home mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition">
                        <i class="fas fa-users mr-3"></i>
                        <span>Kelola Pengguna</span>
                    </a>
                    <a href="{{ route('admin.products') }}" class="flex items-center px-4 py-3 bg-purple-600 rounded-lg">
                        <i class="fas fa-box mr-3"></i>
                        <span>Kelola Produk</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition">
                        <i class="fas fa-tags mr-3"></i>
                        <span>Kategori</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition">
                        <i class="fas fa-receipt mr-3"></i>
                        <span>Transaksi</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition">
                        <i class="fas fa-chart-line mr-3"></i>
                        <span>Laporan</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-800 rounded-lg transition">
                        <i class="fas fa-cog mr-3"></i>
                        <span>Pengaturan</span>
                    </a>
                </nav>
            </div>
            
            <div class="absolute bottom-0 w-64 p-6 border-t border-gray-800">
                <div class="flex items-center mb-3">
                    <img src="https://i.pravatar.cc/40?img=5" class="w-10 h-10 rounded-full mr-3" alt="Admin">
                    <div class="flex-1">
                        <div class="font-medium">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-400">Administrator</div>
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
                        <h1 class="text-2xl font-bold text-gray-900">Kelola Produk</h1>
                        <p class="text-sm text-gray-600">Manajemen produk dan inventori</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-filter mr-2"></i>
                            Filter
                        </button>
                        <button class="gradient-bg text-white px-6 py-2 rounded-lg font-medium hover:shadow-lg transition">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Produk
                        </button>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-8">
                <!-- Stats -->
                <div class="grid md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Total Produk</span>
                            <i class="fas fa-box text-blue-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-gray-900">{{ $products->total() }}</div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Stok Tersedia</span>
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-gray-900">{{ $products->sum('stock') }}</div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Produk Aktif</span>
                            <i class="fas fa-toggle-on text-purple-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-gray-900">{{ $products->where('is_active', true)->count() }}</div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Stok Menipis</span>
                            <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-gray-900">{{ $products->where('stock', '<', 10)->count() }}</div>
                    </div>
                </div>

                <!-- Search & Filter Bar -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="grid md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <div class="relative">
                                <input type="text" placeholder="Cari produk..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent outline-none">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent outline-none">
                            <option>Semua Kategori</option>
                            <option>Audio</option>
                            <option>Computer</option>
                            <option>Fashion</option>
                            <option>Electronics</option>
                            <option>Accessories</option>
                        </select>
                        <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent outline-none">
                            <option>Semua Status</option>
                            <option>Aktif</option>
                            <option>Non-Aktif</option>
                            <option>Stok Habis</option>
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                    @foreach($products as $product)
                    @php
                        use Illuminate\Support\Str;
                        $catLower = Str::lower($product->category);
                        $prodType = 'other';
                        if (Str::contains($catLower, 'minum')) {
                            $prodType = 'minuman';
                        } elseif (Str::contains($catLower, 'makan') || Str::contains($catLower, 'snack') || Str::contains($catLower, 'buah') || Str::contains($catLower, 'sayur')) {
                            $prodType = 'makanan';
                        }
                    @endphp
                    <div data-type="{{ $prodType }}" class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition group">
                        <div class="relative">
                            <img src="{{ $product->image ?? asset('storage/products/default.png') }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                            @if($prodType !== 'other')
                            <div class="absolute top-2 left-2">
                                <span class="text-xs px-2 py-1 rounded-full text-white bg-{{ $prodType === 'minuman' ? 'blue' : 'red' }}-500">{{ ucfirst($prodType) }}</span>
                            </div>
                            @endif
                            <div class="absolute top-2 right-2 flex flex-col space-y-2">
                                @if($product->discount_price)
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                    -{{ number_format((($product->price - $product->discount_price) / $product->price) * 100) }}%
                                </span>
                                @endif
                                @if($product->stock < 10)
                                <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">
                                    Stok: {{ $product->stock }}
                                </span>
                                @endif
                            </div>
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <div class="flex space-x-2">
                                    <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-purple-600 hover:text-white transition">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-blue-600 hover:text-white transition">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-red-600 hover:text-white transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full">{{ $product->category }}</span>
                                <span class="text-xs text-gray-500">SKU: {{ $product->sku }}</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2 truncate">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->description }}</p>
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    @if($product->discount_price)
                                    <div class="text-lg font-bold text-purple-600">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</div>
                                    <div class="text-xs text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                    @else
                                    <div class="text-lg font-bold text-purple-600">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-semibold text-gray-900">{{ $product->stock }}</div>
                                    <div class="text-xs text-gray-500">Stok</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" {{ $product->is_active ? 'checked' : '' }} class="w-4 h-4 text-purple-600 rounded">
                                    <span class="ml-2 text-xs text-gray-600">Aktif</span>
                                </label>
                                <button class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                                    Detail <i class="fas fa-arrow-right ml-1"></i>
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
