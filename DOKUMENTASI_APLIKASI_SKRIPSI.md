# Dokumentasi Aplikasi RR-Track untuk Kebutuhan Skripsi

Tanggal penyusunan: 25 April 2026

Dokumen ini menjelaskan isi folder aplikasi RR-Track dari sisi kebutuhan skripsi: tujuan aplikasi, struktur folder, arsitektur sistem, rancangan basis data, alur proses, fitur, tampilan, teknologi, cara menjalankan, dan bahan yang dapat digunakan untuk penulisan bab skripsi.

## 1. Identitas Aplikasi

| Komponen | Keterangan |
| --- | --- |
| Nama aplikasi | RR-Track |
| Kepanjangan | Repeat & Reject Tracking |
| Domain | Sistem monitoring laporan repeat dan reject pemeriksaan radiologi |
| Institusi pada tampilan/export | RSUD UOBK Syarifah Ambani Rato Ebu Bangkalan, Instalasi Radiologi |
| Jenis aplikasi | Web application berbasis Laravel |
| Pengguna utama | Admin/petugas berwenang instalasi radiologi |
| Tujuan utama | Mencatat, memantau, mengelola, menganalisis, dan mengekspor laporan kejadian repeat/reject pemeriksaan radiologi |

Secara sederhana, RR-Track adalah aplikasi pencatatan dan pelaporan kejadian repeat film/pemeriksaan ulang dan reject pada pemeriksaan radiologi. Aplikasi ini membantu proses dokumentasi kejadian, rekapitulasi data, monitoring tren bulanan, analisis faktor penyebab, serta pembuatan laporan Excel.

## 2. Ringkasan Permasalahan dan Solusi

Dalam layanan radiologi, kejadian repeat dan reject perlu dicatat karena berkaitan dengan mutu pelayanan, efisiensi pemeriksaan, keselamatan pasien, dan evaluasi kinerja instalasi. Jika pencatatan dilakukan manual, data lebih mudah tercecer, sulit difilter, dan membutuhkan waktu saat membuat laporan bulanan.

RR-Track menjadi solusi dengan menyediakan:

- Form input laporan repeat dan reject.
- Penyimpanan data pasien, petugas, modalitas, jenis pemeriksaan, faktor penyebab, dan insiden khusus.
- Dashboard statistik untuk melihat jumlah laporan dan grafik tren.
- Halaman pelaporan dengan filter tanggal.
- Export Excel dengan format laporan resmi dan tanda tangan pejabat.
- Autentikasi agar hanya pengguna yang login dapat mengakses sistem.

## 3. Ruang Lingkup Sistem

Fitur yang sudah tersedia di source code:

| Fitur | Penjelasan |
| --- | --- |
| Login dan logout | Menggunakan Laravel Breeze. Route aktif hanya login dan logout. |
| Dashboard | Menampilkan total laporan, total repeat, total reject, laporan bulan ini, grafik X-Ray/CT-Scan, dan grafik faktor penyebab reject. |
| Input laporan gabungan | Satu form untuk memilih jenis laporan repeat atau reject. |
| CRUD laporan repeat | Daftar, detail, edit, hapus, dan input khusus repeat. |
| CRUD laporan reject | Daftar, detail, edit, hapus, dan input khusus reject. |
| Filter tanggal | Tersedia pada daftar repeat, reject, dan halaman pelaporan gabungan. |
| Export Excel | Export data repeat/reject berdasarkan bulan, tahun, rentang tanggal opsional, dan modalitas. |
| Profile user | Update nama/email, update password, hapus akun. |
| Seed data awal | User admin, jenis laporan, modalitas, petugas, jenis pemeriksaan, faktor penyebab, dan jenis insiden. |

Catatan: beberapa controller dan view bawaan Breeze seperti register, lupa password, reset password, dan verifikasi email masih ada di folder, tetapi `routes/auth.php` saat ini hanya mengaktifkan route login dan logout.

## 4. Teknologi yang Digunakan

### 4.1 Backend

| Teknologi | Fungsi |
| --- | --- |
| PHP | Bahasa pemrograman backend. `composer.json` mensyaratkan PHP `^8.2`. |
| Laravel Framework 12 | Framework utama aplikasi, aktual dari dependency lokal: Laravel 12.47.0. |
| Laravel Breeze | Scaffold autentikasi dan profile user. |
| Eloquent ORM | Model dan relasi database. |
| Maatwebsite Excel | Membuat file Excel export laporan. |
| PHPUnit | Testing aplikasi. |

### 4.2 Frontend

| Teknologi | Fungsi |
| --- | --- |
| Blade | Template view Laravel. |
| Tailwind CSS | Styling halaman. Aplikasi memakai kombinasi Tailwind via Vite dan CDN. |
| Alpine.js | Interaksi ringan seperti toggle, modal logout, dan perubahan form dinamis. |
| Chart.js | Grafik dashboard. |
| Font Awesome | Ikon pada UI. |
| Vite | Build asset frontend. |

### 4.3 Infrastruktur

| Teknologi | Fungsi |
| --- | --- |
| Docker | Menjalankan aplikasi dengan container. |
| PHP-FPM | Runtime PHP dalam container. |
| Nginx | Web server container. |
| MySQL 8.0 | Database untuk mode Docker. |
| Redis | Cache/queue opsional pada Docker. |
| phpMyAdmin | Pengelolaan database melalui browser. |

## 5. Arsitektur Sistem

Aplikasi memakai pola MVC bawaan Laravel.

```text
Browser
  -> Route Laravel
  -> Middleware auth
  -> Controller
  -> Model Eloquent
  -> Database
  -> Blade View
  -> Browser
```

