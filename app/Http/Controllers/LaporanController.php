<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Laporan;
use App\Models\Pasien;
use App\Models\Petugas;
use App\Models\Modalitas;
use App\Models\JenisPemeriksaan;
use App\Models\JenisLaporan;
use App\Models\FaktorPenyebab;
use App\Models\JenisInsiden;
use App\Exports\LaporanRepeatRejectExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    /**
     * Display a listing of repeat reports
     */
    public function indexRepeat(Request $request): View
    {
        $query = Laporan::with(['pasien', 'petugas', 'modalitas', 'jenisPemeriksaan', 'jenisInsiden'])
            ->repeat();

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_pemeriksaan', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_pemeriksaan', '<=', $request->tanggal_selesai);
        }

        $laporanList = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('laporan.repeat.index', compact('laporanList'));
    }

    /**
     * Display a listing of reject reports
     */
    public function indexReject(Request $request): View
    {
        $query = Laporan::with(['pasien', 'petugas', 'modalitas', 'jenisPemeriksaan', 'faktorPenyebab', 'jenisInsiden'])
            ->reject();

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_pemeriksaan', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_pemeriksaan', '<=', $request->tanggal_selesai);
        }

        $laporanList = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('laporan.reject.index', compact('laporanList'));
    }

    /**
     * Show the form for creating a new repeat report
     */
    public function createRepeat(): View
    {
        $petugas = Petugas::orderBy('inisial')->get();
        $modalitas = Modalitas::orderBy('nama_modalitas')->get();
        $jenisPemeriksaan = JenisPemeriksaan::orderBy('nama_jenis_pemeriksaan')->get();
        $jenisInsiden = JenisInsiden::orderBy('nama_insiden')->get();

        return view('laporan.repeat.create', compact(
            'petugas',
            'modalitas',
            'jenisPemeriksaan',
            'jenisInsiden'
        ));
    }

    /**
     * Show the form for creating a new reject report
     */
    public function createReject(): View
    {
        $petugas = Petugas::orderBy('inisial')->get();
        $modalitas = Modalitas::orderBy('nama_modalitas')->get();
        $jenisPemeriksaan = JenisPemeriksaan::orderBy('nama_jenis_pemeriksaan')->get();
        $faktorPenyebab = FaktorPenyebab::orderBy('nama_faktor')->get();
        $jenisInsiden = JenisInsiden::orderBy('nama_insiden')->get();

        return view('laporan.reject.create', compact(
            'petugas',
            'modalitas',
            'jenisPemeriksaan',
            'faktorPenyebab',
            'jenisInsiden'
        ));
    }

    /**
     * Show the unified form for creating a new report (Repeat or Reject)
     */
    public function create(): View
    {
        $petugas = Petugas::orderBy('inisial')->get();
        $modalitas = Modalitas::orderBy('nama_modalitas')->get();
        $jenisPemeriksaan = JenisPemeriksaan::orderBy('nama_jenis_pemeriksaan')->get();
        $faktorPenyebab = FaktorPenyebab::orderBy('nama_faktor')->get();
        $jenisInsiden = JenisInsiden::orderBy('nama_insiden')->get();

        return view('laporan.create', compact(
            'petugas',
            'modalitas',
            'jenisPemeriksaan',
            'faktorPenyebab',
            'jenisInsiden'
        ));
    }

    /**
     * Store a newly created report (unified handler for both Repeat and Reject)
     */
    public function store(Request $request): RedirectResponse
    {
        // Base validation rules
        $rules = [
            'jenis_laporan' => 'required|in:repeat,reject',
            'tanggal_pemeriksaan' => 'required|date',
            'nama_pasien' => 'required|string|max:100',
            'no_rm' => 'required|string|max:20',
            'id_jenis_pemeriksaan' => 'required|exists:jenis_pemeriksaan,id_jenis_pemeriksaan',
            'id_modalitas' => 'required|exists:modalitas,id_modalitas',
            'id_petugas' => 'required|exists:petugas,id_petugas',
            'insiden' => 'nullable|array',
            'insiden.*' => 'exists:jenis_insiden,id_insiden',
            'keterangan' => 'nullable|string',
            'kesalahan_label' => 'nullable|boolean',
            'insiden_reaksi_obat_kontras' => 'nullable|boolean',
        ];

        // Add faktor validation for reject type
        if ($request->input('jenis_laporan') === 'reject') {
            $rules['faktor'] = 'required|array|min:1';
            $rules['faktor.*'] = 'exists:faktor_penyebab,id_faktor';
        }

        $validated = $request->validate($rules);

        // Determine jenis laporan ID
        $isReject = $validated['jenis_laporan'] === 'reject';
        $jenisLaporanId = $isReject ? JenisLaporan::TOLAK : JenisLaporan::ULANG;

        // Find or create pasien
        $pasien = Pasien::firstOrCreate(
            ['no_rm' => $validated['no_rm']],
            ['nama_pasien' => $validated['nama_pasien']]
        );

        // Update nama pasien if different
        if ($pasien->nama_pasien !== $validated['nama_pasien']) {
            $pasien->update(['nama_pasien' => $validated['nama_pasien']]);
        }

        // Create laporan
        $laporan = Laporan::create([
            'id_jenis_laporan' => $jenisLaporanId,
            'tanggal_pemeriksaan' => $validated['tanggal_pemeriksaan'],
            'id_pasien' => $pasien->id_pasien,
            'id_jenis_pemeriksaan' => $validated['id_jenis_pemeriksaan'],
            'id_modalitas' => $validated['id_modalitas'],
            'id_petugas' => $validated['id_petugas'],
            'keterangan' => $validated['keterangan'] ?? null,
            'kesalahan_label' => $request->boolean('kesalahan_label'),
            'insiden_reaksi_obat_kontras' => $request->boolean('insiden_reaksi_obat_kontras'),
        ]);

        // Attach faktor penyebab for reject type
        if ($isReject && !empty($validated['faktor'])) {
            $laporan->faktorPenyebab()->attach($validated['faktor']);
        }

        // Attach insiden
        if (!empty($validated['insiden'])) {
            $laporan->jenisInsiden()->attach($validated['insiden']);
        }

        // Redirect based on type
        $route = $isReject ? 'laporan.reject.index' : 'laporan.repeat.index';
        $message = $isReject ? 'Laporan Reject berhasil ditambahkan!' : 'Laporan Repeat berhasil ditambahkan!';

        return redirect()->route($route)->with('success', $message);
    }

    /**
     * Store a newly created repeat report
     */
    public function storeRepeat(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'nama_pasien' => 'required|string|max:100',
            'no_rm' => 'required|string|max:20',
            'id_jenis_pemeriksaan' => 'required|exists:jenis_pemeriksaan,id_jenis_pemeriksaan',
            'id_modalitas' => 'required|exists:modalitas,id_modalitas',
            'id_petugas' => 'required|exists:petugas,id_petugas',
            'insiden' => 'nullable|array',
            'insiden.*' => 'exists:jenis_insiden,id_insiden',
            'keterangan' => 'nullable|string',
            'kesalahan_label' => 'nullable|boolean',
            'insiden_reaksi_obat_kontras' => 'nullable|boolean',
        ]);

        // Find or create pasien
        $pasien = Pasien::firstOrCreate(
            ['no_rm' => $validated['no_rm']],
            ['nama_pasien' => $validated['nama_pasien']]
        );

        // Update nama pasien if different
        if ($pasien->nama_pasien !== $validated['nama_pasien']) {
            $pasien->update(['nama_pasien' => $validated['nama_pasien']]);
        }

        // Create laporan
        $laporan = Laporan::create([
            'id_jenis_laporan' => JenisLaporan::ULANG,
            'tanggal_pemeriksaan' => $validated['tanggal_pemeriksaan'],
            'id_pasien' => $pasien->id_pasien,
            'id_jenis_pemeriksaan' => $validated['id_jenis_pemeriksaan'],
            'id_modalitas' => $validated['id_modalitas'],
            'id_petugas' => $validated['id_petugas'],
            'keterangan' => $validated['keterangan'],
            'kesalahan_label' => $request->boolean('kesalahan_label'),
            'insiden_reaksi_obat_kontras' => $request->boolean('insiden_reaksi_obat_kontras'),
        ]);

        // Attach insiden
        if (!empty($validated['insiden'])) {
            $laporan->jenisInsiden()->attach($validated['insiden']);
        }

        return redirect()->route('laporan.repeat.index')
            ->with('success', 'Laporan Repeat berhasil ditambahkan!');
    }

    /**
     * Store a newly created reject report
     */
    public function storeReject(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'nama_pasien' => 'required|string|max:100',
            'no_rm' => 'required|string|max:20',
            'id_jenis_pemeriksaan' => 'required|exists:jenis_pemeriksaan,id_jenis_pemeriksaan',
            'id_modalitas' => 'required|exists:modalitas,id_modalitas',
            'id_petugas' => 'required|exists:petugas,id_petugas',
            'faktor' => 'required|array|min:1',
            'faktor.*' => 'exists:faktor_penyebab,id_faktor',
            'insiden' => 'nullable|array',
            'insiden.*' => 'exists:jenis_insiden,id_insiden',
            'keterangan' => 'nullable|string',
            'kesalahan_label' => 'nullable|boolean',
            'insiden_reaksi_obat_kontras' => 'nullable|boolean',
        ]);

        // Find or create pasien
        $pasien = Pasien::firstOrCreate(
            ['no_rm' => $validated['no_rm']],
            ['nama_pasien' => $validated['nama_pasien']]
        );

        // Update nama pasien if different
        if ($pasien->nama_pasien !== $validated['nama_pasien']) {
            $pasien->update(['nama_pasien' => $validated['nama_pasien']]);
        }

        // Create laporan
        $laporan = Laporan::create([
            'id_jenis_laporan' => JenisLaporan::TOLAK,
            'tanggal_pemeriksaan' => $validated['tanggal_pemeriksaan'],
            'id_pasien' => $pasien->id_pasien,
            'id_jenis_pemeriksaan' => $validated['id_jenis_pemeriksaan'],
            'id_modalitas' => $validated['id_modalitas'],
            'id_petugas' => $validated['id_petugas'],
            'keterangan' => $validated['keterangan'],
            'kesalahan_label' => $request->boolean('kesalahan_label'),
            'insiden_reaksi_obat_kontras' => $request->boolean('insiden_reaksi_obat_kontras'),
        ]);

        // Attach faktor penyebab
        $laporan->faktorPenyebab()->attach($validated['faktor']);

        // Attach insiden
        if (!empty($validated['insiden'])) {
            $laporan->jenisInsiden()->attach($validated['insiden']);
        }

        return redirect()->route('laporan.reject.index')
            ->with('success', 'Laporan Reject berhasil ditambahkan!');
    }

    /**
     * Display the specified repeat report
     */
    public function showRepeat(Laporan $laporan): View
    {
        $laporan->load(['pasien', 'petugas', 'modalitas', 'jenisPemeriksaan', 'jenisInsiden']);

        return view('laporan.repeat.show', compact('laporan'));
    }

    /**
     * Display the specified reject report
     */
    public function showReject(Laporan $laporan): View
    {
        $laporan->load(['pasien', 'petugas', 'modalitas', 'jenisPemeriksaan', 'faktorPenyebab', 'jenisInsiden']);

        return view('laporan.reject.show', compact('laporan'));
    }

    /**
     * Show the form for editing the repeat report
     */
    public function editRepeat(Laporan $laporan): View
    {
        $laporan->load(['pasien', 'jenisInsiden']);
        $petugas = Petugas::orderBy('inisial')->get();
        $modalitas = Modalitas::orderBy('nama_modalitas')->get();
        $jenisPemeriksaan = JenisPemeriksaan::orderBy('nama_jenis_pemeriksaan')->get();
        $jenisInsiden = JenisInsiden::orderBy('nama_insiden')->get();

        return view('laporan.repeat.edit', compact(
            'laporan',
            'petugas',
            'modalitas',
            'jenisPemeriksaan',
            'jenisInsiden'
        ));
    }

    /**
     * Show the form for editing the reject report
     */
    public function editReject(Laporan $laporan): View
    {
        $laporan->load(['pasien', 'faktorPenyebab', 'jenisInsiden']);
        $petugas = Petugas::orderBy('inisial')->get();
        $modalitas = Modalitas::orderBy('nama_modalitas')->get();
        $jenisPemeriksaan = JenisPemeriksaan::orderBy('nama_jenis_pemeriksaan')->get();
        $faktorPenyebab = FaktorPenyebab::orderBy('nama_faktor')->get();
        $jenisInsiden = JenisInsiden::orderBy('nama_insiden')->get();

        return view('laporan.reject.edit', compact(
            'laporan',
            'petugas',
            'modalitas',
            'jenisPemeriksaan',
            'faktorPenyebab',
            'jenisInsiden'
        ));
    }

    /**
     * Update the repeat report
     */
    public function updateRepeat(Request $request, Laporan $laporan): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'nama_pasien' => 'required|string|max:100',
            'no_rm' => 'required|string|max:20',
            'id_jenis_pemeriksaan' => 'required|exists:jenis_pemeriksaan,id_jenis_pemeriksaan',
            'id_modalitas' => 'required|exists:modalitas,id_modalitas',
            'id_petugas' => 'required|exists:petugas,id_petugas',
            'insiden' => 'nullable|array',
            'insiden.*' => 'exists:jenis_insiden,id_insiden',
            'keterangan' => 'nullable|string',
            'kesalahan_label' => 'nullable|boolean',
            'insiden_reaksi_obat_kontras' => 'nullable|boolean',
        ]);

        // Find or create pasien
        $pasien = Pasien::firstOrCreate(
            ['no_rm' => $validated['no_rm']],
            ['nama_pasien' => $validated['nama_pasien']]
        );

        // Update nama pasien if different
        if ($pasien->nama_pasien !== $validated['nama_pasien']) {
            $pasien->update(['nama_pasien' => $validated['nama_pasien']]);
        }

        // Update laporan
        $laporan->update([
            'tanggal_pemeriksaan' => $validated['tanggal_pemeriksaan'],
            'id_pasien' => $pasien->id_pasien,
            'id_jenis_pemeriksaan' => $validated['id_jenis_pemeriksaan'],
            'id_modalitas' => $validated['id_modalitas'],
            'id_petugas' => $validated['id_petugas'],
            'keterangan' => $validated['keterangan'],
            'kesalahan_label' => $request->boolean('kesalahan_label'),
            'insiden_reaksi_obat_kontras' => $request->boolean('insiden_reaksi_obat_kontras'),
        ]);

        // Sync insiden
        $laporan->jenisInsiden()->sync($validated['insiden'] ?? []);

        return redirect()->route('laporan.repeat.index')
            ->with('success', 'Laporan Repeat berhasil diperbarui!');
    }

    /**
     * Update the reject report
     */
    public function updateReject(Request $request, Laporan $laporan): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'nama_pasien' => 'required|string|max:100',
            'no_rm' => 'required|string|max:20',
            'id_jenis_pemeriksaan' => 'required|exists:jenis_pemeriksaan,id_jenis_pemeriksaan',
            'id_modalitas' => 'required|exists:modalitas,id_modalitas',
            'id_petugas' => 'required|exists:petugas,id_petugas',
            'faktor' => 'required|array|min:1',
            'faktor.*' => 'exists:faktor_penyebab,id_faktor',
            'insiden' => 'nullable|array',
            'insiden.*' => 'exists:jenis_insiden,id_insiden',
            'keterangan' => 'nullable|string',
            'kesalahan_label' => 'nullable|boolean',
            'insiden_reaksi_obat_kontras' => 'nullable|boolean',
        ]);

        // Find or create pasien
        $pasien = Pasien::firstOrCreate(
            ['no_rm' => $validated['no_rm']],
            ['nama_pasien' => $validated['nama_pasien']]
        );

        // Update nama pasien if different
        if ($pasien->nama_pasien !== $validated['nama_pasien']) {
            $pasien->update(['nama_pasien' => $validated['nama_pasien']]);
        }

        // Update laporan
        $laporan->update([
            'tanggal_pemeriksaan' => $validated['tanggal_pemeriksaan'],
            'id_pasien' => $pasien->id_pasien,
            'id_jenis_pemeriksaan' => $validated['id_jenis_pemeriksaan'],
            'id_modalitas' => $validated['id_modalitas'],
            'id_petugas' => $validated['id_petugas'],
            'keterangan' => $validated['keterangan'],
            'kesalahan_label' => $request->boolean('kesalahan_label'),
            'insiden_reaksi_obat_kontras' => $request->boolean('insiden_reaksi_obat_kontras'),
        ]);

        // Sync faktor penyebab
        $laporan->faktorPenyebab()->sync($validated['faktor']);

        // Sync insiden
        $laporan->jenisInsiden()->sync($validated['insiden'] ?? []);

        return redirect()->route('laporan.reject.index')
            ->with('success', 'Laporan Reject berhasil diperbarui!');
    }

    /**
     * Remove the specified report
     */
    public function destroy(Laporan $laporan): RedirectResponse
    {
        $isRepeat = $laporan->isRepeat();
        $laporan->delete();

        $route = $isRepeat ? 'laporan.repeat.index' : 'laporan.reject.index';

        return redirect()->route($route)
            ->with('success', 'Laporan berhasil dihapus!');
    }

    /**
     * Show form for export Excel
     */
    public function exportForm(): View
    {
        return view('laporan.export');
    }

    /**
     * Export laporan to Excel
     */
    public function exportExcel(Request $request)
    {
        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2100',
            'tanggal_awal' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_awal',
            'modalitas' => 'required|in:all,ct_scan,x_ray',
        ]);

        $bulan = $validated['bulan'];
        $tahun = $validated['tahun'];
        $tanggalAwal = $validated['tanggal_awal'] ?? null;
        $tanggalAkhir = $validated['tanggal_akhir'] ?? null;
        $modalitas = $validated['modalitas'];

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $modalitasLabel = match ($modalitas) {
            'ct_scan' => '_CT_Scan',
            'x_ray' => '_X_Ray',
            default => '',
        };

        $filename = "Laporan_Repeat_Reject{$modalitasLabel}_{$namaBulan[$bulan]}_{$tahun}.xlsx";

        return Excel::download(
            new LaporanRepeatRejectExport($bulan, $tahun, $tanggalAwal, $tanggalAkhir, $modalitas),
            $filename
        );
    }
}
