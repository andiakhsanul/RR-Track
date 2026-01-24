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

        // Data untuk Chart Bulanan (6 bulan terakhir)
        $chartBulanan = $this->getMonthlyData();

        // Data untuk Pie Chart - Perbandingan Repeat vs Reject
        $pieChartData = [
            'labels' => ['Repeat', 'Reject'],
            'data' => [$totalRepeat, $totalReject],
            'colors' => ['#3B82F6', '#EF4444']
        ];

        // Data untuk Chart Modalitas
        $chartModalitas = $this->getModalitasData();

        // Data untuk Chart Faktor Penyebab (Reject only)
        $chartFaktor = $this->getFaktorData();

        return view('dashboard.index', compact(
            'totalRepeat',
            'totalReject',
            'totalLaporan',
            'laporanBulanIni',
            'recentLaporan',
            'chartBulanan',
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
            'labels' => $faktorList->pluck('nama_faktor')->toArray(),
            'data' => $faktorList->pluck('laporan_count')->toArray(),
            'colors' => array_slice($colors, 0, $faktorList->count())
        ];
    }
}
