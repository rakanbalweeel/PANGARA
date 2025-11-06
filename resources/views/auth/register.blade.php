<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Pangara</title>
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
        
        .input-group {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
        }
        
        .input-field {
            padding-left: 48px;
        }

        .role-card {
            transition: all 0.3s ease;
        }

        .role-card.selected {
            border-color: #667eea;
            background-color: #f5f3ff;
        }
    </style>
</head>
<body class="bg-gray-50">
    
    <div class="min-h-screen flex">
        <!-- Left Side - Image/Branding -->
        <div class="hidden lg:flex lg:w-1/2 gradient-bg items-center justify-center p-12">
            <div class="max-w-md text-white">
                <div class="flex items-center mb-8">
                    <i class="fas fa-cash-register text-4xl mr-3"></i>
                    <span class="text-4xl font-bold">Pangara</span>
                </div>
                <h1 class="text-4xl font-bold mb-6">Bergabung dengan Kami</h1>
                <p class="text-lg text-purple-100 mb-8">
                    Daftar sekarang dan nikmati kemudahan mengelola bisnis Anda dengan sistem kasir yang modern dan efisien.
                </p>
                <div class="bg-white bg-opacity-20 rounded-xl p-6">
                    <h3 class="font-semibold text-xl mb-4">Pilih Role Anda:</h3>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-white bg-opacity-30 rounded-lg flex items-center justify-center mr-3 mt-1">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Admin</h4>
                                <p class="text-sm text-purple-100">Kelola seluruh sistem dan pengguna</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-white bg-opacity-30 rounded-lg flex items-center justify-center mr-3 mt-1">
                                <i class="fas fa-cash-register"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Kasir</h4>
                                <p class="text-sm text-purple-100">Proses transaksi penjualan</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-white bg-opacity-30 rounded-lg flex items-center justify-center mr-3 mt-1">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Pembeli</h4>
                                <p class="text-sm text-purple-100">Belanja dan lihat riwayat pembelian</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Logo Mobile -->
                <div class="lg:hidden flex items-center justify-center mb-8">
                    <i class="fas fa-cash-register text-purple-600 text-3xl mr-2"></i>
                    <span class="text-3xl font-bold text-gray-800">Pangara</span>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru</h2>
                        <p class="text-gray-600">Isi form untuk mendaftar</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                                <div class="flex-1">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li class="text-sm">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        
                        <!-- Nama -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <div class="input-group">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" 
                                       name="name" 
                                       value="{{ old('name') }}"
                                       class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror" 
                                       placeholder="Nama lengkap Anda"
                                       required>
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <div class="input-group">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent outline-none transition @error('email') border-red-500 @enderror" 
                                       placeholder="nama@email.com"
                                       required>
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon (Opsional)</label>
                            <div class="input-group">
                                <i class="fas fa-phone input-icon"></i>
                                <input type="text" 
                                       name="phone" 
                                       value="{{ old('phone') }}"
                                       class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent outline-none transition" 
                                       placeholder="08123456789">
                            </div>
                        </div>

                        <!-- Role Selection -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Role</label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="role-card cursor-pointer">
                                    <input type="radio" name="role" value="admin" class="hidden" required>
                                    <div class="border-2 border-gray-300 rounded-lg p-3 text-center hover:border-purple-400 transition">
                                        <i class="fas fa-user-shield text-2xl text-purple-600 mb-2"></i>
                                        <div class="text-sm font-medium">Admin</div>
                                    </div>
                                </label>
                                <label class="role-card cursor-pointer">
                                    <input type="radio" name="role" value="kasir" class="hidden" required>
                                    <div class="border-2 border-gray-300 rounded-lg p-3 text-center hover:border-purple-400 transition">
                                        <i class="fas fa-cash-register text-2xl text-green-600 mb-2"></i>
                                        <div class="text-sm font-medium">Kasir</div>
                                    </div>
                                </label>
                                <label class="role-card cursor-pointer">
                                    <input type="radio" name="role" value="pembeli" class="hidden" required>
                                    <div class="border-2 border-gray-300 rounded-lg p-3 text-center hover:border-purple-400 transition">
                                        <i class="fas fa-shopping-cart text-2xl text-blue-600 mb-2"></i>
                                        <div class="text-sm font-medium">Pembeli</div>
                                    </div>
                                </label>
                            </div>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat (Opsional)</label>
                            <textarea name="address" 
                                      rows="2"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent outline-none transition" 
                                      placeholder="Alamat lengkap Anda">{{ old('address') }}</textarea>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <div class="input-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" 
                                       name="password" 
                                       class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent outline-none transition @error('password') border-red-500 @enderror" 
                                       placeholder="Minimal 8 karakter"
                                       required>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                            <div class="input-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" 
                                       name="password_confirmation" 
                                       class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent outline-none transition" 
                                       placeholder="Ulangi password"
                                       required>
                            </div>
                        </div>

                        <!-- Terms -->
                        <div class="mb-6">
                            <label class="flex items-start">
                                <input type="checkbox" class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500 mt-1" required>
                                <span class="ml-2 text-sm text-gray-600">
                                    Saya setuju dengan <a href="#" class="text-purple-600 hover:text-purple-700">Syarat & Ketentuan</a> serta <a href="#" class="text-purple-600 hover:text-purple-700">Kebijakan Privasi</a>
                                </span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full gradient-bg text-white py-3 rounded-lg font-medium hover:shadow-lg transition">
                            <i class="fas fa-user-plus mr-2"></i>
                            Daftar Sekarang
                        </button>
                    </form>

                    <!-- Login Link -->
                    <p class="text-center text-sm text-gray-600 mt-6">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-medium">Masuk di sini</a>
                    </p>
                </div>

                <!-- Back to Home -->
                <div class="text-center mt-6">
                    <a href="/" class="text-sm text-gray-600 hover:text-purple-600 flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Role selection interaction
        document.querySelectorAll('.role-card').forEach(card => {
            card.addEventListener('click', function() {
                // Remove selected class from all cards
                document.querySelectorAll('.role-card').forEach(c => {
                    c.classList.remove('selected');
                    c.querySelector('div').classList.remove('border-purple-600', 'bg-purple-50');
                    c.querySelector('div').classList.add('border-gray-300');
                });
                
                // Add selected class to clicked card
                this.classList.add('selected');
                this.querySelector('div').classList.remove('border-gray-300');
                this.querySelector('div').classList.add('border-purple-600', 'bg-purple-50');
                
                // Check the radio button
                this.querySelector('input[type="radio"]').checked = true;
            });
        });
    </script>

</body>
</html>
