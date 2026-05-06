@props([
    'title',
    'subtitle' => null,
    'breadcrumbs' => [],
])

<div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-r from-teal-700 via-teal-600 to-teal-500 p-6 shadow-xl md:p-8">
    <div class="absolute top-0 right-0 h-64 w-64 -translate-y-1/2 translate-x-1/2 rounded-full bg-white/10"></div>
    <div class="absolute bottom-0 left-0 h-48 w-48 -translate-x-1/2 translate-y-1/2 rounded-full bg-white/10"></div>

    <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div class="max-w-xl">
            @if (! empty($breadcrumbs))
                <nav class="mb-3 flex flex-wrap items-center gap-2 text-sm font-semibold text-teal-50/90 md:text-base">
                    @foreach ($breadcrumbs as $breadcrumb)
                        @if (! $loop->first)
                            <i class="fas fa-chevron-right text-xs text-teal-50/70"></i>
                        @endif

                        @if (! empty($breadcrumb['url']))
                            <a href="{{ $breadcrumb['url'] }}" class="transition-colors hover:text-white">
                                {{ $breadcrumb['label'] }}
                            </a>
                        @else
                            <span class="text-white">{{ $breadcrumb['label'] }}</span>
                        @endif
                    @endforeach
                </nav>
            @endif

            <h1 class="text-2xl font-display font-bold text-white md:text-3xl">{{ $title }}</h1>

            @if ($subtitle)
                <p class="mt-3 text-sm text-teal-100 md:text-lg">{{ $subtitle }}</p>
            @endif
        </div>

        <div class="flex flex-wrap items-center justify-start gap-4 sm:gap-5 lg:justify-end">
            <img src="{{ asset('images/logo-unair-login.png') }}" alt="Logo Universitas Airlangga"
                class="h-14 w-auto object-contain drop-shadow-lg md:h-20">
            <img src="{{ asset('images/logo-vokasi-login.png') }}" alt="Logo Vokasi Sigap"
                class="h-10 w-auto object-contain drop-shadow-lg md:h-14">
            <img src="{{ asset('images/logo-rsud-login.png') }}" alt="Logo RSUD Syarifah Ambami Rato Ebu Bangkalan"
                class="h-14 w-auto object-contain drop-shadow-lg md:h-20">
            <img src="{{ asset('images/logo-rrtrack-login.png') }}" alt="Logo RR-Track"
                class="h-14 w-auto object-contain drop-shadow-lg md:h-20">
        </div>
    </div>
</div>
