# 📄 Dokumentasi Tampilan Aplikasi RR-Track

**Aplikasi:** RR-Track (Repeat & Reject Tracking)  
**Deskripsi:** Sistem monitoring laporan Reject & Repeat pemeriksaan radiologi untuk RSUD Bangkalan  
**Framework:** Laravel + Tailwind CSS + Alpine.js + Chart.js  
**Tanggal Dokumentasi:** 9 Maret 2026

---

## 📑 Daftar Halaman / Tampilan

### 1. Halaman Welcome (`welcome.blade.php`)
- **Route:** `/`
- **Deskripsi:** Landing page default Laravel. Menampilkan logo Laravel dan tautan navigasi ke Login / Register / Dashboard.
- **Layout:** Standalone (tidak menggunakan layout app).
- **Catatan:** Halaman ini masih menggunakan template bawaan Laravel.

---

### 2. Halaman Login (`auth/login.blade.php`)
- **Route:** `/login`
- **Deskripsi:** Halaman login utama dengan desain **glassmorphism** di atas latar belakang gelap (`bg-slate-950`) dengan animated blob gradients.
- **Layout:** Standalone (custom full-page layout).
- **Komponen Tampilan:**
  - Logo RSUD Bangkalan + Logo RR-Track (bulat) di tengah
  - Logo Universitas Airlangga (kiri atas) & Logo Fakultas Vokasi (kanan atas) dalam kartu putih
  - Form login (Email + Password + Remember Me)
  - Tombol "Masuk ke Sistem" dengan gradient teal
  - Footer: "© 2026 Teknologi Radiologi Pencitraan - Universitas Airlangga"
  - Background: Animated blobs (teal/emerald) + noise overlay

---

### 3. Halaman Register (`auth/register.blade.php`)
- **Route:** `/register`
- **Deskripsi:** Form registrasi standar Laravel Breeze.
- **Layout:** Guest layout (`layouts/guest.blade.php`) - kartu putih di tengah halaman abu-abu.
- **Komponen:** Name, Email, Password, Confirm Password

---

### 4. Halaman Lupa Password (`auth/forgot-password.blade.php`)
- **Route:** `/forgot-password`
- **Layout:** Guest layout

---

### 5. Halaman Dashboard (`dashboard/index.blade.php`)
- **Route:** `/dashboard`
- **Deskripsi:** Halaman utama setelah login. Menampilkan ringkasan data dan grafik.
- **Layout:** App layout (`layouts/app.blade.php`)
- **Komponen Tampilan:**
  - **Welcome Banner:** Gradient teal (`from-teal-700 via-teal-600 to-teal-500`) dengan teks sambutan + logo RS
  - **Stats Cards (4 kartu):**
    - Total Laporan → ikon gradient `from-teal-400 to-teal-600`, badge `bg-teal-50 text-teal-600`
    - Total Repeat → ikon gradient `from-cyan-400 to-cyan-600`, badge `bg-cyan-50 text-cyan-600`
    - Total Reject → ikon gradient `from-red-400 to-red-600`, badge `bg-red-50 text-red-600`
    - Laporan Bulan Ini → ikon gradient `from-purple-400 to-purple-600`, badge `bg-purple-50 text-purple-600`
  - **Charts (2 kolom):**
    - Kiri: Bar chart bulanan X-Ray & CT-Scan (6 bulan terakhir)
    - Kanan: Pie/Doughnut chart faktor penyebab Reject (X-Ray & CT-Scan bulan ini)

---

