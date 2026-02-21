<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.name', 'RR-Track') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Outfit:300,400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                            950: '#042f2e',
                        }
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Hide scrollbar */
        ::-webkit-scrollbar {
            display: none;
        }

        body {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Custom styles for autofill backgrounds in dark mode */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #0f172a inset !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-950 min-h-screen relative overflow-hidden flex items-center justify-center">

    {{-- Background Animated Blobs --}}
    <div class="fixed inset-0 w-full h-full z-0 overflow-hidden pointer-events-none">
        <div
            class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-brand-600/30 rounded-full mix-blend-screen filter blur-[100px] animate-blob">
        </div>
        <div class="absolute top-[20%] right-[-10%] w-96 h-96 bg-teal-500/20 rounded-full mix-blend-screen filter blur-[100px] animate-blob"
            style="animation-delay: 2s"></div>
        <div class="absolute bottom-[-20%] left-[20%] w-[500px] h-[500px] bg-emerald-600/20 rounded-full mix-blend-screen filter blur-[120px] animate-blob"
            style="animation-delay: 4s"></div>
        <div
            class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay">
        </div>
    </div>

    {{-- Top Bar: Logo Unair (kiri) & Logo Vokasi (kanan) --}}
    <div class="absolute top-0 left-0 right-0 flex items-center justify-between px-6 py-4 md:px-10 md:py-6 z-20">
        {{-- Logo Unair --}}
        <div
            class="bg-white rounded-2xl px-5 py-3 md:px-6 md:py-4 shadow-xl flex flex-col items-center hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 border border-slate-100">
            <img src="{{ asset('images/LogoUnair.png') }}" alt="Logo Universitas Airlangga"
                class="h-12 md:h-16 w-auto object-contain">
            <span
                class="text-slate-800 text-[9px] md:text-[11px] font-bold mt-2.5 tracking-widest uppercase">Universitas
                Airlangga</span>
        </div>
        {{-- Logo Vokasi --}}
        <div
            class="bg-white rounded-2xl px-5 py-3 md:px-6 md:py-4 shadow-xl flex flex-col items-center hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 border border-slate-100">
            <img src="{{ asset('images/Logovokasi.jpg') }}" alt="Logo Vokasi"
                class="h-12 md:h-16 w-auto object-contain rounded-lg">
            <span class="text-slate-800 text-[9px] md:text-[11px] font-bold mt-2.5 tracking-widest uppercase">Fakultas
                Vokasi</span>
        </div>
    </div>

    {{-- Main Container --}}
    <div class="w-full max-w-lg px-4 z-10 animate-fade-in-up mt-32 md:mt-0">

        {{-- Logos Section: RS Logo (kiri) + logo.png (bulat, kanan) --}}
        <div class="flex items-center justify-center space-x-6 mb-8 group mt-6 md:mt-0">
            {{-- Logo RS --}}
            <div class="relative">
                <div
                    class="absolute inset-0 bg-brand-400 rounded-2xl blur-xl opacity-20 group-hover:opacity-40 transition duration-500">
                </div>
                <div
                    class="relative bg-white w-20 h-20 md:w-24 md:h-24 rounded-2xl shadow-xl flex items-center justify-center p-3 transform hover:scale-105 transition duration-500 border border-slate-100">
                    <img src="{{ asset('images/LogoRsudBangkalan.jpg') }}" alt="Logo RSUD Bangkalan"
                        class="w-full h-full object-contain">
                </div>
            </div>

            {{-- Separator Line --}}
            <div class="h-12 md:h-16 w-px bg-gradient-to-b from-transparent via-white/30 to-transparent"></div>

            {{-- Logo RR-Track (bulat) --}}
            <div class="relative">
                <div
                    class="absolute inset-0 bg-brand-400 rounded-full blur-xl opacity-20 group-hover:opacity-40 transition duration-500">
                </div>
                <div
                    class="relative bg-white w-20 h-20 md:w-24 md:h-24 rounded-full shadow-xl flex items-center justify-center p-2 transform hover:scale-105 transition duration-500 border border-slate-100">
                    <img src="{{ asset('images/logo.png') }}" alt="RR-Track Logo"
                        class="w-full h-full object-contain rounded-full">
                </div>
            </div>
        </div>

        {{-- Login Card (Glassmorphism) --}}
        <div
            class="bg-slate-900/60 backdrop-blur-xl border border-white/10 rounded-3xl shadow-[0_8px_32px_0_rgba(0,0,0,0.5)] overflow-hidden relative">

            {{-- Subtle top highlight --}}
            <div
                class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-brand-400/50 to-transparent">
            </div>

            <div class="p-8 md:p-10">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-white mb-2 tracking-tight">Selamat Datang</h2>
                    <p class="text-brand-200/70 text-sm font-medium">Sistem Monitoring Reject & Repeat</p>
                </div>

                {{-- Session Status --}}
                @if (session('status'))
                    <div
                        class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl backdrop-blur-md text-sm text-center font-medium">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email Address --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-2 ml-1">
                            Email Address
                        </label>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-brand-400 transition-colors">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                class="w-full pl-11 pr-4 py-3.5 bg-slate-950/50 border border-white/10 rounded-2xl text-white placeholder-slate-500 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:bg-slate-900/80 transition-all duration-300 @error('email') border-red-500/50 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="name@example.com" required autofocus autocomplete="username">
                        </div>
                        @error('email')
                            <p class="mt-2 text-xs text-red-400 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-2 ml-1">
                            Password
                        </label>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-brand-400 transition-colors">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </div>
                            <input id="password" type="password" name="password"
                                class="w-full pl-11 pr-4 py-3.5 bg-slate-950/50 border border-white/10 rounded-2xl text-white placeholder-slate-500 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:bg-slate-900/80 transition-all duration-300 @error('password') border-red-500/50 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="••••••••" required autocomplete="current-password">
                        </div>
                        @error('password')
                            <p class="mt-2 text-xs text-red-400 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center mt-6">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <div class="relative flex items-center justify-center">
                                <input id="remember_me" type="checkbox" name="remember"
                                    class="peer appearance-none w-5 h-5 border border-white/20 rounded bg-slate-950/50 checked:bg-brand-500 checked:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30 transition-all cursor-pointer">
                                <i
                                    class="fa-solid fa-check absolute text-white text-xs opacity-0 peer-checked:opacity-100 pointer-events-none transform scale-50 peer-checked:scale-100 transition-all"></i>
                            </div>
                            <span class="ml-3 text-sm text-slate-300 group-hover:text-white transition-colors">Ingat
                                saya</span>
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full mt-8 py-3.5 px-6 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-semibold rounded-2xl shadow-[0_0_20px_rgba(20,184,166,0.3)] hover:shadow-[0_0_25px_rgba(20,184,166,0.5)] transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center group">
                        <span>Masuk ke Sistem</span>
                        <i
                            class="fa-solid fa-arrow-right ml-2 opacity-70 group-hover:translate-x-1 group-hover:opacity-100 transition-all"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center mt-8 text-slate-400 text-xs font-medium tracking-wide">
            <p>&copy; {{ date('Y') }} Teknologi Radiologi Pencitraan<br><span class="text-slate-500">Universitas
                    Airlangga</span></p>
        </div>
    </div>

</body>

</html>