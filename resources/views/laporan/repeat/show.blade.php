@extends('layouts.app')

@section('title', 'Detail Laporan Repeat')
@section('page-title', 'Detail Laporan')

@section('content')
<!-- Header -->
<div class="mb-8">
    <nav class="flex items-center space-x-2 text-sm text-slate-500 mb-4">
        <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('laporan.repeat.index') }}" class="hover:text-primary-600 transition-colors">Laporan Repeat</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-slate-800 font-medium">Detail</span>
    </nav>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-slate-800">Detail Laporan Repeat</h1>
            <p class="text-slate-500 mt-1">Informasi lengkap laporan pemeriksaan ulang</p>
        </div>
        <div class="flex items-center space-x-3 mt-4 md:mt-0">
            <a href="{{ route('laporan.repeat.edit', $laporan) }}"
               class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white font-medium rounded-xl hover:bg-yellow-600 transition-colors">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <form action="{{ route('laporan.repeat.destroy', $laporan) }}" method="POST" class="inline"
                  onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white font-medium rounded-xl hover:bg-red-600 transition-colors">
                    <i class="fas fa-trash mr-2"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Info Laporan -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-teal-50 to-cyan-50">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-teal-600 flex items-center justify-center mr-3">
                        <i class="fas fa-file-medical text-white text-sm"></i>
                    </div>
                    Informasi Laporan
                </h2>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <dt class="text-sm font-medium text-slate-500 mb-1">Tanggal Pemeriksaan</dt>
                        <dd class="text-lg font-semibold text-slate-800">{{ $laporan->tanggal_pemeriksaan->format('d F Y') }}</dd>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <dt class="text-sm font-medium text-slate-500 mb-1">Jenis Laporan</dt>
                        <dd>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-teal-100 text-blue-700">
                                <i class="fas fa-sync-alt mr-2"></i> Repeat
                            </span>
                        </dd>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <dt class="text-sm font-medium text-slate-500 mb-1">Modalitas</dt>
                        <dd class="text-lg font-semibold text-slate-800">{{ $laporan->modalitas->nama_modalitas ?? '-' }}</dd>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <dt class="text-sm font-medium text-slate-500 mb-1">Jenis Pemeriksaan</dt>
                        <dd class="text-lg font-semibold text-slate-800">{{ $laporan->jenisPemeriksaan->nama_jenis_pemeriksaan ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Info Pasien -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-green-50 to-emerald-50">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-green-500 flex items-center justify-center mr-3">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    Informasi Pasien
                </h2>
            </div>
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center mr-4">
                        <span class="text-2xl font-bold text-white">{{ substr($laporan->pasien->nama_pasien ?? 'N', 0, 1) }}</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">{{ $laporan->pasien->nama_pasien ?? '-' }}</h3>
                        <p class="text-slate-500">No. RM: {{ $laporan->pasien->no_rm ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Insiden Khusus -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-orange-50 to-amber-50">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-orange-500 flex items-center justify-center mr-3">
                        <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                    </div>
                    Insiden Khusus
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Kesalahan Pemberian Label -->
                    <div class="p-4 rounded-xl {{ $laporan->kesalahan_label ? 'bg-orange-100 border-2 border-orange-300' : 'bg-slate-50' }}">
                        <div class="flex items-center">
                            @if($laporan->kesalahan_label)
                                <i class="fas fa-check-circle text-orange-600 text-xl mr-3"></i>
                            @else
                                <i class="fas fa-times-circle text-slate-400 text-xl mr-3"></i>
                            @endif
                            <div>
                                <span class="text-sm font-medium {{ $laporan->kesalahan_label ? 'text-orange-700' : 'text-slate-500' }}">Kesalahan Pemberian Label</span>
                                <p class="text-xs {{ $laporan->kesalahan_label ? 'text-orange-600' : 'text-slate-400' }}">{{ $laporan->kesalahan_label ? 'Ya' : 'Tidak' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Insiden Reaksi Obat Kontras -->
                    <div class="p-4 rounded-xl {{ $laporan->insiden_reaksi_obat_kontras ? 'bg-orange-100 border-2 border-orange-300' : 'bg-slate-50' }}">
                        <div class="flex items-center">
                            @if($laporan->insiden_reaksi_obat_kontras)
                                <i class="fas fa-check-circle text-orange-600 text-xl mr-3"></i>
                            @else
                                <i class="fas fa-times-circle text-slate-400 text-xl mr-3"></i>
                            @endif
                            <div>
                                <span class="text-sm font-medium {{ $laporan->insiden_reaksi_obat_kontras ? 'text-orange-700' : 'text-slate-500' }}">Insiden Reaksi Obat Kontras</span>
                                <p class="text-xs {{ $laporan->insiden_reaksi_obat_kontras ? 'text-orange-600' : 'text-slate-400' }}">{{ $laporan->insiden_reaksi_obat_kontras ? 'Ya' : 'Tidak' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keterangan -->
        @if($laporan->keterangan)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-purple-50 to-pink-50">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-purple-500 flex items-center justify-center mr-3">
                        <i class="fas fa-comment-alt text-white text-sm"></i>
                    </div>
                    Keterangan
                </h2>
            </div>
            <div class="p-6">
                <p class="text-slate-700 leading-relaxed">{{ $laporan->keterangan }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <div class="sticky top-24 space-y-6">
            <!-- Petugas Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">Petugas</h3>
                <div class="flex items-center">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center mr-4">
                        <span class="text-xl font-bold text-white">{{ substr($laporan->petugas->inisial ?? 'N', 0, 1) }}</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-800">{{ $laporan->petugas->inisial ?? '-' }}</h4>
                        <p class="text-sm text-slate-500">Radiografer</p>
                    </div>
                </div>
            </div>

            <!-- Timeline Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3 mt-0.5">
                            <i class="fas fa-plus text-green-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-800">Dibuat</p>
                            <p class="text-xs text-slate-500">{{ $laporan->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @if($laporan->updated_at != $laporan->created_at)
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center mr-3 mt-0.5">
                            <i class="fas fa-edit text-yellow-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-800">Diperbarui</p>
                            <p class="text-xs text-slate-500">{{ $laporan->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">Aksi</h3>
                <div class="space-y-3">
                    <a href="{{ route('laporan.repeat.index') }}" class="w-full py-3 bg-slate-100 text-slate-700 font-semibold rounded-xl hover:bg-slate-200 transition-colors flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