### 6. Halaman Input / Tambah Laporan (`laporan/create.blade.php`)
- **Route:** `/laporan/create`
- **Deskripsi:** Form pembuatan laporan baru (Repeat atau Reject).
- **Layout:** App layout
- **Komponen Tampilan:**
  - **Breadcrumb:** Dashboard → Tambah Laporan
  - **Jenis Laporan (Radio button cards):**
    - Repeat → `peer-checked:border-teal-500 peer-checked:bg-teal-50`, ikon `bg-teal-500`
    - Reject → `peer-checked:border-red-500 peer-checked:bg-red-50`, ikon `bg-red-500`
  - **Card Header Jenis Laporan:** Gradient `from-indigo-500 to-purple-600`
  - **Card Header Data Laporan:** Dinamis (teal untuk Repeat, red untuk Reject)
  - **Card Header Data Pasien:** Gradient `from-green-50 to-emerald-50` (hijau)
  - **Card Header Insiden Khusus:** Gradient `from-orange-50 to-amber-50`
  - **Card Header Keterangan:** Gradient `from-purple-50 to-pink-50`
  - **Card Header Faktor Penyebab (Reject only):** Gradient `from-red-50 to-rose-50`
  - **Input fields:** `bg-slate-50 border-slate-200 rounded-xl`
  - **Tombol Submit:** Gradient teal atau red (sesuai jenis laporan)

---

### 7. Halaman Pelaporan (`laporan/pelaporan.blade.php`)
- **Route:** `/pelaporan`
- **Deskripsi:** Hub utama untuk export data dan navigasi ke daftar laporan Reject & Repeat.
- **Layout:** App layout
- **Komponen Tampilan:**
  - **Section Export Data:**
    - Header gradient `from-emerald-500 via-emerald-500 to-teal-600`
    - Form pilih Periode (Bulan, Tahun, Jenis Pemeriksaan) + Rentang Tanggal
    - Tombol Download Excel: `bg-gradient-to-r from-emerald-500 to-teal-600`
  - **Section Daftar Laporan Reject:**
    - Header gradient `from-red-500 to-rose-600`
    - Tabel dengan filter tanggal
    - Tombol aksi: Detail (hover red), Edit (hover yellow), Hapus (red)
    - Link "Lihat Semua" ke halaman index Reject
  - **Section Daftar Laporan Repeat:**
    - Header gradient `from-teal-500 to-teal-600`
    - Tabel dengan filter tanggal
    - Tombol aksi: Detail (hover teal), Edit (hover yellow), Hapus (red)
    - Link "Lihat Semua" ke halaman index Repeat

---

### 8. Daftar Laporan Repeat (`laporan/repeat/index.blade.php`)
- **Route:** `/laporan/repeat`
- **Deskripsi:** Tabel daftar semua laporan Repeat dengan pagination.
- **Layout:** App layout
- **Komponen Tampilan:**
  - **Mini Stats Cards (3):** Total Laporan (teal), Bulan Ini (green), Minggu Ini (purple)
  - **Tabel data** dengan kolom: No, Tanggal, Pasien, Pemeriksaan, Petugas, Aksi
  - **Badge modalitas:** `bg-cyan-100 text-cyan-700`
  - **Badge insiden:** Label (`bg-orange-100 text-orange-700`), Kontras (`bg-red-100 text-red-700`)
  - **Filter tanggal:** Focus `border-teal-500`
  - **Tombol Filter:** `bg-slate-800 text-white`

---

### 9. Detail Laporan Repeat (`laporan/repeat/show.blade.php`)
- **Route:** `/laporan/repeat/{id}`
- **Deskripsi:** Detail lengkap satu laporan Repeat.
- **Layout:** App layout (3 kolom: 2 konten + 1 sidebar)
- **Komponen Tampilan:**
  - **Card Info Laporan:** Header gradient `from-teal-50 to-cyan-50`, ikon `bg-teal-600`
  - **Card Info Pasien:** Header gradient `from-green-50 to-emerald-50`, ikon `bg-green-500`
  - **Card Insiden Khusus:** Header gradient `from-orange-50 to-amber-50`, ikon `bg-orange-500`
  - **Card Keterangan:** Header gradient `from-purple-50 to-pink-50`, ikon `bg-purple-500`
  - **Sidebar:** Petugas card + Timeline card (Dibuat/Diperbarui)
  - **Tombol Edit:** `bg-yellow-500`, **Tombol Hapus:** `bg-red-500`

