@extends('layouts.app')

@section('title', 'Tambah Laporan Repeat')
@section('page-title', 'Tambah Laporan Repeat')

@section('content')
<!-- Header -->
<div class="mb-8">
    <nav class="flex items-center space-x-2 text-sm text-slate-500 mb-4">
        <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('laporan.repeat.index') }}" class="hover:text-primary-600 transition-colors">Laporan Repeat</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-slate-800 font-medium">Tambah Baru</span>
    </nav>
    <h1 class="text-2xl font-display font-bold text-slate-800">Tambah Laporan Repeat Baru</h1>
    <p class="text-slate-500 mt-1">Isi formulir di bawah untuk membuat laporan pemeriksaan ulang</p>
</div>

<!-- Form Card -->
<form action="{{ route('laporan.repeat.store') }}" method="POST">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Data Laporan -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-teal-50 to-cyan-50">
                    <h2 class="text-lg font-semibold text-slate-800 flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-teal-600 flex items-center justify-center mr-3">
                            <i class="fas fa-file-medical text-white text-sm"></i>
                        </div>
                        Data Laporan
                    </h2>
                </div>
                <div class="p-6 space-y-5">
                    <!-- Tanggal -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Tanggal Pemeriksaan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_pemeriksaan" value="{{ old('tanggal_pemeriksaan', now()->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-teal-500 focus:bg-white transition-all @error('tanggal_pemeriksaan') border-red-500 @enderror">
                        @error('tanggal_pemeriksaan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Modalitas -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Modalitas <span class="text-red-500">*</span>
                            </label>
                            <select name="id_modalitas" id="id_modalitas"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-teal-500 focus:bg-white transition-all @error('id_modalitas') border-red-500 @enderror">
                                <option value="">-- Pilih Modalitas --</option>
                                @foreach($modalitas as $m)
                                    <option value="{{ $m->id_modalitas }}" {{ old('id_modalitas') == $m->id_modalitas ? 'selected' : '' }}>{{ $m->nama_modalitas }}</option>
                                @endforeach
                            </select>
                            @error('id_modalitas')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Pemeriksaan -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Jenis Pemeriksaan <span class="text-red-500">*</span>
                            </label>
                            <select name="id_jenis_pemeriksaan" id="id_jenis_pemeriksaan"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-teal-500 focus:bg-white transition-all @error('id_jenis_pemeriksaan') border-red-500 @enderror">
                                <option value="">-- Pilih Jenis --</option>
                                @foreach($jenisPemeriksaan as $jp)
                                    <option value="{{ $jp->id_jenis_pemeriksaan }}" {{ old('id_jenis_pemeriksaan') == $jp->id_jenis_pemeriksaan ? 'selected' : '' }}>{{ $jp->nama_jenis_pemeriksaan }}</option>
                                @endforeach
                            </select>
                            @error('id_jenis_pemeriksaan')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Petugas -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Petugas <span class="text-red-500">*</span>
                        </label>
                        <select name="id_petugas"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-teal-500 focus:bg-white transition-all @error('id_petugas') border-red-500 @enderror">
                            <option value="">-- Pilih Petugas --</option>
                            @foreach($petugas as $p)
                                <option value="{{ $p->id_petugas }}" {{ old('id_petugas') == $p->id_petugas ? 'selected' : '' }}>{{ $p->inisial }}</option>
                            @endforeach
                        </select>
                        @error('id_petugas')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Data Pasien -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-green-50 to-emerald-50">
                    <h2 class="text-lg font-semibold text-slate-800 flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-green-500 flex items-center justify-center mr-3">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        Data Pasien
                    </h2>
                </div>
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- No RM -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                No. Rekam Medis <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="no_rm" value="{{ old('no_rm') }}" placeholder="Contoh: 123456"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-green-500 focus:bg-white transition-all @error('no_rm') border-red-500 @enderror">
                            @error('no_rm')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Pasien -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Nama Pasien <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_pasien" value="{{ old('nama_pasien') }}" placeholder="Nama lengkap pasien"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-green-500 focus:bg-white transition-all @error('nama_pasien') border-red-500 @enderror">
                            @error('nama_pasien')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
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
                    <p class="text-sm text-slate-500 mb-4">Centang jika terjadi insiden khusus berikut:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Kesalahan Pemberian Label -->
                        <label class="flex items-center p-4 bg-slate-50 rounded-xl cursor-pointer hover:bg-orange-50 transition-colors group border-2 border-transparent hover:border-orange-300">
                            <input type="checkbox" name="kesalahan_label" value="1"
                                   {{ old('kesalahan_label') ? 'checked' : '' }}
                                   class="w-5 h-5 rounded border-slate-300 text-orange-500 focus:ring-orange-500">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900">Kesalahan Pemberian Label</span>
                                <p class="text-xs text-slate-500">Terjadi kesalahan dalam pemberian label pasien</p>
                            </div>
                        </label>

                        <!-- Insiden Reaksi Obat Kontras -->
                        <label class="flex items-center p-4 bg-slate-50 rounded-xl cursor-pointer hover:bg-orange-50 transition-colors group border-2 border-transparent hover:border-orange-300">
                            <input type="checkbox" name="insiden_reaksi_obat_kontras" value="1"
                                   {{ old('insiden_reaksi_obat_kontras') ? 'checked' : '' }}
                                   class="w-5 h-5 rounded border-slate-300 text-orange-500 focus:ring-orange-500">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900">Insiden Reaksi Obat Kontras</span>
                                <p class="text-xs text-slate-500">Terjadi reaksi terhadap obat kontras</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Keterangan -->
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
                    <textarea name="keterangan" rows="4" placeholder="Tambahkan keterangan tambahan jika diperlukan..."
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-purple-500 focus:bg-white transition-all resize-none @error('keterangan') border-red-500 @enderror">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">
                <!-- Info Card -->
                <div class="bg-gradient-to-br from-teal-600 to-teal-700 rounded-2xl p-6 text-white">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-info-circle text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Laporan Repeat</h3>
                    <p class="text-blue-100 text-sm">Laporan ini digunakan untuk mencatat pemeriksaan radiologi yang perlu diulang karena berbagai faktor penyebab.</p>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-sm font-semibold text-slate-700 mb-4">Aksi</h3>
                    <div class="space-y-3">
                        <button type="submit" class="w-full py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                            <i class="fas fa-save mr-2"></i> Simpan Laporan
                        </button>
                        <a href="{{ route('laporan.repeat.index') }}" class="w-full py-3 bg-slate-100 text-slate-700 font-semibold rounded-xl hover:bg-slate-200 transition-colors flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