Penjelasan lapisan:

| Lapisan | Folder/File | Fungsi |
| --- | --- | --- |
| Routing | `routes/web.php`, `routes/auth.php` | Mendefinisikan URL dan controller yang dipanggil. |
| Controller | `app/Http/Controllers` | Mengatur validasi request, query data, CRUD, dan pemilihan view. |
| Model | `app/Models` | Representasi tabel database dan relasi antar tabel. |
| View | `resources/views` | Tampilan halaman HTML berbasis Blade. |
| Database | `database/migrations`, `database/seeders` | Struktur tabel dan data awal. |
| Export | `app/Exports` | Format dan isi export Excel. |
| Config | `config` | Konfigurasi aplikasi, database, session, mail, queue, logging, dan filesystem. |

## 6. Struktur Folder Root

| Folder/File | Fungsi |
| --- | --- |
| `.composer/` | Cache/konfigurasi Composer lokal. Tidak menjadi bagian utama source aplikasi. |
| `.config/` | Konfigurasi lokal, misalnya PsySH. Tidak menjadi bagian utama source aplikasi. |
| `.env` | Konfigurasi lokal berisi environment aplikasi. Tidak boleh dipublikasikan. |
| `.env.example` | Contoh konfigurasi environment. Aman dijadikan acuan setup. |
| `.editorconfig` | Standar format file seperti indentasi 4 spasi dan LF. |
| `.gitignore` | Daftar file/folder yang tidak masuk Git, seperti `.env`, `vendor`, `node_modules`, `storage/logs`. |
| `DOKUMENTASI_TAMPILAN.md` | Dokumentasi khusus tampilan/UI aplikasi. |
| `DOKUMENTASI_APLIKASI_SKRIPSI.md` | Dokumen ini. |
| `Dokumen_Desain_Basis_Data_Ulang_Tolak_Indonesia_FINAL_v12.pdf` | Dokumen desain basis data dalam format PDF 30 halaman. File tampak berbasis gambar/scanned, sehingga isinya tidak terbaca otomatis sebagai teks. |
| `README.md` | README bawaan Laravel, belum spesifik RR-Track. |
| `Dockerfile` | Build image PHP-FPM untuk aplikasi. |
| `docker-compose.yml` | Orkestrasi container app, Nginx, MySQL, phpMyAdmin, dan Redis. |
| `Makefile` | Shortcut command Docker seperti `make up`, `make fresh`, `make test`. |
| `composer.json` | Dependency PHP dan script Composer. |
| `composer.lock` | Versi dependency PHP yang terkunci. |
| `package.json` | Dependency frontend dan script NPM. |
| `vite.config.js` | Konfigurasi Vite untuk asset Laravel. |
| `tailwind.config.js` | Konfigurasi Tailwind untuk build asset. |
| `postcss.config.js` | Konfigurasi PostCSS dan Autoprefixer. |
| `phpunit.xml` | Konfigurasi testing PHPUnit. |
| `artisan` | CLI Laravel untuk migration, serve, test, cache, dan command lain. |
| `app/` | Source utama backend Laravel. |
| `bootstrap/` | Bootstrap aplikasi Laravel. |
| `config/` | File konfigurasi Laravel. |
| `database/` | Migration, seeder, factory, dan SQLite lokal. |
| `docker/` | Konfigurasi Nginx, PHP, dan MySQL untuk Docker. |
| `public/` | Entry point web, favicon, robot, dan aset gambar publik. |
| `resources/` | View Blade, CSS, dan JavaScript frontend. |
| `routes/` | Definisi route web, auth, dan console. |
| `storage/` | File runtime Laravel, log, session, view cache, dan tanda tangan export. |
| `tests/` | Unit test dan feature test. |
| `vendor/` | Dependency Composer. Tidak perlu dibahas sebagai source skripsi. |

## 7. Struktur Folder `app`

| Path | Isi dan Fungsi |
| --- | --- |
| `app/Exports/LaporanRepeatRejectExport.php` | Class export Excel laporan repeat/reject. |
| `app/Http/Controllers/DashboardController.php` | Controller dashboard statistik dan grafik. |
| `app/Http/Controllers/LaporanController.php` | Controller utama CRUD laporan, pelaporan, dan export. |
| `app/Http/Controllers/ProfileController.php` | Controller profile user. |
| `app/Http/Controllers/Auth/` | Controller autentikasi bawaan Breeze. |
| `app/Http/Requests/Auth/LoginRequest.php` | Validasi login dan rate limiter. |
| `app/Http/Requests/ProfileUpdateRequest.php` | Validasi update profile. |
| `app/Models/` | Model Eloquent untuk tabel database. |
| `app/Providers/AppServiceProvider.php` | Service provider aplikasi. Saat ini masih default. |
| `app/View/Components/AppLayout.php` | Komponen layout aplikasi. |
| `app/View/Components/GuestLayout.php` | Komponen layout guest. |

## 8. Routing Aplikasi

Route utama berada di `routes/web.php`. Route autentikasi berada di `routes/auth.php`.

