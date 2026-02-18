@extends('layouts.app')

@section('title', 'Tambah Laporan')
@section('page-title', 'Tambah Laporan')

@section('content')
    <div x-data="{
                jenisLaporan: '{{ old('jenis_laporan', request('jenis', 'repeat')) }}',
                get isReject() { return this.jenisLaporan === 'reject' }
            }">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex items-center space-x-2 text-sm text-slate-500 mb-4">
                <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-slate-800 font-medium">Tambah Laporan</span>
            </nav>
            <h1 class="text-2xl font-display font-bold text-slate-800">Tambah Laporan Baru</h1>
            <p class="text-slate-500 mt-1">Isi formulir di bawah untuk membuat laporan kejadian</p>
        </div>

        <!-- Form Card -->
        <form action="{{ route('laporan.store') }}" method="POST" id="form-laporan">
            @csrf

            <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
                <!-- Main Form Column -->
                <div class="xl:col-span-3 space-y-6">

                    <!-- Jenis Laporan Section -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                            <h2 class="text-lg font-semibold text-white flex items-center">
                                <i class="fas fa-clipboard-list mr-3"></i>
                                Jenis Laporan
                            </h2>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-500 mb-4">Pilih jenis laporan yang akan dibuat:</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Repeat Option -->
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="jenis_laporan" value="repeat" x-model="jenisLaporan"
                                        class="sr-only peer">
                                    <div class="p-5 rounded-xl border-2 border-slate-200 transition-all
                                                        peer-checked:border-teal-500 peer-checked:bg-teal-50
                                                        hover:border-teal-300 hover:bg-teal-50/50">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4 transition-colors"
                                                :class="jenisLaporan === 'repeat' ? 'bg-teal-500' : 'bg-slate-200'">
                                                <i class="fas fa-redo text-xl"
                                                    :class="jenisLaporan === 'repeat' ? 'text-white' : 'text-slate-500'"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-slate-800">Laporan Repeat Film / Pemeriksaan
                                                    Ulang</h3>
                                                <p class="text-sm text-slate-500">Pemeriksaan yang perlu diulang</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <!-- Reject Option -->
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="jenis_laporan" value="reject" x-model="jenisLaporan"
                                        class="sr-only peer">
                                    <div class="p-5 rounded-xl border-2 border-slate-200 transition-all
                                                        peer-checked:border-red-500 peer-checked:bg-red-50
                                                        hover:border-red-300 hover:bg-red-50/50">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4 transition-colors"
                                                :class="jenisLaporan === 'reject' ? 'bg-red-500' : 'bg-slate-200'">
                                                <i class="fas fa-times-circle text-xl"
                                                    :class="jenisLaporan === 'reject' ? 'text-white' : 'text-slate-500'"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-slate-800">Laporan Reject</h3>
                                                <p class="text-sm text-slate-500">Pemeriksaan yang ditolak</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('jenis_laporan')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Data Laporan Section -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 transition-colors"
                            :class="isReject ? 'bg-gradient-to-r from-red-500 to-red-600' : 'bg-gradient-to-r from-teal-500 to-teal-600'">
                            <h2 class="text-lg font-semibold text-white flex items-center">
                                <i class="fas fa-file-medical mr-3"></i>
                                Data Laporan
                            </h2>
                        </div>
                        <div class="p-6 space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Tanggal Pemeriksaan -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-slate-700">
                                        Tanggal Pemeriksaan <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-calendar text-slate-400"></i>
                                        </div>
                                        <input type="date" name="tanggal_pemeriksaan"
                                            value="{{ old('tanggal_pemeriksaan', now()->format('Y-m-d')) }}"
                                            class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-primary-500 focus:bg-white transition-all @error('tanggal_pemeriksaan') border-red-500 @enderror">
                                    </div>
                                    @error('tanggal_pemeriksaan')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
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
                                            class="w-full pl-12 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-primary-500 focus:bg-white transition-all appearance-none @error('id_modalitas') border-red-500 @enderror">
                                            <option value="">Pilih Modalitas</option>
                                            @foreach($modalitas as $m)
                                                <option value="{{ $m->id_modalitas }}" {{ old('id_modalitas') == $m->id_modalitas ? 'selected' : '' }}>{{ $m->nama_modalitas }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-slate-400 text-sm"></i>
                                        </div>
                                    </div>
                                    @error('id_modalitas')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
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
                                            class="w-full pl-12 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-primary-500 focus:bg-white transition-all appearance-none @error('id_jenis_pemeriksaan') border-red-500 @enderror">
                                            <option value="">Pilih Jenis Pemeriksaan</option>
                                            @foreach($jenisPemeriksaan as $jp)
                                                <option value="{{ $jp->id_jenis_pemeriksaan }}" {{ old('id_jenis_pemeriksaan') == $jp->id_jenis_pemeriksaan ? 'selected' : '' }}>
                                                    {{ $jp->nama_jenis_pemeriksaan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-slate-400 text-sm"></i>
                                        </div>
                                    </div>
                                    @error('id_jenis_pemeriksaan')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
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
                                            class="w-full pl-12 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-primary-500 focus:bg-white transition-all appearance-none @error('id_petugas') border-red-500 @enderror">
                                            <option value="">Pilih Petugas</option>
                                            @foreach($petugas as $p)
                                                <option value="{{ $p->id_petugas }}" {{ old('id_petugas') == $p->id_petugas ? 'selected' : '' }}>{{ $p->inisial }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-slate-400 text-sm"></i>
                                        </div>
                                    </div>
                                    @error('id_petugas')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Pasien Section -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
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
                                        <input type="text" name="no_rm" value="{{ old('no_rm') }}"
                                            placeholder="Masukkan No. RM"
                                            class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-green-500 focus:bg-white transition-all @error('no_rm') border-red-500 @enderror">
                                    </div>
                                    @error('no_rm')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
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
                                        <input type="text" name="nama_pasien" value="{{ old('nama_pasien') }}"
                                            placeholder="Masukkan nama pasien"
                                            class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-green-500 focus:bg-white transition-all @error('nama_pasien') border-red-500 @enderror">
                                    </div>
                                    @error('nama_pasien')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Faktor Penyebab Section (Only for Reject) -->
                    <div x-show="isReject" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                            <h2 class="text-lg font-semibold text-white flex items-center">
                                <i class="fas fa-exclamation-triangle mr-3"></i>
                                Faktor Penyebab Reject
                            </h2>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-500 mb-4">Pilih satu atau lebih faktor penyebab reject:</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($faktorPenyebab as $faktor)
                                    <label
                                        class="relative flex items-start p-4 bg-slate-50 rounded-xl border-2 border-transparent hover:border-orange-300 hover:bg-orange-50 cursor-pointer transition-all group">
                                        <input type="checkbox" name="faktor[]" value="{{ $faktor->id_faktor }}"
                                            class="h-5 w-5 rounded border-slate-300 text-orange-600 focus:ring-orange-500 mt-0.5"
                                            {{ in_array($faktor->id_faktor, old('faktor', [])) ? 'checked' : '' }}>
                                        <span
                                            class="ml-3 text-sm text-slate-700 group-hover:text-slate-900">{{ $faktor->nama_faktor }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('faktor')
                                <p class="text-red-500 text-sm mt-3">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Insiden Khusus Section -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-500 to-amber-500 px-6 py-4">
                            <h2 class="text-lg font-semibold text-white flex items-center">
                                <i class="fas fa-exclamation-circle mr-3"></i>
                                Insiden Khusus
                            </h2>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-500 mb-4">Centang jika terjadi insiden khusus berikut:</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Kesalahan Pemberian Label -->
                                <label
                                    class="relative flex items-start p-4 bg-slate-50 rounded-xl border-2 border-transparent hover:border-yellow-300 hover:bg-yellow-50 cursor-pointer transition-all group">
                                    <input type="checkbox" name="kesalahan_label" value="1"
                                        class="h-5 w-5 rounded border-slate-300 text-yellow-600 focus:ring-yellow-500 mt-0.5"
                                        {{ old('kesalahan_label') ? 'checked' : '' }}>
                                    <div class="ml-3">
                                        <span
                                            class="text-sm font-medium text-slate-700 group-hover:text-slate-900">Kesalahan
                                            Pemberian Label</span>
                                        <p class="text-xs text-slate-500 mt-1">Terjadi kesalahan dalam pemberian label
                                            pasien</p>
                                    </div>
                                </label>

                                <!-- Insiden Reaksi Obat Kontras -->
                                <label
                                    class="relative flex items-start p-4 bg-slate-50 rounded-xl border-2 border-transparent hover:border-yellow-300 hover:bg-yellow-50 cursor-pointer transition-all group">
                                    <input type="checkbox" name="insiden_reaksi_obat_kontras" value="1"
                                        class="h-5 w-5 rounded border-slate-300 text-yellow-600 focus:ring-yellow-500 mt-0.5"
                                        {{ old('insiden_reaksi_obat_kontras') ? 'checked' : '' }}>
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900">Insiden
                                            Reaksi Obat Kontras</span>
                                        <p class="text-xs text-slate-500 mt-1">Terjadi reaksi terhadap obat kontras</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan Section -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                            <h2 class="text-lg font-semibold text-white flex items-center">
                                <i class="fas fa-comment-alt mr-3"></i>
                                Keterangan Tambahan
                            </h2>
                        </div>
                        <div class="p-6">
                            <textarea name="keterangan" rows="4" placeholder="Tambahkan keterangan atau catatan tambahan..."
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-purple-500 focus:bg-white transition-all resize-none @error('keterangan') border-red-500 @enderror">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons (Mobile) -->
                    <div class="xl:hidden flex flex-wrap gap-3">
                        <a href="{{ route('dashboard') }}"
                            class="flex-1 py-3 px-6 bg-slate-100 text-slate-700 font-semibold rounded-xl text-center hover:bg-slate-200 transition-all">
                            <i class="fas fa-home mr-2"></i> Dashboard
                        </a>
                        <button type="submit"
                            class="flex-1 py-3 px-6 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all"
                            :class="isReject ? 'bg-gradient-to-r from-red-500 to-red-600' : 'bg-gradient-to-r from-teal-500 to-teal-600'">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                    </div>
                </div>

                <!-- Sidebar Column -->
                <div class="xl:col-span-1">
                    <div class="sticky top-8 space-y-6">
                        <!-- Info Card -->
                        <div class="rounded-2xl p-6 text-white shadow-lg transition-colors"
                            :class="isReject ? 'bg-gradient-to-br from-red-500 to-red-600' : 'bg-gradient-to-br from-teal-500 to-teal-600'">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center mr-4">
                                    <i class="text-2xl" :class="isReject ? 'fas fa-times-circle' : 'fas fa-redo'"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg"
                                        x-text="isReject ? 'Laporan Reject' : 'Laporan Repeat'"></h3>
                                    <p class="text-white/80 text-sm"
                                        x-text="isReject ? 'Pemeriksaan Ditolak' : 'Pemeriksaan Ulang'"></p>
                                </div>
                            </div>
                            <p class="text-sm text-white/90 leading-relaxed"
                                x-text="isReject ? 'Reject adalah pemeriksaan radiologi yang tidak dapat digunakan karena kualitas gambar tidak memenuhi standar diagnostik.' : 'Repeat adalah pemeriksaan radiologi yang perlu dilakukan ulang karena berbagai faktor.'">
                            </p>
                        </div>

                        <!-- Tips Card -->
                        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                            <h3 class="font-semibold text-slate-800 mb-4 flex items-center">
                                <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                                Tips Pengisian
                            </h3>
                            <ul class="space-y-3 text-sm text-slate-600">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                    <span>Pastikan No. RM sudah benar</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                    <span>Pilih modalitas yang sesuai</span>
                                </li>
                                <li class="flex items-start" x-show="isReject">
                                    <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                    <span>Pilih faktor penyebab yang sesuai</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                    <span>Tambahkan keterangan detail</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Action Buttons (Desktop) -->
                        <div class="hidden xl:block space-y-3">
                            <button type="submit" form="form-laporan"
                                class="w-full py-3 px-6 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all"
                                :class="isReject ? 'bg-gradient-to-r from-red-500 to-red-600' : 'bg-gradient-to-r from-teal-500 to-teal-600'">
                                <i class="fas fa-save mr-2"></i> Simpan Laporan
                            </button>
                            <a href="{{ route('dashboard') }}"
                                class="w-full py-3 px-6 bg-slate-100 text-slate-700 font-semibold rounded-xl text-center hover:bg-slate-200 transition-all block">
                                <i class="fas fa-home mr-2"></i> Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection