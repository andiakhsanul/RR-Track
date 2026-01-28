@extends('layouts.app')

@section('title', 'Daftar Laporan Reject')
@section('page-title', 'Laporan Reject')

@section('content')
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-display font-bold text-slate-800 mb-1">Daftar Laporan Reject</h1>
            <p class="text-slate-500">Kelola semua laporan pemeriksaan yang ditolak</p>
        </div>
        <a href="{{ route('laporan.create', ['jenis' => 'reject']) }}"
            class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
            <i class="fas fa-plus mr-2"></i>
            Tambah Laporan
        </a>
    </div>

    <!-- Stats Mini Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                    <i class="fas fa-file-alt text-red-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $laporanList->total() }}</p>
                    <p class="text-sm text-slate-500">Total Laporan</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <i class="fas fa-calendar-day text-green-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">
                        {{ $laporanList->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                    <p class="text-sm text-slate-500">Bulan Ini</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                    <i class="fas fa-clock text-purple-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">
                        {{ $laporanList->where('created_at', '>=', now()->startOfWeek())->count() }}</p>
                    <p class="text-sm text-slate-500">Minggu Ini</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <!-- Search & Filter -->
        <div class="p-6 border-b border-slate-100">
            <form action="{{ route('laporan.reject.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama pasien, no. RM, atau keterangan..."
                        class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-red-500 focus:bg-white transition-all">
                </div>
                <button type="submit"
                    class="px-6 py-3 bg-slate-800 text-white font-medium rounded-xl hover:bg-slate-700 transition-colors">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Pasien
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Pemeriksaan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Petugas</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($laporanList as $index => $laporan)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-slate-600">{{ $laporanList->firstItem() + $index }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-calendar text-red-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">
                                            {{ $laporan->tanggal_pemeriksaan->format('d M Y') }}</p>
                                        <p class="text-xs text-slate-500">{{ $laporan->created_at->format('H:i') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">{{ $laporan->pasien->nama_pasien ?? '-' }}
                                    </p>
                                    <p class="text-xs text-slate-500">RM: {{ $laporan->pasien->no_rm ?? '-' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-medium text-slate-800">
                                        {{ $laporan->jenisPemeriksaan->nama_jenis_pemeriksaan ?? '-' }}</p>
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
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center mr-2">
                                        <span
                                            class="text-white text-xs font-bold">{{ substr($laporan->petugas->inisial ?? 'N', 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm text-slate-700">{{ $laporan->petugas->inisial ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('laporan.reject.show', $laporan) }}"
                                        class="p-2 rounded-lg bg-slate-100 text-slate-600 hover:bg-red-100 hover:text-red-600 transition-colors"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('laporan.reject.edit', $laporan) }}"
                                        class="p-2 rounded-lg bg-slate-100 text-slate-600 hover:bg-yellow-100 hover:text-yellow-600 transition-colors"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('laporan.reject.destroy', $laporan) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 rounded-lg bg-slate-100 text-slate-600 hover:bg-red-100 hover:text-red-600 transition-colors"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                                        <i class="fas fa-inbox text-3xl text-slate-400"></i>
                                    </div>
                                    <p class="text-slate-500 font-medium mb-2">Belum ada data laporan</p>
                                    <p class="text-sm text-slate-400 mb-4">Mulai tambahkan laporan pertama Anda</p>
                                    <a href="{{ route('laporan.create', ['jenis' => 'reject']) }}"
                                        class="inline-flex items-center px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition-colors">
                                        <i class="fas fa-plus mr-2"></i> Tambah Laporan
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($laporanList->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $laporanList->links() }}
            </div>
        @endif
    </div>
@endsection