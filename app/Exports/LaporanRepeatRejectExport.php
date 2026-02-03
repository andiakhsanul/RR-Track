<?php

namespace App\Exports;

use App\Models\Laporan;
use App\Models\JenisLaporan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class LaporanRepeatRejectExport implements WithEvents, WithTitle, WithDrawings
{
    protected $bulan;
    protected $tahun;
    protected $tanggalAwal;
    protected $tanggalAkhir;
    protected $modalitas; // 'all', 'ct_scan', 'x_ray'
    protected $data;

    public function __construct(int $bulan, int $tahun, string $tanggalAwal = null, string $tanggalAkhir = null, string $modalitas = 'all')
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
        $this->modalitas = $modalitas;
        $this->loadData();
    }

    protected function loadData()
    {
        $query = Laporan::with(['pasien', 'petugas', 'modalitas', 'jenisPemeriksaan', 'faktorPenyebab', 'jenisLaporan'])
            ->whereYear('tanggal_pemeriksaan', $this->tahun)
            ->whereMonth('tanggal_pemeriksaan', $this->bulan);

        if ($this->tanggalAwal && $this->tanggalAkhir) {
            $query->whereBetween('tanggal_pemeriksaan', [$this->tanggalAwal, $this->tanggalAkhir]);
        }

        // Filter by modalitas
        if ($this->modalitas === 'ct_scan') {
            $query->whereHas('modalitas', function ($q) {
                $q->where('nama_modalitas', 'LIKE', '%CT Scan%');
            });
        } elseif ($this->modalitas === 'x_ray') {
            $query->whereHas('modalitas', function ($q) {
                $q->where('nama_modalitas', 'LIKE', '%X Ray%')
                  ->orWhere('nama_modalitas', 'LIKE', '%X-Ray%')
                  ->orWhere('nama_modalitas', 'LIKE', '%XRay%');
            });
        }

        $this->data = $query->orderBy('tanggal_pemeriksaan', 'asc')->get();
    }

    private function getModalitasLabel(): string
    {
        return match($this->modalitas) {
            'ct_scan' => 'CT SCAN',
            'x_ray' => 'X-RAY',
            default => 'CT SCAN & X-RAY',
        };
    }

    private function hasHumanError(array $faktorNames): bool
    {
        foreach ($faktorNames as $faktor) {
            if (stripos($faktor, 'Human Error') !== false ||
                stripos($faktor, 'Posisi Px') !== false ||
                stripos($faktor, 'SOP') !== false ||
                stripos($faktor, 'Kesalahan Teknis') !== false ||
                stripos($faktor, 'Artefak') !== false) {
                return true;
            }
        }
        return false;
    }

    private function hasToolsError(array $faktorNames): bool
    {
        foreach ($faktorNames as $faktor) {
            if (stripos($faktor, 'Tools Error') !== false ||
                stripos($faktor, 'Alat Rusak') !== false ||
                stripos($faktor, 'Prosesing') !== false ||
                stripos($faktor, 'Server down') !== false ||
                stripos($faktor, 'Aliran') !== false) {
                return true;
            }
        }
        return false;
    }

    private function hasPatientError(array $faktorNames): bool
    {
        foreach ($faktorNames as $faktor) {
            if (stripos($faktor, 'Patient Error') !== false ||
                stripos($faktor, 'tidak kooperatif') !== false ||
                stripos($faktor, 'Moving') !== false) {
                return true;
            }
        }
        return false;
    }

    private function hasAdministratif(array $faktorNames): bool
    {
        foreach ($faktorNames as $faktor) {
            if (stripos($faktor, 'Administratif') !== false ||
                stripos($faktor, 'Print Double') !== false ||
                stripos($faktor, 'Double input') !== false ||
                stripos($faktor, 'Data Masuk') !== false) {
                return true;
            }
        }
        return false;
    }

    private function getNamaBulan(int $bulan): string
    {
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $namaBulan[$bulan] ?? '';
    }

    public function title(): string
    {
        $namaBulan = $this->getNamaBulan($this->bulan);
        return "Laporan {$namaBulan} {$this->tahun}";
    }

    public function drawings()
    {
        $drawings = [];
        $dataCount = $this->data ? $this->data->count() : 0;
        $signatureRow = 9 + $dataCount + 2; // Header rows + data + spacing

        // Tanda tangan Kepala Ruangan (kiri) - disimpan di storage/app/signatures (tidak bisa diakses publik)
        $ttdKepalaRuanganPath = storage_path('app/signatures/ttd_kepala_ruangan.png');
        if (file_exists($ttdKepalaRuanganPath)) {
            $ttdKepalaRuangan = new Drawing();
            $ttdKepalaRuangan->setName('TTD Kepala Ruangan');
            $ttdKepalaRuangan->setDescription('Tanda Tangan Kepala Ruangan');
            $ttdKepalaRuangan->setPath($ttdKepalaRuanganPath);
            $ttdKepalaRuangan->setHeight(70);
            $ttdKepalaRuangan->setCoordinates('B' . ($signatureRow + 2));
            $ttdKepalaRuangan->setOffsetX(20);
            $drawings[] = $ttdKepalaRuangan;
        }

        // Tanda tangan Kepala Instalasi (kanan) - disimpan di storage/app/signatures (tidak bisa diakses publik)
        $ttdKepalaInstalasiPath = storage_path('app/signatures/ttd_kepala_instalasi.png');
        if (file_exists($ttdKepalaInstalasiPath)) {
            $ttdKepalaInstalasi = new Drawing();
            $ttdKepalaInstalasi->setName('TTD Kepala Instalasi');
            $ttdKepalaInstalasi->setDescription('Tanda Tangan Kepala Instalasi');
            $ttdKepalaInstalasi->setPath($ttdKepalaInstalasiPath);
            $ttdKepalaInstalasi->setHeight(70);
            $ttdKepalaInstalasi->setCoordinates('K' . ($signatureRow + 2));
            $ttdKepalaInstalasi->setOffsetX(20);
            $drawings[] = $ttdKepalaInstalasi;
        }

        return $drawings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $dataCount = $this->data ? $this->data->count() : 0;

                // ===== COLUMN WIDTHS =====
                $sheet->getColumnDimension('A')->setWidth(5);    // NO
                $sheet->getColumnDimension('B')->setWidth(12);   // Tanggal
                $sheet->getColumnDimension('C')->setWidth(25);   // Nama Pasien
                $sheet->getColumnDimension('D')->setWidth(12);   // No.MR
                $sheet->getColumnDimension('E')->setWidth(22);   // Pemeriksaan (diperbesar untuk nama jenis pemeriksaan)
                $sheet->getColumnDimension('F')->setWidth(13);   // Human Error
                $sheet->getColumnDimension('G')->setWidth(13);   // Tools Error
                $sheet->getColumnDimension('H')->setWidth(13);   // Patient Error
                $sheet->getColumnDimension('I')->setWidth(13);   // Administratif
                $sheet->getColumnDimension('J')->setWidth(12);   // Repeat Film
                $sheet->getColumnDimension('K')->setWidth(12);   // Kesalahan Label
                $sheet->getColumnDimension('L')->setWidth(12);   // Insiden Reaksi
                $sheet->getColumnDimension('M')->setWidth(18);   // Nama Petugas

                // ===== TITLE SECTION (Rows 1-5) =====
                $sheet->mergeCells('A1:M1');
                $sheet->mergeCells('A2:M2');
                $sheet->mergeCells('A3:M3');
                $sheet->mergeCells('A4:M4');
                $sheet->mergeCells('A5:M5');

                $modalitasLabel = $this->getModalitasLabel();
                $sheet->setCellValue('A1', "DATA KEJADIAN REPEAT REJECT PADA PEMERIKSAAN RADIOLOGI ({$modalitasLabel})");
                $sheet->setCellValue('A2', 'RSUD UOBK SYARIFAH AMBANI RATO EBU BANGKALAN');
                $sheet->setCellValue('A3', 'INSTALASI RADIOLOGI');

                // Period text
                $namaBulan = $this->getNamaBulan($this->bulan);
                $periodText = "Bulan :  {$namaBulan} {$this->tahun}";
                if ($this->tanggalAwal && $this->tanggalAkhir) {
                    $tglAwal = Carbon::parse($this->tanggalAwal)->format('d F Y');
                    $tglAkhir = Carbon::parse($this->tanggalAkhir)->format('d F Y');
                    $periodText .= " / {$tglAwal} - {$tglAkhir}";
                }
                $sheet->setCellValue('A5', $periodText);

                // Style titles
                $sheet->getStyle('A1:A3')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getStyle('A5')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 10],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
                ]);

                // ===== HEADER ROWS (Rows 7-8) =====
                // Row 7: Group header for "Kejadian Kegagalan..."
                $sheet->mergeCells('F7:I7');
                $sheet->setCellValue('F7', 'Kejadian Kegagalan Pelayanan Rontgen /Pemeriksaan Ulang/Reject Film');

                // Merge vertical cells (rows 7-8) for non-grouped columns
                $sheet->mergeCells('A7:A8');
                $sheet->mergeCells('B7:B8');
                $sheet->mergeCells('C7:C8');
                $sheet->mergeCells('D7:D8');
                $sheet->mergeCells('E7:E8');
                $sheet->mergeCells('J7:J8');
                $sheet->mergeCells('K7:K8');
                $sheet->mergeCells('L7:L8');
                $sheet->mergeCells('M7:M8');

                // Row 7 values for merged cells
                $sheet->setCellValue('A7', 'NO');
                $sheet->setCellValue('B7', 'Tanggal');
                $sheet->setCellValue('C7', 'Nama Pasien');
                $sheet->setCellValue('D7', 'No.MR');
                $sheet->setCellValue('E7', 'Pemeriksaan');
                $sheet->setCellValue('J7', "Repeat Film/\nPengulangan\nFoto");
                $sheet->setCellValue('K7', "Kesalahan\nPemberian\nLabel");
                $sheet->setCellValue('L7', "Insiden\nReaksi\nObat Kontras");
                $sheet->setCellValue('M7', 'Nama Petugas');

                // Row 8: Sub-headers for error types
                $sheet->setCellValue('F8', "Human error\n(Posisi Px, SOP,\nKesalahan Teknis,\nFE, Artefak)");
                $sheet->setCellValue('G8', "Tools error\n(Alat rusak,\nProsesing, Server\ndown, Aliran listrik\ntdk stabil)");
                $sheet->setCellValue('H8', "Patient error\n(Px tidak kooperatif,\nPx moving)");
                $sheet->setCellValue('I8', "Administratif\n(Print double,\ndouble input, Data\nmasuk tdk sesuai)");

                // Style header rows
                $sheet->getStyle('A7:M8')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 8],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFE0E0E0'],
                    ],
                ]);

                // Row height for headers
                $sheet->getRowDimension(7)->setRowHeight(30);
                $sheet->getRowDimension(8)->setRowHeight(60);

                // ===== DATA ROWS (Starting from row 9) =====
                $rowNum = 9;
                $no = 1;

                foreach ($this->data as $laporan) {
                    $faktorNames = $laporan->faktorPenyebab->pluck('nama_faktor')->toArray();

                    $humanError = $this->hasHumanError($faktorNames) ? '✓' : '';
                    $toolsError = $this->hasToolsError($faktorNames) ? '✓' : '';
                    $patientError = $this->hasPatientError($faktorNames) ? '✓' : '';
                    $administratif = $this->hasAdministratif($faktorNames) ? '✓' : '';
                    $repeatFilm = $laporan->id_jenis_laporan === JenisLaporan::ULANG ? '✓' : '';
                    $kesalahanLabel = $laporan->kesalahan_label ? '✓' : '';
                    $insidenReaksi = $laporan->insiden_reaksi_obat_kontras ? '✓' : '';

                    $sheet->setCellValue("A{$rowNum}", $no++);
                    $sheet->setCellValue("B{$rowNum}", $laporan->tanggal_pemeriksaan->format('d-m-Y'));
                    $sheet->setCellValue("C{$rowNum}", $laporan->pasien->nama_pasien ?? '-');
                    $sheet->setCellValue("D{$rowNum}", $laporan->pasien->no_rm ?? '-');
                    $sheet->setCellValue("E{$rowNum}", $laporan->jenisPemeriksaan->nama_jenis_pemeriksaan ?? '-');
                    $sheet->setCellValue("F{$rowNum}", $humanError);
                    $sheet->setCellValue("G{$rowNum}", $toolsError);
                    $sheet->setCellValue("H{$rowNum}", $patientError);
                    $sheet->setCellValue("I{$rowNum}", $administratif);
                    $sheet->setCellValue("J{$rowNum}", $repeatFilm);
                    $sheet->setCellValue("K{$rowNum}", $kesalahanLabel);
                    $sheet->setCellValue("L{$rowNum}", $insidenReaksi);
                    $sheet->setCellValue("M{$rowNum}", $laporan->petugas->nama_petugas ?? ($laporan->petugas->inisial ?? '-'));

                    $rowNum++;
                }

                $lastDataRow = $rowNum - 1;

                // Style data rows
                if ($dataCount > 0) {
                    $sheet->getStyle("A9:M{$lastDataRow}")->applyFromArray([
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                    ]);

                    // Left align nama pasien
                    $sheet->getStyle("C9:C{$lastDataRow}")->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
                    ]);
                } else {
                    // If no data, create empty row with borders
                    $sheet->getStyle("A9:M9")->applyFromArray([
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                        ],
                    ]);
                    $lastDataRow = 9;
                }

                // ===== SIGNATURE SECTION =====
                $signatureStartRow = $lastDataRow + 3;

                // Kepala Ruangan (Left)
                $sheet->setCellValue("A{$signatureStartRow}", 'Kepala Ruangan Instalasi Radiologi');
                $sheet->mergeCells("A{$signatureStartRow}:D{$signatureStartRow}");

                // Space for signature (rows for TTD image)
                $nameRow1 = $signatureStartRow + 5;
                $nipRow1 = $signatureStartRow + 6;

                $sheet->setCellValue("A{$nameRow1}", 'Anita Prihatin Setyaningsih, S.Tr.Kes(Rad)');
                $sheet->mergeCells("A{$nameRow1}:D{$nameRow1}");
                $sheet->setCellValue("A{$nipRow1}", 'NIP. 198109142008012016');
                $sheet->mergeCells("A{$nipRow1}:D{$nipRow1}");

                // Kepala Instalasi (Right)
                $sheet->setCellValue("J{$signatureStartRow}", 'Kepala Instalasi Radiologi');
                $sheet->mergeCells("J{$signatureStartRow}:M{$signatureStartRow}");

                $sheet->setCellValue("J{$nameRow1}", 'dr. Sayyidah Orbariana, Sp. Rad');
                $sheet->mergeCells("J{$nameRow1}:M{$nameRow1}");
                $sheet->setCellValue("J{$nipRow1}", 'NIP. 196707301999032001');
                $sheet->mergeCells("J{$nipRow1}:M{$nipRow1}");

                // Style signature text
                $sheet->getStyle("A{$signatureStartRow}:D{$nipRow1}")->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getStyle("J{$signatureStartRow}:M{$nipRow1}")->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Bold names and underline
                $sheet->getStyle("A{$nameRow1}")->getFont()->setBold(true);
                $sheet->getStyle("J{$nameRow1}")->getFont()->setBold(true);

                // Set row heights for signature area (space for images)
                for ($i = $signatureStartRow + 1; $i < $nameRow1; $i++) {
                    $sheet->getRowDimension($i)->setRowHeight(18);
                }

                // ===== PRINT SETTINGS =====
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setFitToWidth(1);
                $sheet->getPageSetup()->setFitToHeight(0);

                // Print margins
                $sheet->getPageMargins()->setTop(0.5);
                $sheet->getPageMargins()->setRight(0.5);
                $sheet->getPageMargins()->setLeft(0.5);
                $sheet->getPageMargins()->setBottom(0.5);
            },
        ];
    }
}
