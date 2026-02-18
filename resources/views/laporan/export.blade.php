@extends('layouts.app')

@section('title', 'Export Laporan Excel')
@section('page-title', 'Export Laporan Excel')

@section('content')
    <div class="max-w-2xl mx-auto pb-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-sm text-slate-500 mb-6">
            <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition-colors flex items-center">
                <i class="fas fa-home mr-1"></i> Dashboard
            </a>
            <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
            <span class="text-slate-800 font-semibold">Export Laporan</span>
        </nav>

        {{-- Page Header --}}
        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <i class="fas fa-file-excel text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-display font-bold text-slate-800">Export Laporan</h1>
                    <p class="text-sm text-slate-500">Download data Repeat & Reject dalam format Excel</p>
                </div>
            </div>
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center px-5 py-3 bg-slate-100 text-slate-700 font-semibold rounded-xl hover:bg-slate-200 transition-all">
                <i class="fas fa-home mr-2"></i> Dashboard
            </a>
        </div>

        {{-- Main Form Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            {{-- Card Header --}}
            <div class="bg-gradient-to-r from-emerald-500 via-emerald-500 to-teal-600 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-sliders-h mr-3 text-emerald-100"></i>
                            Konfigurasi Export
                        </h2>
                        <p class="text-emerald-100 text-sm mt-0.5">Atur periode dan jenis pemeriksaan</p>
                    </div>
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-file-download text-2xl text-white/80"></i>
                    </div>
                </div>
            </div>

            <form action="{{ route('laporan.export') }}" method="POST">
                @csrf

                <div class="p-6 space-y-6">

                    {{-- Section 1: Periode --}}
                    <div>
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">1</span>
                            <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Periode & Jenis Pemeriksaan</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- Bulan --}}
                            <div>
                                <label for="bulan" class="block text-sm font-medium text-slate-600 mb-1.5">
                                    Bulan <span class="text-red-400">*</span>
                                </label>
                                <div class="relative">
                                    <select name="bulan" id="bulan" required
                                        class="w-full rounded-xl border-slate-200 bg-slate-50/50 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 focus:bg-white transition-all text-sm pl-9">
                                        <option value="">Pilih Bulan</option>
                                        @php
                                            $namaBulan = [
                                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                            ];
                                            $currentMonth = date('n');
                                        @endphp
                                        @foreach ($namaBulan as $num => $nama)
                                            <option value="{{ $num }}" {{ old('bulan', $currentMonth) == $num ? 'selected' : '' }}>
                                                {{ $nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-calendar-alt text-slate-400 text-xs"></i>
                                    </div>
                                </div>
                                @error('bulan')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tahun --}}
                            <div>
                                <label for="tahun" class="block text-sm font-medium text-slate-600 mb-1.5">
                                    Tahun <span class="text-red-400">*</span>
                                </label>
                                <div class="relative">
                                    <select name="tahun" id="tahun" required
                                        class="w-full rounded-xl border-slate-200 bg-slate-50/50 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 focus:bg-white transition-all text-sm pl-9">
                                        <option value="">Pilih Tahun</option>
                                        @php
                                            $currentYear = date('Y');
                                        @endphp
                                        @for ($year = $currentYear; $year >= 2020; $year--)
                                            <option value="{{ $year }}" {{ old('tahun', $currentYear) == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-calendar text-slate-400 text-xs"></i>
                                    </div>
                                </div>
                                @error('tahun')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Jenis Pemeriksaan --}}
                            <div>
                                <label for="modalitas" class="block text-sm font-medium text-slate-600 mb-1.5">
                                    Jenis Pemeriksaan <span class="text-red-400">*</span>
                                </label>
                                <div class="relative">
                                    <select name="modalitas" id="modalitas" required
                                        class="w-full rounded-xl border-slate-200 bg-slate-50/50 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 focus:bg-white transition-all text-sm pl-9">
                                        <option value="all" {{ old('modalitas', 'all') == 'all' ? 'selected' : '' }}>Semua (CT Scan & X-Ray)</option>
                                        <option value="ct_scan" {{ old('modalitas') == 'ct_scan' ? 'selected' : '' }}>CT Scan</option>
                                        <option value="x_ray" {{ old('modalitas') == 'x_ray' ? 'selected' : '' }}>X-Ray</option>
                                    </select>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-x-ray text-slate-400 text-xs"></i>
                                    </div>
                                </div>
                                @error('modalitas')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-dashed border-slate-200"></div>

                    {{-- Section 2: Rentang Tanggal --}}
                    <div>
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-slate-500 text-xs font-bold">2</span>
                            <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Rentang Tanggal</h3>
                            <span class="text-xs text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full font-medium">Opsional</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="tanggal_awal" class="block text-sm font-medium text-slate-600 mb-1.5">
                                    Tanggal Awal
                                </label>
                                <div class="relative">
                                    <input type="date" name="tanggal_awal" id="tanggal_awal"
                                        value="{{ old('tanggal_awal') }}"
                                        class="w-full rounded-xl border-slate-200 bg-slate-50/50 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 focus:bg-white transition-all text-sm pl-9">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-calendar-day text-slate-400 text-xs"></i>
                                    </div>
                                </div>
                                @error('tanggal_awal')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

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
                                @error('tanggal_akhir')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-slate-400 flex items-center">
                            <i class="fas fa-info-circle mr-1.5"></i>
                            Kosongkan jika ingin mengambil seluruh data pada bulan yang dipilih
                        </p>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-dashed border-slate-200"></div>

                    {{-- Info Box --}}
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200/60 rounded-xl p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-info text-blue-600 text-sm"></i>
                            </div>
                            <div class="text-sm">
                                <p class="font-semibold text-blue-800 mb-1.5">File Excel yang dihasilkan akan berisi:</p>
                                <ul class="space-y-1 text-blue-700">
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-blue-400 mr-2 text-xs"></i>
                                        Data Repeat dan Reject sesuai periode
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-blue-400 mr-2 text-xs"></i>
                                        Kolom Human, Tools, Patient Error & Administratif
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-blue-400 mr-2 text-xs"></i>
                                        Tanda tangan pejabat otomatis
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-white text-slate-600 font-medium rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-slate-300 transition-all text-sm">
                        <i class="fas fa-arrow-left mr-2 text-xs"></i>
                        Kembali
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:from-emerald-600 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 text-sm group">
                        <i class="fas fa-download mr-2 text-sm transition-transform group-hover:-translate-y-0.5"></i>
                        Download Excel
                    </button>
                </div>
            </form>
        </div>

        {{-- Preview Kolom --}}
        <div class="mt-5 bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm">
            <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-700 text-sm flex items-center">
                    <i class="fas fa-table-columns mr-2 text-slate-400"></i>
                    Preview Kolom Excel
                </h3>
                <span class="text-xs text-slate-400">13 kolom</span>
            </div>
            <div class="p-5">
                <div class="space-y-3">
                    {{-- Data Utama --}}
                    <div>
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Data Utama</p>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="px-2.5 py-1 bg-slate-50 rounded-lg border border-slate-200 text-xs text-slate-600 font-medium">NO</span>
                            <span class="px-2.5 py-1 bg-slate-50 rounded-lg border border-slate-200 text-xs text-slate-600 font-medium">Tanggal</span>
                            <span class="px-2.5 py-1 bg-slate-50 rounded-lg border border-slate-200 text-xs text-slate-600 font-medium">Nama Pasien</span>
                            <span class="px-2.5 py-1 bg-slate-50 rounded-lg border border-slate-200 text-xs text-slate-600 font-medium">No.MR</span>
                            <span class="px-2.5 py-1 bg-slate-50 rounded-lg border border-slate-200 text-xs text-slate-600 font-medium">Pemeriksaan</span>
                            <span class="px-2.5 py-1 bg-slate-50 rounded-lg border border-slate-200 text-xs text-slate-600 font-medium">Nama Petugas</span>
                        </div>
                    </div>
                    {{-- Faktor Error --}}
                    <div>
                        <p class="text-[10px] font-semibold text-amber-500 uppercase tracking-wider mb-1.5">Faktor Error</p>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="px-2.5 py-1 bg-amber-50 rounded-lg border border-amber-200/70 text-xs text-amber-700 font-medium">Human Error</span>
                            <span class="px-2.5 py-1 bg-amber-50 rounded-lg border border-amber-200/70 text-xs text-amber-700 font-medium">Tools Error</span>
                            <span class="px-2.5 py-1 bg-amber-50 rounded-lg border border-amber-200/70 text-xs text-amber-700 font-medium">Patient Error</span>
                            <span class="px-2.5 py-1 bg-amber-50 rounded-lg border border-amber-200/70 text-xs text-amber-700 font-medium">Administratif</span>
                        </div>
                    </div>
                    {{-- Kejadian --}}
                    <div>
                        <p class="text-[10px] font-semibold text-rose-500 uppercase tracking-wider mb-1.5">Kejadian</p>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="px-2.5 py-1 bg-teal-50 rounded-lg border border-teal-200/70 text-xs text-teal-700 font-medium">Repeat Film</span>
                            <span class="px-2.5 py-1 bg-rose-50 rounded-lg border border-rose-200/70 text-xs text-rose-700 font-medium">Kesalahan Label</span>
                            <span class="px-2.5 py-1 bg-rose-50 rounded-lg border border-rose-200/70 text-xs text-rose-700 font-medium">Insiden Reaksi Obat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection