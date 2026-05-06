@extends('layouts.app')

@section('title', 'Edit Laporan Reject')
@section('page-title', 'Edit Laporan Reject')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
    <!-- Main Form Column -->
    <div class="xl:col-span-3 space-y-6">
        <form action="{{ route('laporan.reject.update', $laporan) }}" method="POST" id="form-edit-reject">
            @csrf
            @method('PUT')

            <!-- Edit Mode Banner -->
            <div class="bg-gradient-to-r from-yellow-400 via-orange-400 to-yellow-500 rounded-2xl p-6 mb-6 shadow-lg">
                <div class="flex items-center">
                    <div class="w-14 h-14 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center mr-5">
                        <i class="fas fa-edit text-2xl text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Mode Edit</h2>
                        <p class="text-yellow-100">Anda sedang mengedit Laporan Reject #{{ $laporan->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Data Laporan Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-file-medical mr-3"></i>
                        Data Laporan
                    </h2>
                </div>
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Tanggal Laporan -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">
                                Tanggal Pemeriksaan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar text-slate-400"></i>
                                </div>
                                <input type="date" name="tanggal_pemeriksaan"
                                       value="{{ old('tanggal_pemeriksaan', $laporan->tanggal_pemeriksaan->format('Y-m-d')) }}"
                                       class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-red-500 focus:bg-white transition-all @error('tanggal_pemeriksaan') border-red-500 @enderror">
                            </div>
                            @error('tanggal_pemeriksaan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Modalitas -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">
                                Modalitas <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-x-ray text-slate-400"></i>
                                </div>
                                <select name="id_modalitas"
                                        class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-red-500 focus:bg-white transition-all appearance-none @error('id_modalitas') border-red-500 @enderror">
                                    <option value="">Pilih Modalitas</option>
                                    @foreach($modalitas as $m)
                                        <option value="{{ $m->id_modalitas }}" {{ old('id_modalitas', $laporan->id_modalitas) == $m->id_modalitas ? 'selected' : '' }}>{{ $m->nama_modalitas }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-slate-400 text-sm"></i>
                                </div>
                            </div>
                            @error('id_modalitas')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Jenis Pemeriksaan -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">
                                Jenis Pemeriksaan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-stethoscope text-slate-400"></i>
                                </div>
                                <select name="id_jenis_pemeriksaan"
                                        class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-red-500 focus:bg-white transition-all appearance-none @error('id_jenis_pemeriksaan') border-red-500 @enderror">
                                    <option value="">Pilih Jenis Pemeriksaan</option>
                                    @foreach($jenisPemeriksaan as $jp)
                                        <option value="{{ $jp->id_jenis_pemeriksaan }}" {{ old('id_jenis_pemeriksaan', $laporan->id_jenis_pemeriksaan) == $jp->id_jenis_pemeriksaan ? 'selected' : '' }}>{{ $jp->nama_jenis_pemeriksaan }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-slate-400 text-sm"></i>
                                </div>
                            </div>
                            @error('id_jenis_pemeriksaan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Petugas -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">
                                Petugas <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-user-nurse text-slate-400"></i>
                                </div>
                                <select name="id_petugas"
                                        class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-red-500 focus:bg-white transition-all appearance-none @error('id_petugas') border-red-500 @enderror">
                                    <option value="">Pilih Petugas</option>
                                    @foreach($petugas as $p)
                                        <option value="{{ $p->id_petugas }}" {{ old('id_petugas', $laporan->id_petugas) == $p->id_petugas ? 'selected' : '' }}>{{ $p->inisial }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-slate-400 text-sm"></i>
                                </div>
                            </div>
                            @error('id_petugas')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Pasien Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-user-injured mr-3"></i>
                        Data Pasien
                    </h2>
                </div>
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- No RM -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">
                                No. Rekam Medis <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-id-card text-slate-400"></i>
                                </div>
                                <input type="text" name="no_rm" value="{{ old('no_rm', $laporan->pasien->no_rm ?? '') }}" placeholder="Masukkan No. RM"
                                       class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-red-500 focus:bg-white transition-all @error('no_rm') border-red-500 @enderror">
                            </div>
                            @error('no_rm')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Pasien -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">
                                Nama Pasien <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-slate-400"></i>
                                </div>
                                <input type="text" name="nama_pasien" value="{{ old('nama_pasien', $laporan->pasien->nama_pasien ?? '') }}" placeholder="Masukkan nama pasien"
                                       class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-red-500 focus:bg-white transition-all @error('nama_pasien') border-red-500 @enderror">
                            </div>
                            @error('nama_pasien')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Faktor Penyebab Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-visible mb-6">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3"></i>
                        Faktor Penyebab Reject
                    </h2>
                </div>
                <div class="p-6">
                    <p class="text-sm text-slate-500 mb-4">Pilih satu atau lebih faktor penyebab reject</p>
                    @php
                        $selectedFaktors = old('faktor', $laporan->faktorPenyebab->pluck('id_faktor')->toArray());
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($faktorPenyebab as $faktor)
                            <x-faktor-option
                                :faktor="$faktor"
                                tone="red"
                                :checked="in_array($faktor->id_faktor, $selectedFaktors)"
                            />
                        @endforeach
                    </div>
                    @error('faktor')
                        <p class="text-red-500 text-sm mt-3">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Insiden Khusus Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-exclamation-circle mr-3"></i>
                        Insiden Khusus
                    </h2>
                </div>
                <div class="p-6">
                    <p class="text-sm text-slate-500 mb-4">Centang jika terjadi insiden khusus berikut:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Kesalahan Pemberian Label -->
                        <label class="relative flex items-start p-4 bg-slate-50 rounded-xl border-2 {{ old('kesalahan_label', $laporan->kesalahan_label) ? 'border-yellow-400 bg-yellow-50' : 'border-transparent' }} hover:border-yellow-300 hover:bg-yellow-50 cursor-pointer transition-all group">
                            <input type="checkbox" name="kesalahan_label" value="1"
                                   class="h-5 w-5 rounded border-slate-300 text-yellow-600 focus:ring-yellow-500 mt-0.5"
                                   {{ old('kesalahan_label', $laporan->kesalahan_label) ? 'checked' : '' }}>
                            <div class="ml-3">
                                <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900">Kesalahan Pemberian Label</span>
                                <p class="text-xs text-slate-500 mt-1">Terjadi kesalahan dalam pemberian label pasien</p>
                            </div>
                        </label>

                        <!-- Insiden Reaksi Obat Kontras -->
                        <label class="relative flex items-start p-4 bg-slate-50 rounded-xl border-2 {{ old('insiden_reaksi_obat_kontras', $laporan->insiden_reaksi_obat_kontras) ? 'border-yellow-400 bg-yellow-50' : 'border-transparent' }} hover:border-yellow-300 hover:bg-yellow-50 cursor-pointer transition-all group">
                            <input type="checkbox" name="insiden_reaksi_obat_kontras" value="1"
                                   class="h-5 w-5 rounded border-slate-300 text-yellow-600 focus:ring-yellow-500 mt-0.5"
                                   {{ old('insiden_reaksi_obat_kontras', $laporan->insiden_reaksi_obat_kontras) ? 'checked' : '' }}>
                            <div class="ml-3">
                                <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900">Insiden Reaksi Obat Kontras</span>
                                <p class="text-xs text-slate-500 mt-1">Terjadi reaksi terhadap obat kontras</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Keterangan Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-comment-alt mr-3"></i>
                        Keterangan Tambahan
                    </h2>
                </div>
                <div class="p-6">
                    <textarea name="keterangan" rows="4" placeholder="Tambahkan keterangan atau catatan tambahan..."
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-red-500 focus:bg-white transition-all resize-none @error('keterangan') border-red-500 @enderror">{{ old('keterangan', $laporan->keterangan) }}</textarea>
                    @error('keterangan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons (Mobile) -->
            <div class="xl:hidden flex space-x-4">
                <a href="{{ route('laporan.reject.show', $laporan) }}"
                   class="flex-1 py-3 px-6 bg-slate-100 text-slate-700 font-semibold rounded-xl text-center hover:bg-slate-200 transition-all">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit"
                        class="flex-1 py-3 px-6 bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                    <i class="fas fa-save mr-2"></i> Update
                </button>
            </div>
        </form>
    </div>

    <!-- Sidebar Column -->
    <div class="xl:col-span-1">
        <div class="sticky top-8 space-y-6">
            <!-- Info Card -->
            <div class="bg-gradient-to-br from-yellow-400 via-orange-400 to-orange-500 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center mr-4">
                        <i class="fas fa-edit text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg">Edit Mode</h3>
                        <p class="text-yellow-100 text-sm">Laporan Reject #{{ $laporan->id }}</p>
                    </div>
                </div>
                <p class="text-sm text-yellow-100 leading-relaxed">
                    Perubahan akan disimpan setelah Anda menekan tombol "Update Laporan".
                </p>
            </div>

            <!-- Original Data Card -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                <h3 class="font-semibold text-slate-800 mb-4 flex items-center">
                    <i class="fas fa-history text-slate-500 mr-2"></i>
                    Data Asli
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Dibuat</span>
                        <span class="text-slate-700 font-medium">{{ $laporan->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Terakhir diubah</span>
                        <span class="text-slate-700 font-medium">{{ $laporan->updated_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Petugas awal</span>
                        <span class="text-slate-700 font-medium">{{ $laporan->petugas->inisial ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons (Desktop) -->
            <div class="hidden xl:block space-y-3">
                <button type="submit" form="form-edit-reject"
                        class="w-full py-3 px-6 bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                    <i class="fas fa-save mr-2"></i> Update Laporan
                </button>
                <a href="{{ route('laporan.reject.show', $laporan) }}"
                   class="w-full py-3 px-6 bg-slate-100 text-slate-700 font-semibold rounded-xl text-center hover:bg-slate-200 transition-all block">
                    <i class="fas fa-eye mr-2"></i> Lihat Detail
                </a>
                <a href="{{ route('laporan.reject.index') }}"
                   class="w-full py-3 px-6 bg-slate-100 text-slate-700 font-semibold rounded-xl text-center hover:bg-slate-200 transition-all block">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
