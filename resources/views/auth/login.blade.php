<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('images/logo-rsud-login.png') }}">

    <title>Login - {{ config('app.name', 'RR-Track') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Outfit:300,400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

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
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                        },
                    },
                },
            },
        };
    </script>

    <style>
        body {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        .login-shell {
            background:
                radial-gradient(circle at 11% 16%, rgba(20, 184, 166, 0.22), transparent 22rem),
                radial-gradient(circle at 87% 34%, rgba(20, 184, 166, 0.21), transparent 20rem),
                radial-gradient(circle at 19% 76%, rgba(13, 148, 136, 0.22), transparent 27rem),
                linear-gradient(115deg, #071a1c 0%, #0b1020 38%, #0b1020 100%);
        }

        .login-shell::after {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            opacity: 0.13;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
            background-size: 72px 72px;
            mask-image: radial-gradient(circle at center, black, transparent 78%);
        }

        .logo-shadow {
            filter:
                drop-shadow(0 2px 2px rgba(255, 255, 255, 0.44))
                drop-shadow(0 10px 20px rgba(0, 0, 0, 0.35));
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 32px #111827 inset !important;
            -webkit-text-fill-color: #f8fafc !important;
            caret-color: #f8fafc;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>

<body class="login-shell min-h-screen overflow-x-hidden font-sans text-slate-100 antialiased">
    <header class="pointer-events-none fixed inset-x-0 top-0 z-20 flex items-start justify-between px-6 py-6 md:px-14">
        <img src="{{ asset('images/logo-unair-login.png') }}" alt="Logo Universitas Airlangga"
            class="logo-shadow h-16 w-16 object-contain sm:h-20 sm:w-20 md:h-24 md:w-24">

        <img src="{{ asset('images/logo-vokasi-login.png') }}" alt="Logo Vokasi Sigap"
            class="logo-shadow mt-1 h-auto w-32 object-contain sm:w-40 md:w-44">
    </header>

    <main class="relative z-10 flex min-h-screen w-full flex-col items-center justify-center px-4 py-10 pt-32 sm:pt-28 md:pt-10">
        <section class="w-full max-w-[382px]">
            <div class="mb-5 flex items-end justify-center gap-5">
                <img src="{{ asset('images/logo-rsud-login.png') }}" alt="Logo RSUD Syarifah Ambami Rato Ebu Bangkalan"
                    class="logo-shadow h-[70px] w-auto object-contain">
                <img src="{{ asset('images/logo-rrtrack-login.png') }}" alt="Logo RR-Track"
                    class="logo-shadow h-[70px] w-auto object-contain">
            </div>

            <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-slate-950/50 shadow-[0_24px_80px_rgba(0,0,0,0.34)] backdrop-blur-xl">
                <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-brand-400/60 to-transparent"></div>

                <div class="px-5 py-7 sm:px-6">
                    <div class="mb-7 text-center">
                        <h1 class="text-[28px] font-bold leading-tight tracking-normal text-white">Selamat Datang</h1>
                        <p class="mt-2 text-xs font-medium text-brand-500">Sistem Monitoring Reject &amp; Repeat</p>
                    </div>

                    @if (session('status'))
                        <div class="mb-5 rounded-xl border border-emerald-400/20 bg-emerald-400/10 px-4 py-3 text-center text-sm font-medium text-emerald-200">
                            {{ session('status') }}
                        </div>
                    @endif

                    @error('login')
                        <div class="mb-5 rounded-xl border border-red-400/20 bg-red-400/10 px-4 py-3 text-center text-sm font-medium text-red-200">
                            {{ $message }}
                        </div>
                    @enderror

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-slate-300">Email Address</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-300">
                                    <i class="fa-solid fa-envelope text-sm"></i>
                                </span>
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                    class="h-[52px] w-full rounded-[9px] border bg-slate-900/45 pl-11 pr-4 text-sm text-white outline-none transition placeholder:text-slate-300/75 focus:border-brand-400 focus:ring-1 focus:ring-brand-400 {{ $errors->has('email') ? 'border-red-400/70 focus:border-red-400 focus:ring-red-400' : 'border-slate-500/70' }}"
                                    placeholder="admin.rumahsakit@gmail.com" required autofocus autocomplete="username">
                            </div>
                            @error('email')
                                <p class="mt-2 text-xs font-medium text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-medium text-slate-300">Password</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </span>
                                <input id="password" type="password" name="password"
                                    class="h-[52px] w-full rounded-[9px] border bg-slate-900/45 pl-11 pr-4 text-sm text-white outline-none transition placeholder:text-slate-300/70 focus:border-brand-400 focus:ring-1 focus:ring-brand-400 {{ $errors->has('password') ? 'border-red-400/70 focus:border-red-400 focus:ring-red-400' : 'border-slate-500/70' }}"
                                    placeholder="************" required autocomplete="current-password">
                            </div>
                            @error('password')
                                <p class="mt-2 text-xs font-medium text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <label for="remember_me" class="flex w-fit cursor-pointer items-center gap-3 text-sm text-slate-300">
                            <span class="relative flex h-6 w-6 items-center justify-center">
                                <input id="remember_me" type="checkbox" name="remember"
                                    class="peer h-6 w-6 appearance-none rounded-[3px] border border-slate-500/80 bg-slate-900/45 transition checked:border-brand-500 checked:bg-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-400/30">
                                <i class="fa-solid fa-check pointer-events-none absolute text-xs text-white opacity-0 transition peer-checked:opacity-100"></i>
                            </span>
                            <span>Ingat Saya</span>
                        </label>

                        <button type="submit"
                            class="flex h-[52px] w-full items-center justify-center gap-3 rounded-[9px] bg-gradient-to-r from-brand-500 to-brand-600 px-5 text-sm font-semibold text-white shadow-[0_7px_16px_rgba(20,184,166,0.34)] transition hover:from-brand-400 hover:to-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-300/60">
                            <span>Masuk Ke Sistem</span>
                            <i class="fa-solid fa-arrow-right text-base"></i>
                        </button>
                    </form>
                </div>
            </div>

            <footer class="mt-2 text-center text-xs font-medium leading-6 text-slate-400/80">
                <p>{{ date('Y') }} Teknologi Radiologi Pencitraan<br>
                    <span class="text-slate-500">Universitas Airlangga</span>
                </p>
            </footer>
        </section>
    </main>
</body>

</html>
