<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Laporan;
use App\Models\JenisLaporan;
use App\Models\Modalitas;
use App\Models\FaktorPenyebab;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index(): View
    {
        $totalRepeat = Laporan::repeat()->count();
        $totalReject = Laporan::reject()->count();
        $totalLaporan = Laporan::count();

        // Laporan bulan ini
        $laporanBulanIni = Laporan::whereYear('tanggal_pemeriksaan', Carbon::now()->year)
            ->whereMonth('tanggal_pemeriksaan', Carbon::now()->month)
            ->count();

        $recentLaporan = Laporan::with(['pasien', 'petugas', 'modalitas', 'jenisPemeriksaan', 'jenisLaporan'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Data untuk Chart Bulanan (6 bulan terakhir) Global
        $chartBulanan = $this->getMonthlyData();

        // Data untuk Chart Bulanan X-Ray (reject & repeat)
        $chartBulananXRay = $this->getModalitasMonthlyData('X Ray');

        // Data untuk Chart Bulanan CT-Scan (reject & repeat)
        $chartBulananCTScan = $this->getModalitasMonthlyData('CT Scan');

        // Data untuk Chart Faktor Penyebab X-Ray (Reject only, filtered by month)
        $chartFaktorXRay = $this->getModalitasRejectFactorsData('X Ray');

        // Data untuk Chart Faktor Penyebab CT-Scan (Reject only, filtered by month)
        $chartFaktorCTScan = $this->getModalitasRejectFactorsData('CT Scan');


        // Data untuk Pie Chart - Perbandingan Repeat vs Reject
        $pieChartData = [
            'labels' => ['Repeat', 'Reject'],
            'data' => [$totalRepeat, $totalReject],
            'colors' => ['#3B82F6', '#EF4444']
        ];

        // Data untuk Chart Modalitas
        $chartModalitas = $this->getModalitasData();

        // Data untuk Chart Faktor Penyebab (Global Reject only)
        $chartFaktor = $this->getFaktorData();

        return view('dashboard.index', compact(
            'totalRepeat',
            'totalReject',
            'totalLaporan',
            'laporanBulanIni',
            'recentLaporan',
            'chartBulanan',
            'chartBulananXRay',
            'chartBulananCTScan',
            'chartFaktorXRay',
            'chartFaktorCTScan',
            'pieChartData',
            'chartModalitas',
            'chartFaktor'
        ));
    }

    /**
     * Get monthly data for bar chart (last 6 months)
     */
    private function getMonthlyData(): array
    {
        $months = [];
        $repeatData = [];
        $rejectData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->translatedFormat('M Y');
            $months[] = $monthName;

            $repeatCount = Laporan::repeat()
                ->whereYear('tanggal_pemeriksaan', $date->year)
                ->whereMonth('tanggal_pemeriksaan', $date->month)
                ->count();

            $rejectCount = Laporan::reject()
                ->whereYear('tanggal_pemeriksaan', $date->year)
                ->whereMonth('tanggal_pemeriksaan', $date->month)
                ->count();

            $repeatData[] = $repeatCount;
            $rejectData[] = $rejectCount;
        }

        return [
            'labels' => $months,
            'repeat' => $repeatData,
            'reject' => $rejectData
        ];
    }

    /**
     * Get monthly stats for specific modalitas
     */
    private function getModalitasMonthlyData(string $modalitasName): array
    {
        $months = [];
        $repeatData = [];
        $rejectData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->translatedFormat('M Y');
            $months[] = $monthName;

            $repeatCount = Laporan::repeat()
                ->whereHas('modalitas', function ($q) use ($modalitasName) {
                    $q->where('nama_modalitas', 'like', '%' . $modalitasName . '%');
                })
                ->whereYear('tanggal_pemeriksaan', $date->year)
                ->whereMonth('tanggal_pemeriksaan', $date->month)
                ->count();

            $rejectCount = Laporan::reject()
                ->whereHas('modalitas', function ($q) use ($modalitasName) {
                    $q->where('nama_modalitas', 'like', '%' . $modalitasName . '%');
                })
                ->whereYear('tanggal_pemeriksaan', $date->year)
                ->whereMonth('tanggal_pemeriksaan', $date->month)
                ->count();

            $repeatData[] = $repeatCount;
            $rejectData[] = $rejectCount;
        }

        return [
            'labels' => $months,
            'repeat' => $repeatData,
            'reject' => $rejectData
        ];
    }

    /**
     * Get reject factors for specific modalitas for current month only
     */
    private function getModalitasRejectFactorsData(string $modalitasName): array
    {
        $colors = ['#EF4444', '#F97316', '#EAB308', '#22C55E', '#3B82F6', '#8B5CF6', '#EC4899', '#6366F1'];
        $date = Carbon::now();

        // Get reject reports for current month and modalitas
        $laporans = Laporan::reject()
            ->whereHas('modalitas', function ($q) use ($modalitasName) {
                $q->where('nama_modalitas', 'like', '%' . $modalitasName . '%');
            })
            ->whereYear('tanggal_pemeriksaan', $date->year)
            ->whereMonth('tanggal_pemeriksaan', $date->month)
            ->with('faktorPenyebab')
            ->get();

        // Count factors
        $factorCounts = [];
        $factorDetails = [];
        foreach ($laporans as $laporan) {
            foreach ($laporan->faktorPenyebab as $faktor) {
                $name = $faktor->nama_utama;
                if (!isset($factorCounts[$name])) {
                    $factorCounts[$name] = 0;
                }
                $factorDetails[$name] = $faktor->detail;
                $factorCounts[$name]++;
            }
        }

        // Sort by count desc
        arsort($factorCounts);

        // Handle empty data case
        if (empty($factorCounts)) {
            return [
                'labels' => ['Tidak ada data'],
                'details' => [null],
                'data' => [0],
                'colors' => ['#e5e7eb']
            ];
        }

        $labels = array_keys($factorCounts);

        return [
            'labels' => $labels,
            'details' => array_map(fn ($label) => $factorDetails[$label] ?? null, $labels),
            'data' => array_values($factorCounts),
            'colors' => array_slice($colors, 0, count($factorCounts))
        ];
    }

    /**
     * Get modalitas distribution data
     */
    private function getModalitasData(): array
    {
        $modalitasList = Modalitas::withCount('laporan')->get();

        return [
            'labels' => $modalitasList->pluck('nama_modalitas')->toArray(),
            'data' => $modalitasList->pluck('laporan_count')->toArray()
        ];
    }

    /**
     * Get faktor penyebab distribution for reject reports
     */
    private function getFaktorData(): array
    {
        $faktorList = FaktorPenyebab::withCount('laporan')->get();

        $colors = ['#EF4444', '#F97316', '#EAB308', '#22C55E', '#3B82F6', '#8B5CF6'];

        return [
            'labels' => $faktorList->map(fn ($faktor) => $faktor->nama_utama)->toArray(),
            'details' => $faktorList->map(fn ($faktor) => $faktor->detail)->toArray(),
            'data' => $faktorList->pluck('laporan_count')->toArray(),
            'colors' => array_slice($colors, 0, $faktorList->count())
        ];
    }
}
