@extends('layouts.app')

@section('title', 'Pelaporan')
@section('page-title', 'Pelaporan')

@section('content')
    <!-- Page Header -->
    <x-page-hero
        title="Pelaporan"
        :subtitle="'Export data dan kelola laporan Reject & Repeat'"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Input', 'url' => route('laporan.create')],
            ['label' => 'Pelaporan'],
        ]"
    />

    <!-- ========================================= -->
    <!-- Section 1: Export Data -->
    <!-- ========================================= -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-emerald-500 via-emerald-500 to-teal-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-white flex items-center">
                        <i class="fas fa-file-excel mr-3 text-emerald-100"></i>
                        Export Data
                    </h2>
                    <p class="text-emerald-100 text-sm mt-0.5">Download data Repeat & Reject dalam format Excel</p>
                </div>
                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-file-download text-2xl text-white/80"></i>
                </div>
            </div>
        </div>

        <form action="{{ route('laporan.export') }}" method="POST">
            @csrf
            <div class="p-6 space-y-5">
                {{-- Row 1: Periode & Jenis Pemeriksaan --}}
                <div>
                    <div class="flex items-center space-x-2 mb-3">
                        <span
                            class="flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">1</span>
                        <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Periode & Jenis Pemeriksaan
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {{-- Bulan --}}
                        <div>
                            <label for="bulan" class="block text-sm font-medium text-slate-600 mb-1.5">
                                Bulan
                            </label>
                            <div class="relative">
                                <select name="bulan" id="bulan"
                                    class="w-full rounded-xl border-slate-200 bg-slate-50/50 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 focus:bg-white transition-all text-sm pl-9">
                                    <option value="">Pilih Bulan (Opsional)</option>
                                    @php
                                        $namaBulan = [
                                            1 => 'Januari',
                                            2 => 'Februari',
                                            3 => 'Maret',
                                            4 => 'April',
                                            5 => 'Mei',
                                            6 => 'Juni',
                                            7 => 'Juli',
                                            8 => 'Agustus',
                                            9 => 'September',
                                            10 => 'Oktober',
                                            11 => 'November',
                                            12 => 'Desember'
                                        ];
                                        $currentMonth = date('n');
                                    @endphp
                                    @foreach ($namaBulan as $num => $nama)
                                        <option value="{{ $num }}" {{ old('bulan') == $num ? 'selected' : '' }}>
                                            {{ $nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fas fa-calendar-alt text-slate-400 text-xs"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Tahun --}}
                        <div>
                            <label for="tahun" class="block text-sm font-medium text-slate-600 mb-1.5">
                                Tahun
                            </label>
                            <div class="relative">
                                <select name="tahun" id="tahun"
                                    class="w-full rounded-xl border-slate-200 bg-slate-50/50 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 focus:bg-white transition-all text-sm pl-9">
                                    <option value="">Pilih Tahun (Opsional)</option>
                                    @php $currentYear = date('Y'); @endphp
                                    @for ($year = $currentYear; $year >= 2020; $year--)
                                        <option value="{{ $year }}" {{ old('tahun') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fas fa-calendar text-slate-400 text-xs"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Jenis Pemeriksaan --}}
                        <div>
                            <label for="modalitas" class="block text-sm font-medium text-slate-600 mb-1.5">
                                Jenis Pemeriksaan <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <select name="modalitas" id="modalitas" required
                                    class="w-full rounded-xl border-slate-200 bg-slate-50/50 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 focus:bg-white transition-all text-sm pl-9">
                                    <option value="all" {{ old('modalitas', 'all') == 'all' ? 'selected' : '' }}>Semua (CT
                                        Scan & X-Ray)</option>
                                    <option value="ct_scan" {{ old('modalitas') == 'ct_scan' ? 'selected' : '' }}>CT Scan
                                    </option>
                                    <option value="x_ray" {{ old('modalitas') == 'x_ray' ? 'selected' : '' }}>X-Ray</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fas fa-x-ray text-slate-400 text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Row 2: Rentang Tanggal (Opsional) + Download --}}
                <div>
                    <div class="flex items-center space-x-2 mb-3">
                        <span
                            class="flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">2</span>
                        <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Rentang Tanggal <span
                                class="text-xs font-normal text-slate-400 normal-case">(Opsional)</span></h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        {{-- Tanggal Awal --}}
                        <div>
                            <label for="tanggal_awal" class="block text-sm font-medium text-slate-600 mb-1.5">
                                Tanggal Awal
                            </label>
                            <div class="relative">
                                <input type="date" name="tanggal_awal" id="tanggal_awal" value="{{ old('tanggal_awal') }}"
                                    class="w-full rounded-xl border-slate-200 bg-slate-50/50 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 focus:bg-white transition-all text-sm pl-9">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fas fa-calendar-day text-slate-400 text-xs"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Tanggal Akhir --}}
                        <div>
                            <label for="tanggal_akhir" class="block text-sm font-medium text-slate-600 mb-1.5">
                                Tanggal Akhir
                            </label>
                            <div class="relative">
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                                    value="{{ old('tanggal_akhir') }}"
                                    class="w-full rounded-xl border-slate-200 bg-slate-50/50 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 focus:bg-white transition-all text-sm pl-9">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fas fa-calendar-day text-slate-400 text-xs"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Download Button --}}
                        <div>
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center px-6 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:from-emerald-600 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 text-sm group">
                                <i
                                    class="fas fa-download mr-2 text-sm transition-transform group-hover:-translate-y-0.5"></i>
                                Download Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- ========================================= -->
    <!-- Section 2: Daftar Laporan Reject -->
    <!-- ========================================= -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-red-500 to-rose-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-white flex items-center">
                        <i class="fas fa-ban mr-3 text-red-100"></i>
                        Daftar Laporan Reject
                    </h2>
                    <p class="text-red-100 text-sm mt-0.5">Total: {{ $rejectList->total() }} laporan</p>
                </div>
            </div>
        </div>

        <!-- Reject Date Filter -->
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <form action="{{ route('pelaporan') }}" method="GET" class="flex flex-col md:flex-row md:items-end gap-3">
                {{-- Preserve repeat filters --}}
                @if(request('repeat_tanggal_mulai'))
                    <input type="hidden" name="repeat_tanggal_mulai" value="{{ request('repeat_tanggal_mulai') }}">
                @endif
                @if(request('repeat_tanggal_selesai'))
                    <input type="hidden" name="repeat_tanggal_selesai" value="{{ request('repeat_tanggal_selesai') }}">
                @endif
                <div class="flex-1">
                    <label class="block text-xs font-medium text-slate-600 mb-1">
                        <i class="fas fa-calendar-alt mr-1 text-slate-400"></i> Tanggal Mulai
                    </label>
                    <input type="date" name="reject_tanggal_mulai" value="{{ request('reject_tanggal_mulai') }}"
                        class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-red-500 focus:bg-white transition-all text-sm">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-medium text-slate-600 mb-1">
                        <i class="fas fa-calendar-alt mr-1 text-slate-400"></i> Tanggal Selesai
                    </label>
                    <input type="date" name="reject_tanggal_selesai" value="{{ request('reject_tanggal_selesai') }}"
                        class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-red-500 focus:bg-white transition-all text-sm">
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-slate-800 text-white font-medium rounded-xl hover:bg-slate-700 transition-colors text-sm">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    @if(request('reject_tanggal_mulai') || request('reject_tanggal_selesai'))
                                    <a href="{{ route('pelaporan', array_filter([
                            'repeat_tanggal_mulai' => request('repeat_tanggal_mulai'),
                            'repeat_tanggal_selesai' => request('repeat_tanggal_selesai'),
                        ])) }}"
                                        class="px-3 py-2 bg-slate-100 text-slate-600 font-medium rounded-xl hover:bg-slate-200 transition-colors text-sm">
                                        <i class="fas fa-times"></i>
                                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Reject Table -->
        <div class="overflow-auto max-h-[340px]">
            <table class="w-full">
                <thead class="sticky top-0 z-10">
                    <tr class="bg-slate-50 shadow-[0_1px_0_0_rgb(241,245,249)]">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Pasien
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Pemeriksaan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Petugas</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rejectList as $index => $laporan)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-slate-600">{{ $rejectList->firstItem() + $index }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center mr-2">
                                        <i class="fas fa-calendar text-red-600 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">
                                            {{ $laporan->tanggal_pemeriksaan->format('d M Y') }}
                                        </p>
                                        <p class="text-xs text-slate-500">{{ $laporan->created_at->format('H:i') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm font-semibold text-slate-800">{{ $laporan->pasien->nama_pasien ?? '-' }}</p>
                                <p class="text-xs text-slate-500">RM: {{ $laporan->pasien->no_rm ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-slate-800">
                                    {{ $laporan->jenisPemeriksaan->nama_jenis_pemeriksaan ?? '-' }}
                                </p>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-cyan-100 text-cyan-700">
                                    {{ $laporan->modalitas->nama_modalitas ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div
                                        class="w-7 h-7 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center mr-2">
                                        <span
                                            class="text-white text-xs font-bold">{{ substr($laporan->petugas->inisial ?? 'N', 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm text-slate-700">{{ $laporan->petugas->inisial ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center space-x-1">
                                    <a href="{{ route('laporan.reject.show', $laporan) }}"
                                        class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-red-100 hover:text-red-600 transition-colors"
                                        title="Detail">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('laporan.reject.edit', $laporan) }}"
                                        class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-yellow-100 hover:text-yellow-600 transition-colors"
                                        title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('laporan.reject.destroy', $laporan) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-red-100 hover:text-red-600 transition-colors"
                                            title="Hapus">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                        <i class="fas fa-inbox text-xl text-slate-400"></i>
                                    </div>
                                    <p class="text-slate-500 font-medium text-sm">Belum ada data laporan reject</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($rejectList->hasPages())
            <div class="px-4 py-3 border-t border-slate-100">
                {{ $rejectList->links() }}
            </div>
        @endif
    </div>

    <!-- ========================================= -->
    <!-- Section 3: Daftar Laporan Repeat -->
    <!-- ========================================= -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-white flex items-center">
                        <i class="fas fa-sync-alt mr-3 text-teal-100"></i>
                        Daftar Laporan Repeat
                    </h2>
                    <p class="text-teal-100 text-sm mt-0.5">Total: {{ $repeatList->total() }} laporan</p>
                </div>
            </div>
        </div>

        <!-- Repeat Date Filter -->
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <form action="{{ route('pelaporan') }}" method="GET" class="flex flex-col md:flex-row md:items-end gap-3">
                {{-- Preserve reject filters --}}
                @if(request('reject_tanggal_mulai'))
                    <input type="hidden" name="reject_tanggal_mulai" value="{{ request('reject_tanggal_mulai') }}">
                @endif
                @if(request('reject_tanggal_selesai'))
                    <input type="hidden" name="reject_tanggal_selesai" value="{{ request('reject_tanggal_selesai') }}">
                @endif
                <div class="flex-1">
                    <label class="block text-xs font-medium text-slate-600 mb-1">
                        <i class="fas fa-calendar-alt mr-1 text-slate-400"></i> Tanggal Mulai
                    </label>
                    <input type="date" name="repeat_tanggal_mulai" value="{{ request('repeat_tanggal_mulai') }}"
                        class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-teal-500 focus:bg-white transition-all text-sm">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-medium text-slate-600 mb-1">
                        <i class="fas fa-calendar-alt mr-1 text-slate-400"></i> Tanggal Selesai
                    </label>
                    <input type="date" name="repeat_tanggal_selesai" value="{{ request('repeat_tanggal_selesai') }}"
                        class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-teal-500 focus:bg-white transition-all text-sm">
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-slate-800 text-white font-medium rounded-xl hover:bg-slate-700 transition-colors text-sm">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    @if(request('repeat_tanggal_mulai') || request('repeat_tanggal_selesai'))
                                    <a href="{{ route('pelaporan', array_filter([
                            'reject_tanggal_mulai' => request('reject_tanggal_mulai'),
                            'reject_tanggal_selesai' => request('reject_tanggal_selesai'),
                        ])) }}"
                                        class="px-3 py-2 bg-slate-100 text-slate-600 font-medium rounded-xl hover:bg-slate-200 transition-colors text-sm">
                                        <i class="fas fa-times"></i>
                                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Repeat Table -->
        <div class="overflow-auto max-h-[340px]">
            <table class="w-full">
                <thead class="sticky top-0 z-10">
                    <tr class="bg-slate-50 shadow-[0_1px_0_0_rgb(241,245,249)]">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Pasien
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Pemeriksaan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Petugas</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($repeatList as $index => $laporan)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-slate-600">{{ $repeatList->firstItem() + $index }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-teal-100 flex items-center justify-center mr-2">
                                        <i class="fas fa-calendar text-teal-600 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">
                                            {{ $laporan->tanggal_pemeriksaan->format('d M Y') }}
                                        </p>
                                        <p class="text-xs text-slate-500">{{ $laporan->created_at->format('H:i') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm font-semibold text-slate-800">{{ $laporan->pasien->nama_pasien ?? '-' }}</p>
                                <p class="text-xs text-slate-500">RM: {{ $laporan->pasien->no_rm ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-slate-800">
                                    {{ $laporan->jenisPemeriksaan->nama_jenis_pemeriksaan ?? '-' }}
                                </p>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-cyan-100 text-cyan-700">
                                    {{ $laporan->modalitas->nama_modalitas ?? '-' }}
                                </span>
                                @if($laporan->kesalahan_label || $laporan->insiden_reaksi_obat_kontras)
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        @if($laporan->kesalahan_label)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700"
                                                title="Kesalahan Label">
                                                <i class="fas fa-tag mr-1"></i> Label
                                            </span>
                                        @endif
                                        @if($laporan->insiden_reaksi_obat_kontras)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700"
                                                title="Reaksi Obat Kontras">
                                                <i class="fas fa-syringe mr-1"></i> Kontras
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div
                                        class="w-7 h-7 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center mr-2">
                                        <span
                                            class="text-white text-xs font-bold">{{ substr($laporan->petugas->inisial ?? 'N', 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm text-slate-700">{{ $laporan->petugas->inisial ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center space-x-1">
                                    <a href="{{ route('laporan.repeat.show', $laporan) }}"
                                        class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-teal-100 hover:text-teal-600 transition-colors"
                                        title="Detail">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('laporan.repeat.edit', $laporan) }}"
                                        class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-yellow-100 hover:text-yellow-600 transition-colors"
                                        title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('laporan.repeat.destroy', $laporan) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-red-100 hover:text-red-600 transition-colors"
                                            title="Hapus">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                        <i class="fas fa-inbox text-xl text-slate-400"></i>
                                    </div>
                                    <p class="text-slate-500 font-medium text-sm">Belum ada data laporan repeat</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($repeatList->hasPages())
            <div class="px-4 py-3 border-t border-slate-100">
                {{ $repeatList->links() }}
            </div>
        @endif
    </div>
@endsection
