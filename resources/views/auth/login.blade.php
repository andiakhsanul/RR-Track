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
                    fontSize: {
                        xs: ['0.82rem', { lineHeight: '1.18rem' }],
                        sm: ['0.95rem', { lineHeight: '1.45rem' }],
                        base: ['1.08rem', { lineHeight: '1.65rem' }],
                        lg: ['1.2rem', { lineHeight: '1.8rem' }],
                        xl: ['1.35rem', { lineHeight: '1.9rem' }],
                        '2xl': ['1.65rem', { lineHeight: '2.05rem' }],
                        '3xl': ['2rem', { lineHeight: '2.4rem' }],
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
            position: relative;
            background:
                linear-gradient(90deg, #f7f8fa 0%, #ffffff 52%, #f4fbfb 100%);
        }

        .hospital-backdrop {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background-image:
                radial-gradient(ellipse 560px 360px at 93% 4%, rgba(95, 217, 207, 0.70) 0%, rgba(95, 217, 207, 0.35) 36%, rgba(95, 217, 207, 0) 72%),
                radial-gradient(ellipse 620px 360px at 98% 98%, rgba(20, 184, 166, 0.64) 0%, rgba(20, 184, 166, 0.34) 38%, rgba(20, 184, 166, 0) 74%),
                radial-gradient(ellipse 460px 210px at 4% 100%, rgba(20, 184, 166, 0.38) 0%, rgba(20, 184, 166, 0.20) 46%, rgba(20, 184, 166, 0) 82%),
                linear-gradient(90deg, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0.40) 34%, rgba(255, 255, 255, 0.82) 60%, rgba(255, 255, 255, 0.95) 100%),
                linear-gradient(0deg, rgba(20, 184, 166, 0.22) 0%, rgba(20, 184, 166, 0.08) 22%, rgba(255, 255, 255, 0) 48%),
                url('{{ asset('images/bg-hospital-building-login.png') }}');
            background-repeat: no-repeat;
            background-size:
                100% 100%,
                100% 100%,
                100% 100%,
                100% 100%,
                100% 100%,
                clamp(860px, 74vw, 1180px) auto;
            background-position:
                center,
                center,
                center,
                center,
                center,
                left -230px bottom -146px;
        }

        @media (max-width: 767px) {
            .hospital-backdrop {
                background-size:
                    100% 100%,
                    100% 100%,
                    100% 100%,
                    100% 100%,
                    100% 100%,
                    min(138vw, 720px) auto;
                background-position:
                    center,
                    center,
                    center,
                    center,
                    center,
                    left -120px bottom -62px;
            }
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 32px #ffffff inset !important;
            -webkit-text-fill-color: #0f172a !important;
            caret-color: #0f172a;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>

<body class="login-shell min-h-screen overflow-x-hidden font-sans text-slate-900 antialiased relative">
    <div class="hospital-backdrop"></div>

    <header class="pointer-events-none fixed inset-x-0 top-0 z-20 flex items-start justify-between px-6 py-5 md:px-14 md:py-7">
        <img src="{{ asset('images/logo-unair-login.png') }}" alt="Logo Universitas Airlangga"
            class="h-16 w-16 object-contain sm:h-[76px] sm:w-[76px] md:h-[86px] md:w-[86px]">

        <img src="{{ asset('images/logo-vokasi-login.png') }}" alt="Logo Vokasi Sigap"
            class="mt-1 h-auto w-32 object-contain sm:w-36 md:w-[156px]">
    </header>

    <main class="relative z-10 flex min-h-screen w-full flex-col items-center justify-center px-4 py-8 pt-32 sm:pt-32 md:pt-10">
        <section class="w-full max-w-[430px]">
            <div class="mb-3 flex items-end justify-center gap-5">
                <img src="{{ asset('images/logo-rsud-login.png') }}" alt="Logo RSUD Syarifah Ambami Rato Ebu Bangkalan"
                    class="h-[64px] w-auto object-contain sm:h-[72px]">
                <img src="{{ asset('images/logo-rrtrack-login.png') }}" alt="Logo RR-Track"
                    class="h-[64px] w-auto object-contain sm:h-[72px]">
            </div>

            <div class="relative z-10 overflow-hidden rounded-[12px] border border-[#6a7374] bg-white/95 shadow-[0_20px_55px_rgba(15,23,42,0.16)] backdrop-blur-sm">
                <div class="px-6 py-7 sm:px-8 sm:py-9">
                    <div class="mb-8 text-center">
                        <h1 class="text-[28px] font-bold leading-tight text-[#4d827c] sm:text-[30px]">Selamat Datang</h1>
                        <p class="mt-2 text-[12px] font-medium text-[#139989]">Sistem Monitoring Reject &amp; Repeat</p>
                    </div>

                    @if (session('status'))
                        <div class="mb-5 rounded-xl border border-emerald-400/20 bg-emerald-50 px-4 py-3 text-center text-sm font-medium text-emerald-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    @error('login')
                        <div class="mb-5 rounded-xl border border-red-400/20 bg-red-50 px-4 py-3 text-center text-sm font-medium text-red-800">
                            {{ $message }}
                        </div>
                    @enderror

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-slate-800">Email Address</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-800">
                                    <i class="fa-solid fa-envelope text-sm"></i>
                                </span>
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                    class="h-[52px] w-full rounded-[8px] border bg-white pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:ring-1 {{ $errors->has('email') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-[#4d827c] focus:border-[#0d9488] focus:ring-[#0d9488]' }}"
                                    placeholder="admin.rumahsakit@gmail.com" required autofocus autocomplete="username">
                            </div>
                            @error('email')
                                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-medium text-slate-800">Password</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-800">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </span>
                                <input id="password" type="password" name="password"
                                    class="h-[52px] w-full rounded-[8px] border bg-white pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:ring-1 {{ $errors->has('password') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-[#4d827c] focus:border-[#0d9488] focus:ring-[#0d9488]' }}"
                                    placeholder="************" required autocomplete="current-password">
                            </div>
                            @error('password')
                                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <label for="remember_me" class="flex w-fit cursor-pointer items-center gap-3 text-sm font-medium text-slate-800">
                            <span class="relative flex h-5 w-5 items-center justify-center">
                                <input id="remember_me" type="checkbox" name="remember"
                                    class="peer h-5 w-5 appearance-none rounded-[3px] border border-[#6a7374] bg-white transition checked:border-[#0d9488] checked:bg-[#0d9488] focus:outline-none focus:ring-2 focus:ring-teal-500/30">
                                <i class="fa-solid fa-check pointer-events-none absolute text-[10px] text-white opacity-0 transition peer-checked:opacity-100"></i>
                            </span>
                            <span>Ingat Saya</span>
                        </label>

                        <button type="submit"
                            class="flex h-[52px] w-full items-center justify-center gap-3 rounded-[8px] bg-[#119c8f] px-5 text-sm font-semibold text-white shadow-[0_8px_16px_rgba(17,156,143,0.28)] transition hover:bg-[#0c8579] focus:outline-none focus:ring-2 focus:ring-teal-500/60">
                            <span>Masuk Ke Sistem</span>
                            <i class="fa-solid fa-arrow-right text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>

            <footer class="relative z-10 mt-5 text-center text-[12px] font-semibold leading-5 text-slate-800">
                <p>2026 Teknologi Radiologi Pencitraan<br>
                    Universitas Airlangga
                </p>
            </footer>
        </section>
    </main>
</body>

</html>