---

### 10. Edit Laporan Repeat (`laporan/repeat/edit.blade.php`)
- **Route:** `/laporan/repeat/{id}/edit`
- **Deskripsi:** Form edit laporan Repeat.
- **Layout:** App layout (3 kolom: 2 form + 1 sidebar)
- **Komponen Tampilan:** Sama dengan Detail tapi dalam mode form editable.
  - Focus input warna sesuai section: teal (laporan), green (pasien), orange (insiden), purple (keterangan)

---

### 11. Daftar Laporan Reject (`laporan/reject/index.blade.php`)
- **Route:** `/laporan/reject`
- **Deskripsi:** Tabel daftar semua laporan Reject dengan pagination.
- **Layout:** App layout
- **Komponen Tampilan:**
  - **Mini Stats Cards (3):** Total Laporan (red), Bulan Ini (green), Minggu Ini (purple)
  - **Filter tanggal:** Focus `border-red-500`
  - **Ikon kalender tabel:** `bg-red-100 text-red-600`
  - Selebihnya mirip dengan index Repeat.

---

### 12. Detail Laporan Reject (`laporan/reject/show.blade.php`)
- **Route:** `/laporan/reject/{id}`
- **Deskripsi:** Detail lengkap satu laporan Reject.
- **Layout:** App layout (4 kolom: 3 konten + 1 sidebar)
- **Komponen Tampilan:**
  - **Header besar:** Gradient `from-red-500 via-red-600 to-rose-500` dengan info pasien
  - **Card Data Pemeriksaan:** Ikon `bg-red-100`
  - **Card Faktor Penyebab Reject:** Tags `bg-gradient-to-r from-red-50 to-rose-50 border-red-200 text-red-700`
  - **Card Insiden Khusus:** Aktif = `bg-yellow-100 border-yellow-300`, Tidak = `bg-slate-50`
  - **Card Keterangan:** Ikon `bg-purple-100`

---

### 13. Edit Laporan Reject (`laporan/reject/edit.blade.php`)
- **Route:** `/laporan/reject/{id}/edit`
- **Deskripsi:** Form edit laporan Reject.

---

### 14. Halaman Export (`laporan/export.blade.php`)
- **Route:** `/laporan/export`
- **Deskripsi:** Form konfigurasi export data ke Excel.
- **Layout:** App layout (max-w-2xl centered)
- **Komponen Tampilan:**
  - Header gradient `from-emerald-500 via-emerald-500 to-teal-600`
  - Step indicators dengan `bg-emerald-100 text-emerald-700`
  - Tombol Download: `from-emerald-500 to-teal-600`

---

### 15. Halaman Profile (`profile/edit.blade.php`)
- **Route:** `/profile`
- **Deskripsi:** Pengaturan profil user (Update Info, Update Password, Delete Account)

---

## 🧭 Navigasi

### Navbar (`layouts/navigation.blade.php`)
- **Background:** `bg-white border-b border-gray-100`
- **Logo:** Gambar `LogoRsudBangkalan.jpg` + teks "RR-Track" (`font-bold text-xl text-teal-700`)
- **Menu aktif:** `border-teal-500 text-gray-900`
- **Menu tidak aktif:** `border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300`
- **Responsive (mobile):** Menu aktif `border-teal-500 text-teal-700 bg-teal-50`
- **Dropdown user:** Nama user + chevron → tombol Logout

### Modal Logout
- **Backdrop:** `bg-slate-900/60 backdrop-blur-sm`
- **Card:** `bg-white rounded-2xl shadow-2xl`
- **Dekorasi atas:** `h-1.5 bg-gradient-to-r from-red-400 via-red-500 to-rose-500`
- **Ikon:** Lingkaran `bg-gradient-to-br from-red-400 to-red-500`
- **Tombol Batal:** `bg-slate-100 text-slate-700`
- **Tombol Logout:** `bg-gradient-to-r from-red-500 to-rose-500`

