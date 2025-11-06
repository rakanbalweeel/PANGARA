<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pangara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
        }
        
        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9CA3AF;
            transition: color 0.3s;
        }
        
        .toggle-password:hover {
            color: #667eea;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 via-blue-50 to-pink-50 min-h-screen">
    
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md fade-in">
            
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 gradient-bg rounded-2xl mb-4 shadow-xl">
                    <i class="fas fa-cash-register text-white text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang! 👋</h1>
                <p class="text-gray-600">Masuk ke akun Pangara Anda</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-3xl shadow-2xl p-8">
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3 text-xl"></i>
                            <div>
                                <p class="font-semibold text-red-800">Login Gagal!</p>
                                <p class="text-sm text-red-700">{{ $errors->first() }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <!-- Email -->
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <i class="fas fa-envelope input-icon text-lg"></i>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition @error('email') border-red-500 @enderror" 
                                   placeholder="nama@email.com"
                                   required>
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-info-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock input-icon text-lg"></i>
                            <input type="password" 
                                   name="password"
                                   id="password" 
                                   class="w-full pl-12 pr-12 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition @error('password') border-red-500 @enderror" 
                                   placeholder="Masukkan password"
                                   required>
                            <i class="fas fa-eye toggle-password text-lg" id="togglePassword"></i>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-info-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500 cursor-pointer">
                            <span class="ml-2 text-sm text-gray-700 font-medium group-hover:text-purple-600 transition">Ingat Saya</span>
                        </label>
                        <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-semibold hover:underline">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full gradient-bg text-white py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.02] mb-6">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Masuk Sekarang
                    </button>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t-2 border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500 font-medium">Atau masuk dengan</span>
                        </div>
                    </div>

                    <!-- Social Login -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" class="flex items-center justify-center px-4 py-3 border-2 border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 transform hover:scale-105">
                            <i class="fab fa-google text-red-500 text-xl mr-2"></i>
                            <span class="text-sm font-semibold text-gray-700">Google</span>
                        </button>
                        <button type="button" class="flex items-center justify-center px-4 py-3 border-2 border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 transform hover:scale-105">
                            <i class="fab fa-facebook text-blue-600 text-xl mr-2"></i>
                            <span class="text-sm font-semibold text-gray-700">Facebook</span>
                        </button>
                    </div>
                </form>

                <!-- Register Link -->
                <div class="text-center mt-8 pt-6 border-t-2 border-gray-100">
                    <p class="text-sm text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-purple-600 hover:text-purple-700 font-bold hover:underline ml-1">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="/" class="inline-flex items-center text-sm text-gray-600 hover:text-purple-600 font-medium transition-colors duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Footer Info -->
            <div class="mt-8 text-center">
                <div class="flex items-center justify-center space-x-6 text-xs text-gray-500">
                    <a href="#" class="hover:text-purple-600 transition">Bantuan</a>
                    <span>•</span>
                    <a href="#" class="hover:text-purple-600 transition">Kebijakan Privasi</a>
                    <span>•</span>
                    <a href="#" class="hover:text-purple-600 transition">Syarat & Ketentuan</a>
                </div>
                <p class="text-xs text-gray-400 mt-3">© 2025 Pangara. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle icon
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
    </script>

</body>
</html>