| Method | URL | Nama Route | Controller/Action | Keterangan |
| --- | --- | --- | --- | --- |
| GET | `/` | - | Closure | Redirect ke dashboard jika sudah login, atau ke login jika belum. |
| GET | `/dashboard` | `dashboard` | `DashboardController@index` | Dashboard statistik. |
| GET | `/laporan/create` | `laporan.create` | `LaporanController@create` | Form input gabungan repeat/reject. |
| POST | `/laporan` | `laporan.store` | `LaporanController@store` | Simpan laporan gabungan. |
| GET | `/pelaporan` | `pelaporan` | `LaporanController@pelaporan` | Halaman gabungan export, daftar reject, dan daftar repeat. |
| GET | `/laporan/export` | `laporan.export.form` | `LaporanController@exportForm` | Form export terpisah. |
| POST | `/laporan/export` | `laporan.export` | `LaporanController@exportExcel` | Download Excel. |
| GET | `/laporan/repeat` | `laporan.repeat.index` | `LaporanController@indexRepeat` | Daftar repeat. |
| GET | `/laporan/repeat/create` | `laporan.repeat.create` | `LaporanController@createRepeat` | Form khusus repeat. |
| POST | `/laporan/repeat` | `laporan.repeat.store` | `LaporanController@storeRepeat` | Simpan repeat. |
| GET | `/laporan/repeat/{laporan}` | `laporan.repeat.show` | `LaporanController@showRepeat` | Detail repeat. |
| GET | `/laporan/repeat/{laporan}/edit` | `laporan.repeat.edit` | `LaporanController@editRepeat` | Edit repeat. |
| PUT | `/laporan/repeat/{laporan}` | `laporan.repeat.update` | `LaporanController@updateRepeat` | Update repeat. |
| DELETE | `/laporan/repeat/{laporan}` | `laporan.repeat.destroy` | `LaporanController@destroy` | Hapus repeat. |
| GET | `/laporan/reject` | `laporan.reject.index` | `LaporanController@indexReject` | Daftar reject. |
| GET | `/laporan/reject/create` | `laporan.reject.create` | `LaporanController@createReject` | Form khusus reject. |
| POST | `/laporan/reject` | `laporan.reject.store` | `LaporanController@storeReject` | Simpan reject. |
| GET | `/laporan/reject/{laporan}` | `laporan.reject.show` | `LaporanController@showReject` | Detail reject. |
| GET | `/laporan/reject/{laporan}/edit` | `laporan.reject.edit` | `LaporanController@editReject` | Edit reject. |
| PUT | `/laporan/reject/{laporan}` | `laporan.reject.update` | `LaporanController@updateReject` | Update reject. |
| DELETE | `/laporan/reject/{laporan}` | `laporan.reject.destroy` | `LaporanController@destroy` | Hapus reject. |
| GET | `/profile` | `profile.edit` | `ProfileController@edit` | Halaman profile. |
| PATCH | `/profile` | `profile.update` | `ProfileController@update` | Update profile. |
| DELETE | `/profile` | `profile.destroy` | `ProfileController@destroy` | Hapus akun. |
| GET | `/login` | `login` | `AuthenticatedSessionController@create` | Form login. |
| POST | `/login` | - | `AuthenticatedSessionController@store` | Proses login. |
| POST | `/logout` | `logout` | `AuthenticatedSessionController@destroy` | Logout. |

Semua route fitur utama berada di dalam middleware `auth`, sehingga pengguna harus login sebelum mengakses dashboard, input, pelaporan, export, repeat, reject, dan profile.

## 9. Controller Utama

### 9.1 `DashboardController`

Controller ini menyusun data untuk dashboard:

- `totalRepeat`: jumlah laporan dengan jenis `ulang`.
- `totalReject`: jumlah laporan dengan jenis `tolak`.
- `totalLaporan`: jumlah seluruh laporan.
- `laporanBulanIni`: jumlah laporan pada bulan berjalan.
- `recentLaporan`: 10 laporan terbaru.
- `chartBulanan`: data repeat/reject 6 bulan terakhir.
- `chartBulananXRay`: data 6 bulan terakhir khusus modalitas X-Ray.
- `chartBulananCTScan`: data 6 bulan terakhir khusus modalitas CT Scan.
- `chartFaktorXRay`: faktor penyebab reject X-Ray bulan berjalan.
- `chartFaktorCTScan`: faktor penyebab reject CT Scan bulan berjalan.
- `chartModalitas`: distribusi laporan berdasarkan modalitas.
- `chartFaktor`: distribusi faktor penyebab reject secara global.

Method privat penting:

| Method | Fungsi |
| --- | --- |
| `getMonthlyData()` | Menghitung repeat dan reject selama 6 bulan terakhir. |
| `getModalitasMonthlyData($modalitasName)` | Menghitung repeat/reject per bulan untuk modalitas tertentu. |
| `getModalitasRejectFactorsData($modalitasName)` | Menghitung faktor penyebab reject bulan berjalan pada modalitas tertentu. |
| `getModalitasData()` | Mengambil jumlah laporan per modalitas. |
| `getFaktorData()` | Mengambil jumlah laporan berdasarkan faktor penyebab. |

### 9.2 `LaporanController`

Ini adalah controller paling penting dalam aplikasi. Tanggung jawabnya:

- Menampilkan daftar repeat dan reject.
- Menampilkan form input.
- Menyimpan laporan repeat/reject.
- Menampilkan detail laporan.
- Mengedit laporan.
- Menghapus laporan.
- Menampilkan halaman pelaporan gabungan.
- Menjalankan export Excel.

Alur simpan laporan gabungan pada method `store()`:

