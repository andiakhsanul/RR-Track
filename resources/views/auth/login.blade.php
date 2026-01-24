<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RR-Track Hospital System</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                        'display': ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    },
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #064e3b 0%, #047857 50%, #059669 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Floating Shapes */
        .floating-shape {
            position: fixed;
            border-radius: 50%;
            opacity: 0.3;
            animation: float 8s ease-in-out infinite;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            background: rgba(52, 211, 153, 0.4);
            top: -100px;
            left: -100px;
            filter: blur(60px);
        }

        .shape-2 {
            width: 400px;
            height: 400px;
            background: rgba(6, 182, 212, 0.3);
            bottom: -150px;
            right: -100px;
            filter: blur(80px);
            animation-delay: 2s;
        }

        .shape-3 {
            width: 250px;
            height: 250px;
            background: rgba(167, 139, 250, 0.3);
            top: 50%;
            right: 10%;
            filter: blur( 70px);
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(5deg); }
        }

        /* Card Styles */
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            0% { transform: translateY(40px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        /* Logo Animation */
        .logo-container {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(16, 185, 129, 0.4); }
            50% { box-shadow: 0 0 40px rgba(16, 185, 129, 0.7); }
        }

        /* Input Focus */
        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            border-color: #10b981;
            background: white;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }

        /* Button Hover */
        .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
        }
    </style>
</head>
<body>
    <!-- Floating Shapes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>

    <!-- Main Content -->
    <div class="relative w-full max-w-md z-10">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <div class="logo-container w-20 h-20 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center shadow-xl relative">
                <i class="fas fa-heartbeat text-3xl text-white"></i>
                <div class="absolute -top-1 -right-1 w-5 h-5 bg-cyan-400 rounded-full animate-bounce"></div>
                <div class="absolute -bottom-1 -left-1 w-3 h-3 bg-purple-400 rounded-full animate-ping"></div>
            </div>
        </div>

        <!-- Login Card -->
        <div class="login-card p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-slate-800 mb-2" style="font-family: 'Poppins', sans-serif;">
                    Selamat Datang! 👋
                </h1>
                <p class="text-slate-500">
                    Masuk ke <span class="text-emerald-600 font-semibold">RR-Track</span> Hospital System
                </p>
            </div>

            <!-- Error Alert -->
            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-red-500 flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-exclamation text-white"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-red-700 text-sm">Login Gagal</p>
                            <p class="text-sm text-red-600">{{ $errors->first() }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email Field -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-slate-400"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="input-field w-full pl-12 pr-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:outline-none text-slate-700 placeholder-slate-400"
                               placeholder="email@example.com" required>
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-slate-400"></i>
                        </div>
                        <input type="password" name="password" id="password"
                               class="input-field w-full pl-12 pr-12 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:outline-none text-slate-700 placeholder-slate-400"
                               placeholder="••••••••" required>
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-emerald-500 transition-colors">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-emerald-500 focus:ring-emerald-500">
                        <span class="ml-2 text-sm text-slate-600">Ingat Saya</span>
                    </label>
                    <a href="#" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                        Lupa Password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-primary w-full py-3 text-white font-semibold rounded-xl shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk Sekarang
                </button>
            </form>

            <!-- Divider -->
            <div class="my-6 flex items-center">
                <div class="flex-1 h-px bg-slate-200"></div>
                <span class="px-4 text-sm text-slate-400">atau</span>
                <div class="flex-1 h-px bg-slate-200"></div>
            </div>

            <!-- Help Link -->
            <div class="text-center">
                <p class="text-slate-500 text-sm">
                    Butuh bantuan?
                    <a href="#" class="text-emerald-600 hover:text-emerald-700 font-medium">Hubungi Admin</a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center mt-6 text-white/70 text-sm">
            © {{ date('Y') }} RR-Track Hospital System. All rights reserved.
        </p>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
