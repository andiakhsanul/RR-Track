<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RR-Track') - Sistem Laporan Rumah Sakit</title>

    <!-- Google Fonts - Inter & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
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
                            950: '#022c22',
                        },
                        accent: {
                            purple: '#8b5cf6',
                            pink: '#ec4899',
                            orange: '#f97316',
                            cyan: '#06b6d4',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-slow': 'bounce 3s infinite',
                        'gradient': 'gradient 8s ease infinite',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'fade-in': 'fadeIn 0.5s ease-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        gradient: {
                            '0%, 100%': { backgroundPosition: '0% 50%' },
                            '50%': { backgroundPosition: '100% 50%' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                    },
                    boxShadow: {
                        'glow': '0 0 20px rgba(16, 185, 129, 0.3)',
                        'glow-lg': '0 0 40px rgba(16, 185, 129, 0.4)',
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        [x-cloak] { display: none !important; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #10b981, #059669); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, #059669, #047857); }
        
        /* Glassmorphism */
        .glass { 
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Card Hover Effect */
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        
        /* Sidebar Gradient */
        .sidebar-gradient {
            background: linear-gradient(180deg, #064e3b 0%, #065f46 50%, #047857 100%);
        }
        
        /* Active Nav Glow */
        .nav-active {
            background: linear-gradient(90deg, rgba(16, 185, 129, 0.3) 0%, rgba(16, 185, 129, 0.1) 100%);
            border-left: 3px solid #10b981;
        }
        
        /* Mesh Background */
        .mesh-bg {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 40% 20%, rgba(16, 185, 129, 0.1) 0px, transparent 50%),
                radial-gradient(at 80% 0%, rgba(6, 182, 212, 0.1) 0px, transparent 50%),
                radial-gradient(at 0% 50%, rgba(139, 92, 246, 0.05) 0px, transparent 50%),
                radial-gradient(at 80% 50%, rgba(236, 72, 153, 0.05) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(16, 185, 129, 0.1) 0px, transparent 50%);
        }

        /* Input Focus Ring */
        input:focus, select:focus, textarea:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }
        
        /* Button Shine Effect */
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: 0.5s;
        }
        .btn-shine:hover::before {
            left: 100%;
        }
    </style>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-slate-50">
        <!-- Sidebar Overlay (Mobile) -->
        <div x-show="sidebarOpen" 
             x-cloak
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false" 
             class="fixed inset-0 z-20 bg-slate-900/60 backdrop-blur-sm lg:hidden"></div>
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-30 w-72 sidebar-gradient transform transition-all duration-500 ease-out lg:translate-x-0 lg:static lg:inset-0 shadow-2xl">
            
            <!-- Logo -->
            <div class="flex items-center justify-center h-24 border-b border-white/10">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="w-14 h-14 bg-gradient-to-br from-primary-400 to-primary-600 rounded-2xl flex items-center justify-center shadow-glow animate-pulse-slow">
                            <i class="fas fa-heartbeat text-2xl text-white"></i>
                        </div>
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-accent-cyan rounded-full animate-bounce-slow"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-display font-bold text-white tracking-tight">RR-Track</h1>
                        <p class="text-xs text-primary-200 font-medium tracking-wider uppercase">Hospital System</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-8 px-4">
                <p class="px-4 text-xs font-semibold text-primary-300 uppercase tracking-wider mb-4">Menu Utama</p>
                <div class="space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                       class="group flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'nav-active bg-white/10 text-white shadow-lg' : 'text-primary-100 hover:bg-white/5 hover:text-white' }}">
                        <div class="w-10 h-10 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-gradient-to-br from-primary-400 to-primary-600 shadow-glow' : 'bg-white/10 group-hover:bg-white/20' }} flex items-center justify-center transition-all duration-300">
                            <i class="fas fa-th-large {{ request()->routeIs('dashboard') ? 'text-white' : 'text-primary-200 group-hover:text-white' }}"></i>
                        </div>
                        <span class="ml-4 font-medium">Dashboard</span>
                        @if(request()->routeIs('dashboard'))
                            <div class="ml-auto w-2 h-2 bg-primary-400 rounded-full animate-pulse"></div>
                        @endif
                    </a>
                    
                    <!-- Laporan Repeat -->
                    <div x-data="{ open: {{ request()->routeIs('laporan.repeat.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" 
                                class="group w-full flex items-center justify-between px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('laporan.repeat.*') ? 'nav-active bg-white/10 text-white' : 'text-primary-100 hover:bg-white/5 hover:text-white' }}">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl {{ request()->routeIs('laporan.repeat.*') ? 'bg-gradient-to-br from-blue-400 to-blue-600 shadow-lg' : 'bg-white/10 group-hover:bg-white/20' }} flex items-center justify-center transition-all duration-300">
                                    <i class="fas fa-sync-alt {{ request()->routeIs('laporan.repeat.*') ? 'text-white' : 'text-primary-200 group-hover:text-white' }}"></i>
                                </div>
                                <span class="ml-4 font-medium">Laporan Repeat</span>
                            </div>
                            <i :class="open ? 'rotate-180' : ''" class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                        </button>
                        <div x-show="open" 
                             x-collapse 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="mt-2 ml-6 space-y-1">
                            <a href="{{ route('laporan.repeat.index') }}" 
                               class="flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('laporan.repeat.index') ? 'bg-blue-500/20 text-white' : 'text-primary-200 hover:bg-white/5 hover:text-white' }}">
                                <i class="fas fa-list-ul w-5 text-xs"></i>
                                <span class="ml-3">Daftar Laporan</span>
                            </a>
                            <a href="{{ route('laporan.repeat.create') }}" 
                               class="flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('laporan.repeat.create') ? 'bg-blue-500/20 text-white' : 'text-primary-200 hover:bg-white/5 hover:text-white' }}">
                                <i class="fas fa-plus-circle w-5 text-xs"></i>
                                <span class="ml-3">Tambah Baru</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Laporan Reject -->
                    <div x-data="{ open: {{ request()->routeIs('laporan.reject.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" 
                                class="group w-full flex items-center justify-between px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('laporan.reject.*') ? 'nav-active bg-white/10 text-white' : 'text-primary-100 hover:bg-white/5 hover:text-white' }}">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl {{ request()->routeIs('laporan.reject.*') ? 'bg-gradient-to-br from-red-400 to-red-600 shadow-lg' : 'bg-white/10 group-hover:bg-white/20' }} flex items-center justify-center transition-all duration-300">
                                    <i class="fas fa-ban {{ request()->routeIs('laporan.reject.*') ? 'text-white' : 'text-primary-200 group-hover:text-white' }}"></i>
                                </div>
                                <span class="ml-4 font-medium">Laporan Reject</span>
                            </div>
                            <i :class="open ? 'rotate-180' : ''" class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                        </button>
                        <div x-show="open" 
                             x-collapse
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="mt-2 ml-6 space-y-1">
                            <a href="{{ route('laporan.reject.index') }}" 
                               class="flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('laporan.reject.index') ? 'bg-red-500/20 text-white' : 'text-primary-200 hover:bg-white/5 hover:text-white' }}">
                                <i class="fas fa-list-ul w-5 text-xs"></i>
                                <span class="ml-3">Daftar Laporan</span>
                            </a>
                            <a href="{{ route('laporan.reject.create') }}" 
                               class="flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('laporan.reject.create') ? 'bg-red-500/20 text-white' : 'text-primary-200 hover:bg-white/5 hover:text-white' }}">
                                <i class="fas fa-plus-circle w-5 text-xs"></i>
                                <span class="ml-3">Tambah Baru</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Decorative Element -->
                <div class="mt-8 mx-4 p-4 rounded-2xl bg-gradient-to-br from-primary-400/20 to-primary-600/20 border border-white/10">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <i class="fas fa-chart-line text-white"></i>
                        </div>
                        <div>
                            <p class="text-white text-sm font-semibold">Statistik Real-time</p>
                            <p class="text-primary-200 text-xs">Pantau data terbaru</p>
                        </div>
                    </div>
                </div>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="glass sticky top-0 z-10 border-b border-slate-200/50">
                <div class="flex items-center justify-between h-20 px-6">
                    <!-- Mobile Menu Button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    
                    <!-- Page Title & Breadcrumb -->
                    <div class="hidden lg:block">
                        <h2 class="text-xl font-display font-bold text-slate-800">
                            @yield('page-title', 'Dashboard')
                        </h2>
                        <p class="text-sm text-slate-500 mt-0.5">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            {{ now()->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                    
                    <!-- Right Side -->
                    <div class="flex items-center space-x-4">
                        <!-- Notification Bell -->
                        <button class="relative p-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition-all hover:scale-105">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse"></span>
                        </button>
                        
                        <!-- User Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" 
                                    class="flex items-center space-x-3 p-2 pr-4 rounded-2xl bg-gradient-to-r from-slate-100 to-slate-50 hover:from-slate-200 hover:to-slate-100 transition-all duration-300 hover:shadow-md group">
                                <div class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-glow transition-all">
                                    <span class="text-white text-sm font-bold">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-semibold text-slate-700">{{ Auth::user()->name ?? 'Admin' }}</p>
                                    <p class="text-xs text-slate-500">Administrator</p>
                                </div>
                                <i class="fas fa-chevron-down text-xs text-slate-400 group-hover:text-slate-600 transition-colors"></i>
                            </button>
                            
                            <div x-show="open" 
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 @click.away="open = false"
                                 class="absolute right-0 mt-3 w-56 glass rounded-2xl shadow-xl py-2 z-50 border border-slate-200/50">
                                <div class="px-4 py-3 border-b border-slate-200/50">
                                    <p class="text-sm font-semibold text-slate-700">{{ Auth::user()->name ?? 'Admin' }}</p>
                                    <p class="text-xs text-slate-500">{{ Auth::user()->email ?? 'admin@rumahsakit.com' }}</p>
                                </div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-3"></i> 
                                        <span class="font-medium">Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto mesh-bg p-6">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-init="setTimeout(() => show = false, 5000)"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="mb-6 flex items-center p-4 rounded-2xl bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 shadow-sm" role="alert">
                        <div class="w-10 h-10 rounded-xl bg-green-500 flex items-center justify-center mr-4">
                            <i class="fas fa-check text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-green-800">Berhasil!</p>
                            <p class="text-sm text-green-600">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="p-2 hover:bg-green-100 rounded-lg transition-colors">
                            <i class="fas fa-times text-green-600"></i>
                        </button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div x-data="{ show: true }" 
                         x-show="show"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="mb-6 flex items-center p-4 rounded-2xl bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 shadow-sm" role="alert">
                        <div class="w-10 h-10 rounded-xl bg-red-500 flex items-center justify-center mr-4">
                            <i class="fas fa-exclamation text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-red-800">Error!</p>
                            <p class="text-sm text-red-600">{{ session('error') }}</p>
                        </div>
                        <button @click="show = false" class="p-2 hover:bg-red-100 rounded-lg transition-colors">
                            <i class="fas fa-times text-red-600"></i>
                        </button>
                    </div>
                @endif
                
                <div class="animate-fade-in">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
