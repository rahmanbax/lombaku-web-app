<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lombaku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }
        
        .login-card {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .login-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .input-field {
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        
        .login-btn {
            transition: all 0.3s ease;
            background-size: 200% auto;
        }
        
        .login-btn:hover {
            background-position: right center;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="login-card bg-white rounded-xl p-8 w-full max-w-md">
            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <div class="flex items-center space-x-2">
                    <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white p-2 rounded-lg">
                        <i class="fas fa-trophy text-lg"></i>
                    </div>
                    <span class="text-2xl font-bold text-gray-800 bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Lombaku</span>
                </div>
            </div>
            
            <!-- Judul -->
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Masuk ke Akun Anda</h2>
            <p class="text-gray-600 text-center mb-8">Silakan masuk untuk mengakses dashboard</p>
            
            <!-- Form Login -->
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required
                            class="input-field block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="email@contoh.com">
                    </div>
                </div>
                
                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            class="input-field block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="••••••••">
                    </div>
                </div>
                
                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Lupa password?</a>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="login-btn w-full bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium py-3 px-4 rounded-lg shadow-md">
                    Masuk
                </button>
            </form>
            
            <!-- Footer -->
            @guest
            <div class="mt-8 text-center text-sm text-gray-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">Daftar sekarang</a>
            </div>
            @endguest
        </div>
    </div>
</body>
</html>
