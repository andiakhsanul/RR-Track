@extends('layouts.app')

@section('title', 'Export Laporan Excel')
@section('page-title', 'Export Laporan Excel')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex items-center space-x-2 text-sm text-slate-500 mb-4">
                <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-slate-800 font-medium">Export Laporan</span>
            </nav>
            <h1 class="text-2xl font-display font-bold text-slate-800">Export Laporan Repeat Reject</h1>
            <p class="text-slate-500 mt-1">Download laporan dalam format Excel</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-file-excel mr-3"></i>
                    Pilih Periode Laporan
                </h2>
            </div>
            <div class="p-6">
                <form action="{{ route('laporan.export') }}" method="POST">
                    @csrf

                    <!-- Bulan dan Tahun -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="bulan" class="block text-sm font-medium text-slate-700 mb-2">
                                <i class="fas fa-calendar-alt mr-1 text-slate-400"></i>
                                Bulan <span class="text-red-500">*</span>
                            </label>
                            <select name="bulan" id="bulan" required
                                class="w-full rounded-xl border-slate-200 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-shadow">
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
                            @error('bulan')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tahun" class="block text-sm font-medium text-slate-700 mb-2">
                                <i class="fas fa-calendar mr-1 text-slate-400"></i>
                                Tahun <span class="text-red-500">*</span>
                            </label>
                            <select name="tahun" id="tahun" required
                                class="w-full rounded-xl border-slate-200 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-shadow">
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
                            @error('tahun')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Pilih Modalitas -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 mb-3">
                            <i class="fas fa-x-ray mr-1 text-slate-400"></i>
                            Jenis Pemeriksaan <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <!-- Semua -->
                            <label class="relative cursor-pointer">
                                <input type="radio" name="modalitas" value="all" {{ old('modalitas', 'all') == 'all' ? 'checked' : '' }} class="sr-only peer">
                                <div class="p-4 rounded-xl border-2 border-slate-200 transition-all
                                            peer-checked:border-emerald-500 peer-checked:bg-emerald-50
                                            hover:border-emerald-300 hover:bg-emerald-50/50 text-center">
                                    <i class="fas fa-layer-group text-2xl mb-2 text-slate-400 peer-checked:text-emerald-500"></i>
                                    <p class="font-semibold text-slate-700">Semua</p>
                                    <p class="text-xs text-slate-500">CT Scan & X-Ray</p>
                                </div>
                            </label>

                            <!-- CT Scan -->
                            <label class="relative cursor-pointer">
                                <input type="radio" name="modalitas" value="ct_scan" {{ old('modalitas') == 'ct_scan' ? 'checked' : '' }} class="sr-only peer">
                                <div class="p-4 rounded-xl border-2 border-slate-200 transition-all
                                            peer-checked:border-blue-500 peer-checked:bg-blue-50
                                            hover:border-blue-300 hover:bg-blue-50/50 text-center">
                                    <i class="fas fa-circle-notch text-2xl mb-2 text-slate-400 peer-checked:text-blue-500"></i>
                                    <p class="font-semibold text-slate-700">CT Scan</p>
                                    <p class="text-xs text-slate-500">Hanya CT Scan</p>
                                </div>
                            </label>

                            <!-- X-Ray -->
                            <label class="relative cursor-pointer">
                                <input type="radio" name="modalitas" value="x_ray" {{ old('modalitas') == 'x_ray' ? 'checked' : '' }} class="sr-only peer">
                                <div class="p-4 rounded-xl border-2 border-slate-200 transition-all
                                            peer-checked:border-purple-500 peer-checked:bg-purple-50
                                            hover:border-purple-300 hover:bg-purple-50/50 text-center">
                                    <i class="fas fa-radiation text-2xl mb-2 text-slate-400 peer-checked:text-purple-500"></i>
                                    <p class="font-semibold text-slate-700">X-Ray</p>
                                    <p class="text-xs text-slate-500">Hanya X-Ray</p>
                                </div>
                            </label>
                        </div>
                        @error('modalitas')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rentang Tanggal (Opsional) -->
                    <div class="mb-6">
                        <div class="flex items-center mb-4">
                            <div class="border-t border-slate-200 flex-grow"></div>
                            <span class="px-4 text-sm text-slate-500">Rentang Tanggal (Opsional)</span>
                            <div class="border-t border-slate-200 flex-grow"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tanggal_awal" class="block text-sm font-medium text-slate-700 mb-2">
                                    <i class="fas fa-calendar-day mr-1 text-slate-400"></i>
                                    Tanggal Awal
                                </label>
                                <input type="date" name="tanggal_awal" id="tanggal_awal"
                                    value="{{ old('tanggal_awal') }}"
                                    class="w-full rounded-xl border-slate-200 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-shadow">
                                @error('tanggal_awal')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tanggal_akhir" class="block text-sm font-medium text-slate-700 mb-2">
                                    <i class="fas fa-calendar-day mr-1 text-slate-400"></i>
                                    Tanggal Akhir
                                </label>
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                                    value="{{ old('tanggal_akhir') }}"
                                    class="w-full rounded-xl border-slate-200 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-shadow">
                                @error('tanggal_akhir')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-slate-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Kosongkan jika ingin mengambil seluruh data pada bulan yang dipilih
                        </p>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3"></i>
                            <div class="text-sm text-blue-700">
                                <p class="font-medium mb-1">Informasi Export</p>
                                <ul class="list-disc list-inside space-y-1 text-blue-600">
                                    <li>File Excel akan berisi data Repeat dan Reject</li>
                                    <li>Termasuk kolom Human Error, Tools Error, Patient Error, dan Administratif</li>
                                    <li>Dilengkapi dengan tanda tangan pejabat</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center px-5 py-2.5 bg-slate-100 text-slate-700 font-medium rounded-xl hover:bg-slate-200 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:from-emerald-600 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all shadow-lg shadow-emerald-500/30">
                            <i class="fas fa-download mr-2"></i>
                            Download Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preview Info -->
        <div class="mt-6 bg-slate-50 rounded-xl p-4 border border-slate-200">
            <h3 class="font-semibold text-slate-700 mb-3 flex items-center">
                <i class="fas fa-eye mr-2 text-slate-500"></i>
                Preview Kolom Excel
            </h3>
            <div class="overflow-x-auto">
                <div class="flex flex-wrap gap-2 text-xs">
                    <span class="px-2 py-1 bg-white rounded border border-slate-200 text-slate-600">NO</span>
                    <span class="px-2 py-1 bg-white rounded border border-slate-200 text-slate-600">Tanggal</span>
                    <span class="px-2 py-1 bg-white rounded border border-slate-200 text-slate-600">Nama Pasien</span>
                    <span class="px-2 py-1 bg-white rounded border border-slate-200 text-slate-600">No.MR</span>
                    <span class="px-2 py-1 bg-white rounded border border-slate-200 text-slate-600">Pemeriksaan</span>
                    <span class="px-2 py-1 bg-amber-100 rounded border border-amber-200 text-amber-700">Human Error</span>
                    <span class="px-2 py-1 bg-amber-100 rounded border border-amber-200 text-amber-700">Tools Error</span>
                    <span class="px-2 py-1 bg-amber-100 rounded border border-amber-200 text-amber-700">Patient Error</span>
                    <span class="px-2 py-1 bg-amber-100 rounded border border-amber-200 text-amber-700">Administratif</span>
                    <span class="px-2 py-1 bg-teal-100 rounded border border-teal-200 text-teal-700">Repeat Film</span>
                    <span class="px-2 py-1 bg-rose-100 rounded border border-rose-200 text-rose-700">Kesalahan Label</span>
                    <span class="px-2 py-1 bg-rose-100 rounded border border-rose-200 text-rose-700">Insiden Reaksi Obat</span>
                    <span class="px-2 py-1 bg-white rounded border border-slate-200 text-slate-600">Nama Petugas</span>
                </div>
            </div>
        </div>
    </div>
@endsection
