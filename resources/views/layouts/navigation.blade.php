<nav x-data="{ open: false, showLogoutModal: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo-rrtrack-login.png') }}" alt="RR-Track Logo" class="h-9 w-auto">
                        <span class="font-bold text-xl text-teal-700">RR-Track</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- Dashboard Link -->
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-teal-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                        {{ __('Dashboard') }}
                    </a>

                    <!-- Input Link -->
                    <a href="{{ route('laporan.create') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('laporan.create') ? 'border-teal-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                        {{ __('Input') }}
                    </a>

                    <!-- Pelaporan Link -->
                    <a href="{{ route('pelaporan') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('pelaporan') || request()->routeIs('laporan.repeat.*') || request()->routeIs('laporan.reject.*') || request()->routeIs('laporan.export.*') ? 'border-teal-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                        {{ __('Pelaporan') }}
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <!-- Logout Button - triggers modal -->
                        <button type="button" @click="showLogoutModal = true; open = false"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Log Out') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}"
                class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('dashboard') ? 'border-teal-500 text-teal-700 bg-teal-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition duration-150 ease-in-out">
                {{ __('Dashboard') }}
            </a>
            <a href="{{ route('laporan.create') }}"
                class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('laporan.create') ? 'border-teal-500 text-teal-700 bg-teal-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition duration-150 ease-in-out">
                {{ __('Input') }}
            </a>
            <a href="{{ route('pelaporan') }}"
                class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('pelaporan') || request()->routeIs('laporan.repeat.*') || request()->routeIs('laporan.reject.*') || request()->routeIs('laporan.export.*') ? 'border-teal-500 text-teal-700 bg-teal-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition duration-150 ease-in-out">
                {{ __('Pelaporan') }}
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Logout Button - triggers modal -->
                <button type="button" @click="showLogoutModal = true"
                    class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    {{ __('Log Out') }}
                </button>
            </div>
        </div>
    </div>

    <!-- ========================================= -->
    <!-- Beautiful Logout Confirmation Modal -->
    <!-- ========================================= -->
    <div x-show="showLogoutModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showLogoutModal = false"></div>

        <!-- Modal Card -->
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden" x-show="showLogoutModal"
            x-transition:enter="transition ease-out duration-300 delay-100"
            x-transition:enter-start="opacity-0 scale-90 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 translate-y-4">

            <!-- Top Decorative Bar -->
            <div class="h-1.5 bg-gradient-to-r from-red-400 via-red-500 to-rose-500"></div>

            <!-- Modal Body -->
            <div class="px-8 pt-8 pb-3 text-center">
                <!-- Animated Icon -->
                <div
                    class="mx-auto w-20 h-20 rounded-full bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center mb-5 ring-4 ring-red-50">
                    <div
                        class="w-14 h-14 rounded-full bg-gradient-to-br from-red-400 to-red-500 flex items-center justify-center shadow-lg shadow-red-200">
                        <i class="fas fa-sign-out-alt text-2xl text-white"></i>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-slate-800 mb-2">Konfirmasi Logout</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Apakah Anda yakin ingin keluar dari akun <span
                        class="font-semibold text-slate-700">{{ Auth::user()->name }}</span>?
                    Anda perlu login kembali untuk mengakses sistem.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="px-8 pb-8 pt-4 flex gap-3">
                <button type="button" @click="showLogoutModal = false"
                    class="flex-1 py-3 px-4 bg-slate-100 text-slate-700 font-semibold rounded-xl hover:bg-slate-200 active:scale-95 transition-all duration-200 text-sm">
                    <i class="fas fa-arrow-left mr-1.5"></i> Batal
                </button>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                        class="w-full py-3 px-4 bg-gradient-to-r from-red-500 to-rose-500 text-white font-semibold rounded-xl hover:from-red-600 hover:to-rose-600 shadow-lg shadow-red-200 hover:shadow-xl hover:shadow-red-300 active:scale-95 transform hover:-translate-y-0.5 transition-all duration-200 text-sm">
                        <i class="fas fa-sign-out-alt mr-1.5"></i> Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