1. Validasi input.
2. Membaca `jenis_laporan` dari request.
3. Jika `reject`, sistem memakai `JenisLaporan::TOLAK`.
4. Jika `repeat`, sistem memakai `JenisLaporan::ULANG`.
5. Sistem mencari pasien berdasarkan `no_rm`.
6. Jika pasien belum ada, sistem membuat data pasien baru.
7. Jika nama pasien berubah, sistem memperbarui nama pasien.
8. Sistem membuat record pada tabel `laporan`.
9. Jika laporan reject, sistem menyimpan relasi faktor penyebab ke tabel pivot `detail_faktor_laporan`.
10. Jika ada insiden, sistem menyimpan relasi ke `detail_insiden_laporan`.
11. Sistem redirect ke daftar repeat atau reject sesuai jenis laporan.

Validasi utama:

| Field | Aturan |
| --- | --- |
| `jenis_laporan` | Wajib, hanya `repeat` atau `reject`. |
| `tanggal_pemeriksaan` | Wajib, format tanggal. |
| `nama_pasien` | Wajib, string, maksimal 100 karakter. |
| `no_rm` | Wajib, string, maksimal 20 karakter. |
| `id_jenis_pemeriksaan` | Wajib, harus ada di tabel `jenis_pemeriksaan`. |
| `id_modalitas` | Wajib, harus ada di tabel `modalitas`. |
| `id_petugas` | Wajib, harus ada di tabel `petugas`. |
| `faktor[]` | Wajib untuk reject, minimal 1 faktor. |
| `keterangan` | Opsional. |
| `kesalahan_label` | Opsional, boolean. |
| `insiden_reaksi_obat_kontras` | Opsional, boolean. |

Catatan: backend juga mendukung input `insiden[]` berbasis tabel `jenis_insiden`, tetapi tampilan form saat ini lebih menonjolkan dua field boolean: `kesalahan_label` dan `insiden_reaksi_obat_kontras`.

### 9.3 `LaporanRepeatRejectExport`

Class ini memakai package Maatwebsite Excel untuk membuat file `.xlsx`.

Fitur export:

- Filter bulan dan tahun.
- Filter rentang tanggal opsional.
- Filter modalitas: semua, CT Scan, atau X-Ray.
- Header laporan resmi:
  - Data kejadian repeat reject pada pemeriksaan radiologi.
  - RSUD UOBK Syarifah Ambani Rato Ebu Bangkalan.
  - Instalasi Radiologi.
- Kolom Excel A sampai M:
  - No
  - Tanggal
  - Nama Pasien
  - No.MR
  - Pemeriksaan
  - Human Error
  - Tools Error
  - Patient Error
  - Administratif
  - Repeat Film/Pengulangan Foto
  - Kesalahan Pemberian Label
  - Insiden Reaksi Obat Kontras
  - Nama Petugas
- Tanda tangan otomatis dari:
  - `storage/app/signatures/ttd_kepala_ruangan.png`
  - `storage/app/signatures/ttd_kepala_instalasi.png`

Pengelompokan faktor penyebab dilakukan dengan pencarian teks:

| Kelompok | Kata kunci yang dicari |
| --- | --- |
| Human Error | Human Error, Posisi Px, SOP, Kesalahan Teknis, Artefak |
| Tools Error | Tools Error, Alat Rusak, Prosesing, Server down, Aliran |
| Patient Error | Patient Error, tidak kooperatif, Moving |
| Administratif | Administratif, Print Double, Double input, Data Masuk |

## 10. Model dan Relasi

| Model | Tabel | Primary Key | Relasi Utama |
| --- | --- | --- | --- |
| `User` | `users` | `id` | User login aplikasi. |
| `Pasien` | `pasien` | `id_pasien` | Satu pasien memiliki banyak laporan. |
| `Petugas` | `petugas` | `id_petugas` | Satu petugas memiliki banyak laporan. |
| `Modalitas` | `modalitas` | `id_modalitas` | Satu modalitas memiliki banyak laporan. |
| `JenisPemeriksaan` | `jenis_pemeriksaan` | `id_jenis_pemeriksaan` | Satu jenis pemeriksaan memiliki banyak laporan. |
| `JenisLaporan` | `jenis_laporan` | `id_jenis_laporan` | Satu jenis laporan memiliki banyak laporan. |
| `FaktorPenyebab` | `faktor_penyebab` | `id_faktor` | Many-to-many dengan laporan melalui `detail_faktor_laporan`. |
| `JenisInsiden` | `jenis_insiden` | `id_insiden` | Many-to-many dengan laporan melalui `detail_insiden_laporan`. |
| `Laporan` | `laporan` | `id_laporan` | Belongs to pasien, petugas, modalitas, jenis pemeriksaan, jenis laporan; belongsToMany faktor dan insiden. |

Konstanta pada `JenisLaporan`:

| Konstanta | Nilai | Makna |
| --- | --- | --- |
| `JenisLaporan::ULANG` | 1 | Repeat/pemeriksaan ulang. |
| `JenisLaporan::TOLAK` | 2 | Reject/pemeriksaan ditolak. |

Scope pada `Laporan`:

| Scope | Fungsi |
| --- | --- |
| `scopeRepeat()` | Filter laporan dengan `id_jenis_laporan = 1`. |
| `scopeReject()` | Filter laporan dengan `id_jenis_laporan = 2`. |

## 11. Rancangan Basis Data

### 11.1 Daftar Tabel

