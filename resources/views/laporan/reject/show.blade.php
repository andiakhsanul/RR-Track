@extends('layouts.app')

@section('title', 'Detail Laporan Reject')
@section('page-title', 'Detail Laporan Reject')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
    <!-- Main Content Column -->
    <div class="xl:col-span-3 space-y-6">
        <!-- Header Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 via-red-600 to-rose-500 px-6 py-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center mr-5">
                            <i class="fas fa-times-circle text-3xl text-white"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 bg-white/20 backdrop-blur rounded-full text-sm text-white font-medium">
                                    ID: #{{ $laporan->id }}
                                </span>
                                <span class="px-3 py-1 bg-red-800/30 backdrop-blur rounded-full text-sm text-white font-medium">
                                    <i class="fas fa-times-circle mr-1"></i> Reject
                                </span>
                            </div>
                            <h1 class="text-2xl font-bold text-white">{{ $laporan->pasien->nama_pasien ?? 'N/A' }}</h1>
                            <p class="text-red-100">No. RM: {{ $laporan->pasien->no_rm ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="hidden md:block text-right">
                        <p class="text-red-100 text-sm">Tanggal Pemeriksaan</p>
                        <p class="text-white text-lg font-semibold">{{ $laporan->tanggal_pemeriksaan->format('d M Y') }}</p>
                        <p class="text-red-200 text-sm">{{ $laporan->created_at->format('H:i') }} WIB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Laporan Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center mr-3">
                        <i class="fas fa-file-medical text-red-600"></i>
                    </div>
                    Data Pemeriksaan
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-slate-50 rounded-xl p-5">
                        <p class="text-sm text-slate-500 mb-1">Modalitas</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-cyan-100 flex items-center justify-center mr-3">
                                <i class="fas fa-x-ray text-cyan-600"></i>
                            </div>
                            <p class="text-lg font-semibold text-slate-800">{{ $laporan->modalitas->nama_modalitas ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-5">
                        <p class="text-sm text-slate-500 mb-1">Jenis Pemeriksaan</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-3">
                                <i class="fas fa-stethoscope text-green-600"></i>
                            </div>
                            <p class="text-lg font-semibold text-slate-800">{{ $laporan->jenisPemeriksaan->nama_jenis_pemeriksaan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Faktor Penyebab Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center mr-3">
                        <i class="fas fa-exclamation-triangle text-orange-600"></i>
                    </div>
                    Faktor Penyebab Reject
                </h2>
            </div>
            <div class="p-6">
                @if($laporan->faktorPenyebab->count() > 0)
                    <div class="flex flex-wrap gap-3">
                        @foreach($laporan->faktorPenyebab as $faktor)
                            <span class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-red-700 rounded-xl font-medium">
                                <i class="fas fa-times-circle mr-2 text-red-500"></i>
                                {{ $faktor->nama_faktor }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500 italic">Tidak ada faktor penyebab yang tercatat</p>
                @endif
            </div>
        </div>

        <!-- Insiden Khusus Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-yellow-100 flex items-center justify-center mr-3">
                        <i class="fas fa-exclamation-circle text-yellow-600"></i>
                    </div>
                    Insiden Khusus
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Kesalahan Pemberian Label -->
                    <div class="p-4 rounded-xl {{ $laporan->kesalahan_label ? 'bg-yellow-100 border-2 border-yellow-300' : 'bg-slate-50' }}">
                        <div class="flex items-center">
                            @if($laporan->kesalahan_label)
                                <i class="fas fa-check-circle text-yellow-600 text-xl mr-3"></i>
                            @else
                                <i class="fas fa-times-circle text-slate-400 text-xl mr-3"></i>
                            @endif
                            <div>
                                <span class="text-sm font-medium {{ $laporan->kesalahan_label ? 'text-yellow-700' : 'text-slate-500' }}">Kesalahan Pemberian Label</span>
                                <p class="text-xs {{ $laporan->kesalahan_label ? 'text-yellow-600' : 'text-slate-400' }}">{{ $laporan->kesalahan_label ? 'Ya' : 'Tidak' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Insiden Reaksi Obat Kontras -->
                    <div class="p-4 rounded-xl {{ $laporan->insiden_reaksi_obat_kontras ? 'bg-yellow-100 border-2 border-yellow-300' : 'bg-slate-50' }}">
                        <div class="flex items-center">
                            @if($laporan->insiden_reaksi_obat_kontras)
                                <i class="fas fa-check-circle text-yellow-600 text-xl mr-3"></i>
                            @else
                                <i class="fas fa-times-circle text-slate-400 text-xl mr-3"></i>
                            @endif
                            <div>
                                <span class="text-sm font-medium {{ $laporan->insiden_reaksi_obat_kontras ? 'text-yellow-700' : 'text-slate-500' }}">Insiden Reaksi Obat Kontras</span>
                                <p class="text-xs {{ $laporan->insiden_reaksi_obat_kontras ? 'text-yellow-600' : 'text-slate-400' }}">{{ $laporan->insiden_reaksi_obat_kontras ? 'Ya' : 'Tidak' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keterangan Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center mr-3">
                        <i class="fas fa-comment-alt text-purple-600"></i>
                    </div>
                    Keterangan
                </h2>
            </div>
            <div class="p-6">
                @if($laporan->keterangan)
                    <div class="bg-slate-50 rounded-xl p-5">
                        <p class="text-slate-700 leading-relaxed">{{ $laporan->keterangan }}</p>
                    </div>
                @else
                    <p class="text-slate-500 italic">Tidak ada keterangan tambahan</p>
                @endif
            </div>
        </div>

        <!-- Action Buttons (Mobile) -->
        <div class="xl:hidden flex space-x-4">
            <a href="{{ route('laporan.reject.index') }}"
               class="flex-1 py-3 px-6 bg-slate-100 text-slate-700 font-semibold rounded-xl text-center hover:bg-slate-200 transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <a href="{{ route('laporan.reject.edit', $laporan) }}"
               class="flex-1 py-3 px-6 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold rounded-xl text-center shadow-lg hover:shadow-xl transition-all">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
        </div>
    </div>

    <!-- Sidebar Column -->
    <div class="xl:col-span-1">
        <div class="sticky top-8 space-y-6">
            <!-- Petugas Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="font-semibold text-slate-800">Petugas</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center mr-4">
                            <span class="text-white text-xl font-bold">{{ substr($laporan->petugas->inisial ?? 'N', 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800">{{ $laporan->petugas->inisial ?? '-' }}</p>
                            <p class="text-sm text-slate-500">Radiografer</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="font-semibold text-slate-800">Timeline</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-plus-circle text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-800">Dibuat</p>
                                <p class="text-xs text-slate-500">{{ $laporan->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        @if($laporan->updated_at && $laporan->updated_at->ne($laporan->created_at))
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-edit text-yellow-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-800">Diperbarui</p>
                                    <p class="text-xs text-slate-500">{{ $laporan->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons (Desktop) -->
            <div class="hidden xl:block space-y-3">
                <a href="{{ route('laporan.reject.edit', $laporan) }}"
                   class="w-full py-3 px-6 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all flex items-center justify-center">
                    <i class="fas fa-edit mr-2"></i> Edit Laporan
                </a>
                <form action="{{ route('laporan.reject.destroy', $laporan) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full py-3 px-6 bg-red-100 text-red-600 font-semibold rounded-xl hover:bg-red-200 transition-all flex items-center justify-center">
                        <i class="fas fa-trash mr-2"></i> Hapus Laporan
                    </button>
                </form>
                <a href="{{ route('laporan.reject.index') }}"
                   class="w-full py-3 px-6 bg-slate-100 text-slate-700 font-semibold rounded-xl text-center hover:bg-slate-200 transition-all block">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