---

## 🎨 Palet Warna

### Warna Utama (Primary / Brand)

| Nama Warna | Kode Tailwind | Hex (Approx.) | Penggunaan |
|------------|---------------|----------------|------------|
| **Teal 50** | `teal-50` / `primary-50` | `#f0fdfa` | Background highlight ringan |
| **Teal 100** | `teal-100` / `primary-100` | `#ccfbf1` | Background badge, hover state |
| **Teal 200** | `teal-200` / `primary-200` | `#99f6e4` | Border aktif |
| **Teal 300** | `teal-300` / `primary-300` | `#5eead4` | Hover border |
| **Teal 400** | `teal-400` / `primary-400` | `#2dd4bf` | Gradient start, ikon |
| **Teal 500** | `teal-500` / `primary-500` | `#14b8a6` | **Warna utama**, tombol, header, focus ring |
| **Teal 600** | `teal-600` / `primary-600` | `#0d9488` | Gradient end, hover state |
| **Teal 700** | `teal-700` / `primary-700` | `#0f766e` | Teks logo navbar, gradient gelap |
| **Teal 800** | `teal-800` / `primary-800` | `#115e59` | Overlay gelap |
| **Teal 900** | `teal-900` / `primary-900` | `#134e4a` | Aksen paling gelap |

> **Catatan:** Di halaman login, warna ini didefinisikan sebagai `brand-*`, dan di layout utama sebagai `primary-*`. Keduanya menggunakan skala warna teal yang sama.

### Warna Semantik

| Fungsi | Warna Tailwind | Penggunaan |
|--------|---------------|------------|
| **Reject / Error** | `red-400 → red-600`, `rose-500 → rose-600` | Header Reject, badge error, tombol hapus, validasi form |
| **Repeat / Info** | `teal-400 → teal-600`, `cyan-400 → cyan-600` | Header Repeat, badge modalitas, stats card |
| **Success / Pasien** | `green-400 → green-600`, `emerald-500 → emerald-600` | Section data pasien, export, action berhasil |
| **Warning / Insiden** | `orange-400 → orange-600`, `amber-50` | Section insiden khusus, badge label error |
| **Info Tambahan** | `purple-400 → purple-600`, `pink-50` | Section keterangan, stats "Bulan Ini" |
| **Netral / Chart** | `indigo-400 → indigo-600` | Section jenis laporan, chart CT-Scan |
| **Netral** | `slate-50 → slate-950` | Background utama, teks, border, input background |

### Warna Background Halaman

| Halaman | Background |
|---------|-----------|
| Layout App (semua halaman utama) | `bg-gray-100` |
| Layout Guest (register, dll.) | `bg-gray-100` |
| Login | `bg-slate-950` (gelap) |
| Welcome | `bg-[#FDFDFC]` (hampir putih) |

### Warna Card / Section Headers (Gradient)

| Section | Gradient |
|---------|---------|
| Welcome Banner (Dashboard) | `from-teal-700 via-teal-600 to-teal-500` |
| Jenis Laporan | `from-indigo-500 to-purple-600` |
| Data Laporan (Repeat) | `from-teal-500 to-teal-600` |
| Data Laporan (Reject) | `from-red-500 to-red-600` |
| Data Pasien | `from-green-50 to-emerald-50` |
| Insiden Khusus | `from-orange-50 to-amber-50` |
| Keterangan | `from-purple-50 to-pink-50` |
| Export Data | `from-emerald-500 via-emerald-500 to-teal-600` |
| Daftar Reject | `from-red-500 to-rose-600` |
| Daftar Repeat | `from-teal-500 to-teal-600` |
| Header Detail Reject | `from-red-500 via-red-600 to-rose-500` |
| Logout Modal Bar | `from-red-400 via-red-500 to-rose-500` |
| Tombol Login | `from-brand-500 to-brand-600` |