| Tabel | Fungsi |
| --- | --- |
| `users` | Menyimpan akun pengguna aplikasi. |
| `pasien` | Menyimpan data pasien berdasarkan nomor rekam medis. |
| `petugas` | Menyimpan inisial dan nama lengkap petugas radiologi. |
| `modalitas` | Menyimpan jenis modalitas pemeriksaan, misalnya X Ray dan CT Scan. |
| `jenis_pemeriksaan` | Menyimpan daftar jenis pemeriksaan radiologi. |
| `jenis_laporan` | Menyimpan jenis laporan: ulang/repeat dan tolak/reject. |
| `faktor_penyebab` | Menyimpan faktor penyebab reject. |
| `jenis_insiden` | Menyimpan jenis insiden. |
| `laporan` | Tabel transaksi utama laporan repeat/reject. |
| `detail_faktor_laporan` | Pivot many-to-many laporan dan faktor penyebab. |
| `detail_insiden_laporan` | Pivot many-to-many laporan dan jenis insiden. |
| `sessions` | Menyimpan session jika session driver memakai database. |

### 11.2 Tabel `laporan`

Kolom penting:

| Kolom | Fungsi |
| --- | --- |
| `id_laporan` | Primary key laporan. |
| `id_jenis_laporan` | Foreign key ke `jenis_laporan`. |
| `tanggal_pemeriksaan` | Tanggal pemeriksaan radiologi. |
| `id_pasien` | Foreign key ke `pasien`. |
| `id_jenis_pemeriksaan` | Foreign key ke `jenis_pemeriksaan`. |
| `id_modalitas` | Foreign key ke `modalitas`. |
| `id_petugas` | Foreign key ke `petugas`. |
| `keterangan` | Catatan tambahan. |
| `kesalahan_label` | Penanda insiden kesalahan pemberian label. |
| `insiden_reaksi_obat_kontras` | Penanda insiden reaksi obat kontras. |
| `created_at` | Waktu data dibuat. |
| `updated_at` | Waktu data diperbarui. |

### 11.3 Relasi Antar Tabel

```text
users
  digunakan untuk autentikasi

pasien 1 --- n laporan
petugas 1 --- n laporan
modalitas 1 --- n laporan
jenis_pemeriksaan 1 --- n laporan
jenis_laporan 1 --- n laporan

laporan n --- n faktor_penyebab
  melalui detail_faktor_laporan

laporan n --- n jenis_insiden
  melalui detail_insiden_laporan
```

### 11.4 Aturan Foreign Key

Pada tabel `laporan`, relasi ke master data memakai `onDelete('restrict')`. Artinya data master seperti pasien, petugas, modalitas, dan jenis pemeriksaan tidak bisa dihapus jika masih dipakai oleh laporan.

Pada tabel pivot:

- Jika laporan dihapus, detail faktor dan detail insiden ikut terhapus karena `onDelete('cascade')`.
- Faktor penyebab dan jenis insiden tidak bisa dihapus jika masih direferensikan karena `onDelete('restrict')`.

## 12. Data Awal dari Seeder

Seeder dijalankan melalui `php artisan db:seed` atau `php artisan migrate:fresh --seed`.

| Seeder | Data |
| --- | --- |
| `UserSeeder` | User admin pengembangan: `admin@rumahsakit.com` dengan password awal `password123`. Wajib diganti untuk production. |
| `JenisLaporanSeeder` | `ulang` dan `tolak`. |
| `ModalitasSeeder` | `X Ray` dan `CT Scan`. |
| `PetugasSeeder` | Inisial: FB, FA, IR, RZ, DF, HN, NN, AK, EA. |
| `JenisPemeriksaanSeeder` | 22 jenis pemeriksaan, termasuk Thorax AP/PA, Skull AP/LAT, CT Kepala, CT Abdomen, CT Thorax, dan lain-lain. |
| `FaktorPenyebabSeeder` | Human Error, Tools Error, Patient Error, Administratif. |
| `JenisInsidenSeeder` | Insiden Reaksi Obat Kontras dan Kesalahan Pemberian Obat. |

## 13. Alur Proses Bisnis

### 13.1 Login

1. Pengguna membuka aplikasi.
2. Jika belum login, root `/` mengarahkan ke `/login`.
3. Pengguna mengisi email dan password.
4. `LoginRequest` memvalidasi email/password dan membatasi percobaan login.
5. Jika berhasil, session dibuat ulang dan pengguna diarahkan ke dashboard.

### 13.2 Input Laporan Repeat

1. Pengguna membuka menu Input.
2. Pengguna memilih jenis laporan `Repeat`.
3. Pengguna mengisi tanggal, modalitas, jenis pemeriksaan, petugas, data pasien, insiden khusus jika ada, dan keterangan.
4. Sistem memvalidasi input.
5. Sistem mencari atau membuat data pasien berdasarkan `no_rm`.
6. Sistem membuat data `laporan` dengan `id_jenis_laporan = 1`.
7. Sistem redirect ke daftar laporan repeat.

### 13.3 Input Laporan Reject

1. Pengguna membuka menu Input.
2. Pengguna memilih jenis laporan `Reject`.
3. Pengguna mengisi data pemeriksaan, pasien, faktor penyebab, insiden khusus, dan keterangan.
4. Sistem mewajibkan minimal satu faktor penyebab.
5. Sistem membuat data laporan dengan `id_jenis_laporan = 2`.
6. Sistem menyimpan faktor penyebab ke tabel `detail_faktor_laporan`.
7. Sistem redirect ke daftar laporan reject.

### 13.4 Edit dan Hapus Laporan

1. Pengguna membuka detail atau daftar laporan.
2. Pengguna memilih tombol edit atau hapus.
3. Pada edit, sistem memuat data lama dan master data untuk dropdown.
4. Setelah update, relasi faktor/insiden disinkronkan ulang dengan `sync()`.
5. Pada hapus, sistem menghapus record laporan; data pivot ikut terhapus karena cascade.

### 13.5 Pelaporan dan Export Excel

