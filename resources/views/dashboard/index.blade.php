@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-teal-700 via-teal-600 to-teal-500 p-8 mb-8 shadow-xl">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
    <div class="relative z-10 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-display font-bold text-white mb-2">
                Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}! 🎉
            </h1>
            <p class="text-teal-100 text-lg">
                Kelola laporan pemeriksaan radiologi dengan mudah dan efisien
            </p>
        </div>
        <div class="hidden lg:block">
            <img src="{{ asset('images/logo.png') }}" alt="RR-Track Logo" class="h-24 w-auto opacity-90">
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Laporan -->
    <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-file-medical text-2xl text-white"></i>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-teal-50 text-teal-600">
                <i class="fas fa-arrow-up mr-1"></i> Total
            </span>
        </div>
        <p class="text-3xl font-display font-bold text-slate-800 mb-1">{{ number_format($totalLaporan) }}</p>
        <p class="text-slate-500 text-sm">Total Semua Laporan</p>
    </div>

    <!-- Total Repeat -->
    <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-400 to-cyan-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-sync-alt text-2xl text-white"></i>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-cyan-50 text-cyan-600">
                <i class="fas fa-redo mr-1"></i> Repeat
            </span>
        </div>
        <p class="text-3xl font-display font-bold text-slate-800 mb-1">{{ number_format($totalRepeat) }}</p>
        <p class="text-slate-500 text-sm">Laporan Pemeriksaan Ulang</p>
    </div>

    <!-- Total Reject -->
    <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-ban text-2xl text-white"></i>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600">
                <i class="fas fa-times mr-1"></i> Reject
            </span>
        </div>
        <p class="text-3xl font-display font-bold text-slate-800 mb-1">{{ number_format($totalReject) }}</p>
        <p class="text-slate-500 text-sm">Laporan Pemeriksaan Ditolak</p>
    </div>

    <!-- Laporan Bulan Ini -->
    <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-calendar-check text-2xl text-white"></i>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-600">
                <i class="fas fa-clock mr-1"></i> Bulan Ini
            </span>
        </div>
        <p class="text-3xl font-display font-bold text-slate-800 mb-1">{{ number_format($laporanBulanIni) }}</p>
        <p class="text-slate-500 text-sm">Laporan {{ now()->translatedFormat('F Y') }}</p>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Bar Chart - Laporan Bulanan -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-display font-bold text-slate-800">Statistik Bulanan</h3>
                <p class="text-sm text-slate-500">Tren laporan 6 bulan terakhir</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center">
                <i class="fas fa-chart-bar text-teal-500"></i>
            </div>
        </div>
        <div class="h-80">
            <canvas id="chartBulanan"></canvas>
        </div>
    </div>

    <!-- Pie Chart - Repeat vs Reject -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-display font-bold text-slate-800">Distribusi Jenis Laporan</h3>
                <p class="text-sm text-slate-500">Perbandingan repeat & reject</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-cyan-50 flex items-center justify-center">
                <i class="fas fa-chart-pie text-cyan-500"></i>
            </div>
        </div>
        <div class="h-80 flex items-center justify-center">
            <canvas id="chartJenisLaporan"></canvas>
        </div>
    </div>

    <!-- Bar Chart - Per Modalitas -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-display font-bold text-slate-800">Laporan Per Modalitas</h3>
                <p class="text-sm text-slate-500">Distribusi berdasarkan alat pemeriksaan</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                <i class="fas fa-x-ray text-emerald-500"></i>
            </div>
        </div>
        <div class="h-80">
            <canvas id="chartModalitas"></canvas>
        </div>
    </div>

    <!-- Doughnut Chart - Faktor Penyebab -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-display font-bold text-slate-800">Faktor Penyebab</h3>
                <p class="text-sm text-slate-500">Analisis penyebab repeat/reject</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-amber-500"></i>
            </div>
        </div>
        <div class="h-80 flex items-center justify-center">
            <canvas id="chartFaktorPenyebab"></canvas>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <a href="{{ route('laporan.repeat.create') }}" class="group relative overflow-hidden bg-gradient-to-r from-cyan-500 to-cyan-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center space-x-4">
            <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-plus text-2xl text-white"></i>
            </div>
            <div>
                <h3 class="text-xl font-display font-bold text-white">Tambah Laporan Repeat</h3>
                <p class="text-cyan-100">Buat laporan pemeriksaan ulang baru</p>
            </div>
        </div>
        <i class="fas fa-arrow-right absolute right-6 top-1/2 -translate-y-1/2 text-white/50 group-hover:text-white group-hover:translate-x-2 transition-all duration-300"></i>
    </a>

    <a href="{{ route('laporan.reject.create') }}" class="group relative overflow-hidden bg-gradient-to-r from-rose-500 to-rose-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center space-x-4">
            <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-plus text-2xl text-white"></i>
            </div>
            <div>
                <h3 class="text-xl font-display font-bold text-white">Tambah Laporan Reject</h3>
                <p class="text-rose-100">Buat laporan pemeriksaan ditolak baru</p>
            </div>
        </div>
        <i class="fas fa-arrow-right absolute right-6 top-1/2 -translate-y-1/2 text-white/50 group-hover:text-white group-hover:translate-x-2 transition-all duration-300"></i>
    </a>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.plugins.legend.labels.usePointStyle = true;

    const gradientColors = ['#14b8a6', '#0d9488', '#0f766e', '#115e59', '#134e4a', '#06b6d4', '#0891b2', '#0e7490'];

    // Bar Chart - Laporan Bulanan
    new Chart(document.getElementById('chartBulanan'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartBulanan['labels']) !!},
            datasets: [{
                label: 'Repeat',
                data: {!! json_encode($chartBulanan['repeat']) !!},
                backgroundColor: 'rgba(6, 182, 212, 0.8)',
                borderWidth: 0,
                borderRadius: 8,
            }, {
                label: 'Reject',
                data: {!! json_encode($chartBulanan['reject']) !!},
                backgroundColor: 'rgba(244, 63, 94, 0.8)',
                borderWidth: 0,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top', align: 'end' } },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } }
            }
        }
    });

    // Doughnut Chart - Jenis Laporan
    new Chart(document.getElementById('chartJenisLaporan'), {
        type: 'doughnut',
        data: {
            labels: ['Repeat', 'Reject'],
            datasets: [{
                data: [{{ $totalRepeat }}, {{ $totalReject }}],
                backgroundColor: ['rgba(6, 182, 212, 0.9)', 'rgba(244, 63, 94, 0.9)'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // Bar Chart - Modalitas
    new Chart(document.getElementById('chartModalitas'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartModalitas['labels']) !!},
            datasets: [{
                label: 'Jumlah Laporan',
                data: {!! json_encode($chartModalitas['data']) !!},
                backgroundColor: gradientColors.slice(0, {!! count($chartModalitas['labels']) !!}),
                borderWidth: 0,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                y: { grid: { display: false } }
            }
        }
    });

    // Doughnut Chart - Faktor Penyebab
    new Chart(document.getElementById('chartFaktorPenyebab'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($chartFaktor['labels']) !!},
            datasets: [{
                data: {!! json_encode($chartFaktor['data']) !!},
                backgroundColor: ['rgba(20, 184, 166, 0.9)', 'rgba(245, 158, 11, 0.9)', 'rgba(168, 85, 247, 0.9)', 'rgba(6, 182, 212, 0.9)'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endpush