### Warna Chart (Dashboard)

| Chart | Warna |
|-------|-------|
| Bar X-Ray (Repeat) | `rgba(59, 130, 246, 0.8)` — Blue |
| Bar X-Ray (Reject) | `rgba(239, 68, 68, 0.8)` — Red |
| Bar CT-Scan (Repeat) | `rgba(99, 102, 241, 0.8)` — Indigo |
| Bar CT-Scan (Reject) | `rgba(236, 72, 153, 0.8)` — Pink |
| Bar Global (Repeat) | `rgba(6, 182, 212, 0.8)` — Cyan |
| Bar Global (Reject) | `rgba(244, 63, 94, 0.8)` — Rose |
| Doughnut Jenis (Repeat) | `rgba(6, 182, 212, 0.9)` — Cyan |
| Doughnut Jenis (Reject) | `rgba(244, 63, 94, 0.9)` — Rose |
| Doughnut Faktor | Teal, Amber, Purple, Cyan |

---

## 🔤 Font

### Font Utama

| Halaman | Font | Sumber | Variasi (Weight) |
|---------|------|--------|-------------------|
| **Semua halaman utama** (Dashboard, Laporan, dll.) | **Figtree** | Google Fonts via Bunny CDN | 400 (Regular), 500 (Medium), 600 (Semibold) |
| **Halaman Login** | **Outfit** | Google Fonts via Bunny CDN | 300 (Light), 400 (Regular), 500 (Medium), 600 (Semibold), 700 (Bold) |
| **Halaman Welcome** | **Instrument Sans** | Google Fonts via Bunny CDN | 400, 500, 600 |

### Konfigurasi Tailwind

```javascript
// tailwind.config.js
fontFamily: {
    sans: ['Figtree', ...defaultTheme.fontFamily.sans],
}
```

```javascript
// Layout app.blade.php (CDN config)
fontFamily: {
    sans: ['Figtree', 'sans-serif'],
}
```

```javascript
// Login page (CDN config)
fontFamily: {
    sans: ['Outfit', 'sans-serif'],
}
```

### Icon Font

| Library | Versi | Penggunaan |
|---------|-------|-----------|
| **Font Awesome 6** | 6.5.1 (CDN) | Ikon di seluruh aplikasi utama (layout app) |
| **Font Awesome 6** | 6.4.0 (CDN) | Ikon di halaman Login |

### Ukuran Teks yang Digunakan

| Tailwind Class | Ukuran | Penggunaan |
|---------------|--------|-----------|
| `text-xs` | 0.75rem / 12px | Badge, label kecil, timestamp |
| `text-sm` | 0.875rem / 14px | Label form, teks deskripsi, navigasi |
| `text-base` | 1rem / 16px | Body text (default) |
| `text-lg` | 1.125rem / 18px | Heading section card |
| `text-xl` | 1.25rem / 20px | Sub heading, logo navbar |
| `text-2xl` | 1.5rem / 24px | Page heading, angka stats card |
| `text-3xl` | 1.875rem / 30px | Angka besar stats, welcome title |
| `text-[13px]` | 13px | Welcome page body text |

### Font Weight yang Digunakan

| Tailwind Class | Weight | Penggunaan |
|---------------|--------|-----------|
| `font-normal` | 400 | Body text default |
| `font-medium` | 500 | Label, nav link, deskripsi |
| `font-semibold` | 600 | Heading card, badge, tombol |
| `font-bold` | 700 | Heading utama, stats angka, logo text |

---

## 🧩 Komponen UI Umum

### Kartu (Card)
- **Border radius:** `rounded-2xl` (1rem)
- **Border:** `border border-slate-100`
- **Shadow:** `shadow-sm` (normal), `hover:shadow-xl` (hover)
- **Background:** `bg-white`