1. Pengguna membuka menu Pelaporan.
2. Pengguna dapat memfilter daftar repeat/reject berdasarkan tanggal.
3. Pengguna memilih bulan, tahun, modalitas, dan rentang tanggal opsional.
4. Sistem mengambil data sesuai filter.
5. Sistem membuat file Excel dengan format laporan repeat/reject.
6. File Excel diunduh oleh browser.

## 14. Tampilan Aplikasi

Rincian visual lengkap sudah ada di `DOKUMENTASI_TAMPILAN.md`. Ringkasan halaman:

| Halaman | File View | Fungsi |
| --- | --- | --- |
| Login | `resources/views/auth/login.blade.php` | Halaman login custom dengan logo RSUD, Unair, Vokasi, dan RR-Track. |
| Dashboard | `resources/views/dashboard/index.blade.php` | Statistik, card ringkasan, dan chart. |
| Input laporan | `resources/views/laporan/create.blade.php` | Form gabungan repeat/reject dengan Alpine.js. |
| Pelaporan | `resources/views/laporan/pelaporan.blade.php` | Export dan daftar singkat repeat/reject. |
| Daftar repeat | `resources/views/laporan/repeat/index.blade.php` | Tabel repeat dengan filter tanggal. |
| Detail repeat | `resources/views/laporan/repeat/show.blade.php` | Detail satu laporan repeat. |
| Edit repeat | `resources/views/laporan/repeat/edit.blade.php` | Form edit repeat. |
| Daftar reject | `resources/views/laporan/reject/index.blade.php` | Tabel reject dengan filter tanggal. |
| Detail reject | `resources/views/laporan/reject/show.blade.php` | Detail satu laporan reject. |
| Edit reject | `resources/views/laporan/reject/edit.blade.php` | Form edit reject. |
| Export | `resources/views/laporan/export.blade.php` | Form export Excel terpisah. |
| Profile | `resources/views/profile/edit.blade.php` | Update profile, password, dan hapus akun. |

Layout utama berada di:

- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/navigation.blade.php`
- `resources/views/layouts/guest.blade.php`

Komponen reusable berada di `resources/views/components`, misalnya button, modal, input, dropdown, nav link, dan application logo.

## 15. Aset Publik dan File Storage

| File | Fungsi |
| --- | --- |
| `public/images/LogoRsudBangkalan.jpg` | Logo RSUD pada login, navbar, favicon, dashboard. |
| `public/images/LogoUnair.png` | Logo Universitas Airlangga pada login. |
| `public/images/Logovokasi.jpg` | Logo Fakultas Vokasi pada login. |
| `public/images/logo.png` | Logo RR-Track pada login. |
| `storage/app/signatures/ttd_kepala_ruangan.png` | Tanda tangan kepala ruangan untuk export Excel. |
| `storage/app/signatures/ttd_kepala_instalasi.png` | Tanda tangan kepala instalasi untuk export Excel. |

Folder `storage/framework` dan `storage/logs` berisi file runtime seperti session, compiled view, cache, dan log. File tersebut bukan source utama aplikasi.

## 16. Konfigurasi Penting

| File | Keterangan |
| --- | --- |
| `config/app.php` | Nama aplikasi, environment, debug, timezone, locale, key. |
| `config/auth.php` | Guard autentikasi web dan provider user. |
| `config/database.php` | Koneksi SQLite, MySQL, MariaDB, PostgreSQL, SQL Server, Redis. |
| `config/session.php` | Driver session, lifetime, cookie, keamanan session. |
| `config/cache.php` | Driver cache. |
| `config/queue.php` | Driver queue. |
| `config/mail.php` | Driver mail. Default example memakai log. |
| `config/filesystems.php` | Disk local, public, dan S3. |
| `config/logging.php` | Channel log aplikasi. |

Catatan environment lokal yang terbaca dari `php artisan about`:

- Application Name: RR-Track
- Laravel Version: 12.47.0
- PHP CLI Version: 8.4.8
- Environment: local
- Debug Mode: enabled
- URL: `localhost:8888`
- Locale: `id`
- Database driver aktif lokal: `mysql`
- Session driver aktif lokal: `file`

Nilai di atas berasal dari konfigurasi lokal saat dokumentasi dibuat. Untuk production, sesuaikan `.env`.

## 17. Cara Menjalankan Aplikasi

### 17.1 Tanpa Docker

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

Jika ingin build asset production:

```bash
npm run build
```

### 17.2 Dengan Docker

```bash
make build
make up
make fresh
```

URL Docker dari `docker-compose.yml`:

| Service | URL/Port |
| --- | --- |
| Aplikasi | `http://localhost:8888` |
| phpMyAdmin | `http://localhost:8889` |
| MySQL host port | `3307` |
| Redis host port | `6381` |

Command Makefile penting:

| Command | Fungsi |
| --- | --- |
| `make up` | Menjalankan semua container. |
| `make down` | Menghentikan container. |
| `make logs` | Melihat log container. |
| `make shell` | Masuk ke container app. |
| `make fresh` | Menjalankan `migrate:fresh --seed`. |
| `make migrate` | Menjalankan migration. |
| `make seed` | Menjalankan seeder. |
| `make test` | Menjalankan test. |
| `make clear` | Membersihkan cache Laravel. |

## 18. Testing

Folder `tests/` berisi test bawaan Laravel Breeze:

| Test | Fungsi |
| --- | --- |
| `AuthenticationTest` | Login, gagal login, logout. |
| `RegistrationTest` | Register user. |
| `PasswordResetTest` | Reset password. |
| `PasswordUpdateTest` | Update password. |
| `EmailVerificationTest` | Verifikasi email. |
| `PasswordConfirmationTest` | Konfirmasi password. |
| `ProfileTest` | Profile, update profile, hapus akun. |
| `ExampleTest` | Test contoh bawaan. |

Catatan penting untuk skripsi:

- Test custom untuk modul laporan belum tersedia.
- Karena `routes/auth.php` saat ini hanya mengaktifkan login/logout, sebagian test bawaan Breeze yang menguji register, forgot password, reset password, dan verifikasi email perlu disesuaikan jika test suite ingin dijalankan penuh.

Rekomendasi test tambahan:

| Skenario | Jenis Test |
| --- | --- |
| User tidak login tidak dapat membuka dashboard | Feature/auth test |
| User dapat membuat laporan repeat | Feature test |
| User dapat membuat laporan reject dengan minimal satu faktor | Feature test |
| Reject tanpa faktor gagal divalidasi | Feature test |
| Filter tanggal daftar repeat/reject bekerja | Feature test |
| Export Excel menghasilkan download `.xlsx` | Feature test |
| Dashboard menghitung total repeat/reject dengan benar | Feature test |

## 19. Keamanan Sistem

Keamanan yang sudah digunakan:

- Route fitur utama memakai middleware `auth`.
- Login memakai rate limiter dari `LoginRequest`.
- Password user di-hash oleh Laravel.
- Form Blade memakai CSRF token.
- Validasi request dilakukan di controller dan FormRequest.
- Relasi model menggunakan foreign key untuk menjaga integritas data.
- `.env` masuk `.gitignore`, sehingga konfigurasi rahasia tidak dipublikasikan.

Hal yang perlu diperhatikan sebelum production:

- Ganti password default admin dari seeder.
- Set `APP_ENV=production`.
- Set `APP_DEBUG=false`.
- Pastikan `APP_KEY` sudah dibuat dan tidak berubah setelah data production aktif.
- Gunakan kredensial database yang aman.
- Gunakan HTTPS.
- Batasi akses phpMyAdmin hanya untuk pengembangan atau jaringan internal.
- Pastikan folder `storage` dan `bootstrap/cache` memiliki permission yang sesuai.

## 20. Kesesuaian untuk Skripsi

Dokumen ini dapat digunakan sebagai dasar penulisan bagian-bagian berikut:

### Bab I: Pendahuluan

Contoh poin:

- Latar belakang perlunya pencatatan repeat dan reject radiologi.
- Permasalahan pencatatan manual.
- Tujuan membangun sistem RR-Track.
- Manfaat bagi instalasi radiologi, petugas, dan evaluasi mutu.

### Bab II: Landasan Teori

Materi yang relevan:

- Sistem informasi.
- Radiologi dan mutu pelayanan radiologi.
- Repeat film/pemeriksaan ulang.
- Reject film/pemeriksaan ditolak.
- Laravel.
- MVC.
- Database relasional.
- MySQL/SQLite.
- Dashboard dan visualisasi data.
- Black box testing.

### Bab III: Analisis dan Perancangan

Isi yang dapat dipakai:

- Analisis kebutuhan fungsional dan non-fungsional.
- Aktor sistem: admin/petugas.
- Use case: login, input laporan, lihat dashboard, filter laporan, export Excel, edit/hapus laporan.
- Activity diagram berdasarkan alur proses pada dokumen ini.
- ERD berdasarkan tabel dan relasi pada bagian basis data.
- Perancangan interface berdasarkan `DOKUMENTASI_TAMPILAN.md`.

### Bab IV: Implementasi dan Pengujian

Isi yang dapat dipakai:

- Implementasi Laravel MVC.
- Implementasi database migration dan seeder.
- Implementasi dashboard Chart.js.
- Implementasi CRUD laporan.
- Implementasi export Excel.
- Screenshot halaman login, dashboard, input, pelaporan, detail, edit, export.
- Pengujian black box per fitur.

### Bab V: Kesimpulan dan Saran

Contoh kesimpulan:

- Sistem berhasil membantu pencatatan laporan repeat dan reject.
- Sistem menyediakan dashboard dan export Excel.
- Data tersimpan lebih terstruktur melalui basis data relasional.

Contoh saran:

- Tambah role user lebih detail, misalnya admin, petugas, kepala ruangan.
- Tambah audit log perubahan data.
- Tambah laporan PDF.
- Tambah notifikasi atau approval.
- Tambah test otomatis untuk modul laporan.
- Tambah filter statistik lebih lengkap.

## 21. Kebutuhan Fungsional

| Kode | Kebutuhan |
| --- | --- |
| RF-01 | Sistem menyediakan autentikasi login dan logout. |
| RF-02 | Sistem menampilkan dashboard statistik repeat/reject. |
| RF-03 | Sistem menyediakan form input laporan repeat. |
| RF-04 | Sistem menyediakan form input laporan reject. |
| RF-05 | Sistem memvalidasi data laporan sebelum disimpan. |
| RF-06 | Sistem menyimpan data pasien berdasarkan nomor rekam medis. |
| RF-07 | Sistem menampilkan daftar laporan repeat. |
| RF-08 | Sistem menampilkan daftar laporan reject. |
| RF-09 | Sistem menampilkan detail laporan. |
| RF-10 | Sistem mengizinkan edit laporan. |
| RF-11 | Sistem mengizinkan hapus laporan. |
| RF-12 | Sistem menyediakan filter laporan berdasarkan tanggal. |
| RF-13 | Sistem menyediakan export Excel berdasarkan periode dan modalitas. |
| RF-14 | Sistem menyediakan pengelolaan profile user. |