### Input Field
- **Background:** `bg-slate-50`
- **Border:** `border border-slate-200`
- **Border radius:** `rounded-xl` (0.75rem)
- **Padding:** `py-3 px-4` atau `py-3 pl-12 pr-4` (dengan ikon)
- **Focus:** `focus:border-{color}-500 focus:bg-white`

### Tombol Utama
- **Border radius:** `rounded-xl`
- **Padding:** `px-6 py-3`
- **Style:** Gradient background + shadow
- **Hover:** Gradient lebih gelap + shadow lebih besar + `hover:-translate-y-0.5`

### Badge / Tag
- **Border radius:** `rounded-full`
- **Padding:** `px-2 py-0.5` atau `px-3 py-1`
- **Font:** `text-xs font-medium` atau `text-xs font-semibold`

### Tabel
- **Header:** `bg-slate-50`, text `text-xs font-semibold text-slate-500 uppercase tracking-wider`
- **Row hover:** `hover:bg-slate-50`
- **Divider:** `divide-y divide-slate-100`

### Modal
- **Backdrop:** `bg-slate-900/60 backdrop-blur-sm`
- **Card:** `bg-white rounded-2xl shadow-2xl`
- **Animasi:** Scale + translate + opacity transitions

---

## 📱 Responsivitas

Aplikasi menggunakan breakpoint Tailwind CSS standar:

| Breakpoint | Ukuran | Penggunaan |
|-----------|--------|-----------|
| `sm` | ≥ 640px | Navigasi desktop mulai tampil |
| `md` | ≥ 768px | Grid 2-3 kolom, form layout horizontal |
| `lg` | ≥ 1024px | Grid 4 kolom stats, sidebar layout |
| `xl` | ≥ 1280px | Layout 4 kolom detail Reject |

### Mobile Navigation
- Hamburger menu dengan animasi open/close
- Menu vertikal dengan `border-l-4` untuk indikator aktif
- Informasi user (nama + email) di bagian bawah menu

---

## 🛠 Library Pihak Ketiga

| Library | Versi | Penggunaan |
|---------|-------|-----------|
| **Tailwind CSS** | CDN (layout app) / Vite build (guest) | Styling utama |
| **Alpine.js** | 3.x (CDN) | Interaktivitas: toggle, modal, form dinamis |
| **Chart.js** | 3.9.1 (CDN) | Grafik bar dan doughnut di Dashboard |
| **Font Awesome** | 6.5.1 (CDN) | Ikon |
| **Bunny Fonts** | - | Font hosting (Figtree, Outfit, Instrument Sans) |

---

## 🖼 Aset Gambar

| File | Lokasi | Penggunaan |
|------|--------|-----------|
| `LogoRsudBangkalan.jpg` | `public/images/` | Favicon, navbar, login, dashboard banner |
| `LogoUnair.png` | `public/images/` | Halaman login (kiri atas) |
| `Logovokasi.jpg` | `public/images/` | Halaman login (kanan atas) |
| `logo.png` | `public/images/` | Logo RR-Track bulat di halaman login |

---

## 🎯 Ringkasan Tema Visual

| Aspek | Detail |
|-------|--------|
| **Gaya Desain** | Modern, clean, card-based UI dengan gradient headers |
| **Warna Dominan** | Teal (#14b8a6) sebagai warna utama / brand |
| **Skema Warna** | Light mode dengan background `gray-100`, exception halaman login (dark) |
| **Border Radius** | Besar (`rounded-2xl`, `rounded-xl`) untuk kesan modern |
| **Shadows** | Subtle shadows (`shadow-sm`) dengan hover elevasi (`shadow-xl`) |
| **Transitions** | Smooth transitions (`duration-150` s/d `duration-300`) pada hover & focus |
| **Font Utama** | Figtree (sans-serif) - modern, clean, geometric |
| **Ikon** | Font Awesome 6 - digunakan secara konsisten di seluruh UI |
| **Interaktivitas** | Alpine.js untuk toggle, modal, form dinamis |