## 22. Kebutuhan Non-Fungsional

| Kode | Kebutuhan |
| --- | --- |
| RNF-01 | Sistem berbasis web dan dapat diakses melalui browser. |
| RNF-02 | Sistem menggunakan autentikasi agar data hanya diakses pengguna berwenang. |
| RNF-03 | Sistem memakai database relasional untuk integritas data. |
| RNF-04 | Sistem memiliki tampilan responsif untuk desktop dan mobile. |
| RNF-05 | Sistem dapat dijalankan secara lokal atau melalui Docker. |
| RNF-06 | Sistem dapat menghasilkan laporan Excel. |
| RNF-07 | Sistem mudah dikembangkan karena memakai pola MVC Laravel. |

## 23. Contoh Use Case

### Use Case Login

| Elemen | Deskripsi |
| --- | --- |
| Aktor | Admin/petugas |
| Tujuan | Masuk ke aplikasi |
| Prasyarat | Akun sudah tersedia |
| Alur Utama | Buka login, isi email dan password, klik masuk, sistem redirect ke dashboard |
| Alur Alternatif | Jika password salah, sistem menampilkan pesan gagal |

### Use Case Input Laporan Reject

| Elemen | Deskripsi |
| --- | --- |
| Aktor | Admin/petugas |
| Tujuan | Mencatat laporan reject |
| Prasyarat | Pengguna sudah login |
| Alur Utama | Buka input, pilih reject, isi data, pilih faktor, simpan |
| Hasil | Laporan reject tersimpan dan tampil pada daftar reject |
| Validasi | Faktor penyebab wajib dipilih minimal satu |

### Use Case Export Excel

| Elemen | Deskripsi |
| --- | --- |
| Aktor | Admin/petugas |
| Tujuan | Mendapatkan laporan Excel |
| Prasyarat | Pengguna sudah login |
| Alur Utama | Buka pelaporan/export, pilih periode dan modalitas, klik Download Excel |
| Hasil | Browser mengunduh file `.xlsx` |

## 24. Contoh Black Box Testing

| No | Fitur | Skenario | Input | Output yang Diharapkan |
| --- | --- | --- | --- | --- |
| 1 | Login | Login berhasil | Email dan password valid | Masuk ke dashboard |
| 2 | Login | Login gagal | Password salah | Tetap di login dan tampil error |
| 3 | Input repeat | Simpan data valid | Data repeat lengkap | Data tersimpan dan redirect ke daftar repeat |
| 4 | Input repeat | Field wajib kosong | Tanggal/no RM kosong | Sistem menampilkan error validasi |
| 5 | Input reject | Simpan reject valid | Data lengkap dan faktor dipilih | Data tersimpan dan redirect ke daftar reject |
| 6 | Input reject | Faktor tidak dipilih | Data reject tanpa faktor | Sistem menampilkan error validasi |
| 7 | Filter laporan | Filter tanggal | Tanggal mulai dan selesai | Daftar hanya menampilkan data sesuai rentang |
| 8 | Edit laporan | Update data | Data baru valid | Data tersimpan dan berubah di detail |
| 9 | Hapus laporan | Hapus data | Klik hapus dan konfirmasi | Data terhapus dari daftar |
| 10 | Export Excel | Export periode | Bulan, tahun, modalitas | File Excel berhasil diunduh |

## 25. Catatan Maintainability

Beberapa catatan teknis untuk pengembangan lanjutan:

- Validasi laporan masih banyak ditulis langsung di `LaporanController`. Agar lebih rapi, bisa dipindahkan ke FormRequest khusus seperti `StoreLaporanRequest` dan `UpdateLaporanRequest`.
- Method khusus repeat/reject dan method gabungan memiliki beberapa duplikasi. Duplikasi dapat dikurangi dengan service layer, misalnya `LaporanService`.
- Route register/reset/verifikasi email tidak aktif, tetapi view/controller/test bawaan masih ada. Jika tidak dipakai, test perlu disesuaikan atau file yang tidak digunakan dapat dibersihkan.
- Tabel `jenis_insiden` dan relasi `detail_insiden_laporan` sudah tersedia, tetapi UI saat ini lebih memakai boolean `kesalahan_label` dan `insiden_reaksi_obat_kontras`. Perlu diputuskan apakah ingin memakai tabel insiden dinamis atau field boolean tetap.
- Dashboard sudah menghitung data dengan query Eloquent. Jika data sangat besar, dapat ditingkatkan dengan caching atau query agregasi yang lebih spesifik.
- README masih bawaan Laravel. Untuk repository final skripsi, sebaiknya README dibuat spesifik RR-Track.

## 26. Kesimpulan Teknis

RR-Track adalah aplikasi web Laravel untuk pencatatan dan pelaporan repeat/reject radiologi. Struktur aplikasinya sudah mengikuti pola MVC: route mengarahkan request ke controller, controller berinteraksi dengan model Eloquent, model terhubung ke database relasional, lalu hasilnya ditampilkan melalui Blade.

Secara skripsi, aplikasi ini kuat untuk dibahas sebagai sistem informasi monitoring mutu radiologi karena memiliki:

- Autentikasi pengguna.
- Master data pemeriksaan.
- Transaksi laporan repeat/reject.
- Relasi database yang jelas.
- Dashboard statistik.
- Export laporan Excel.
- Dokumentasi tampilan.
- Setup lokal dan Docker.

Dokumen ini dapat menjadi dasar deskripsi sistem, analisis kebutuhan, perancangan database, implementasi, dan pengujian pada laporan skripsi.
