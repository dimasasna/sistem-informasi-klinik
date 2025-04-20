# Sistem Informasi Klinik 🏥

Selamat datang di repositori **Sistem Informasi Klinik** — aplikasi berbasis web yang dirancang untuk membantu proses administrasi dan pelayanan di lingkungan klinik secara digital dan efisien.

## 🎯 Deskripsi Proyek
Aplikasi ini dibuat sebagai bagian dari tugas rumah (home test) yaitu tes kompetensi PT Inova Medika Solusindo untuk membangun sistem informasi klinik dengan fitur lengkap mulai dari pendaftaran pasien hingga pembayaran dan pelaporan.

---

## 🔐 Hak Akses Pengguna (Role-Based Access Control)
Aplikasi menerapkan sistem **Simple Role-Based Access Control (SRBAC)**, di mana setiap pengguna hanya bisa mengakses fitur sesuai dengan hak aksesnya.

### Jenis Role:
- **Admin**: Mengelola data master dan pengguna.
- **Petugas Pendaftaran**: Mendaftarkan pasien dan mencatat kunjungan.
- **Dokter**: Menambahkan tindakan medis dan resep obat.
- **Kasir**: Melihat dan memproses pembayaran tagihan pasien.

---

## 🗂️ Modul & Fitur Utama

### 1. Menu Master Data (CRUD)
Kelola data-data penting klinik melalui halaman CRUD berikut:
- **Wilayah**: Provinsi atau kabupaten sebagai referensi alamat pasien.
- **User**: Pengguna sistem sesuai peran (admin, dokter, dll).
- **Pegawai**: Data staf atau karyawan klinik.
- **Tindakan**: Layanan medis seperti pemeriksaan umum, laboratorium, dll.
- **Obat**: Daftar obat yang tersedia di klinik.

### 2. Transaksi Pendaftaran Pasien
Petugas pendaftaran dapat:
- Menambahkan pasien baru
- Mencatat jenis kunjungan dan keluhan
- Menyimpan riwayat kunjungan

### 3. Tindakan Medis & Resep Obat
Dokter dapat:
- Memilih tindakan medis
- Memberikan resep obat
- Semua data tercatat sebagai bagian dari kunjungan pasien

### 4. Pembayaran & Tagihan
Kasir dapat:
- Melihat rincian tagihan berdasarkan tindakan dan obat
- Memproses pembayaran pasien

### 5. Laporan Klinik
Visualisasi data berbentuk grafik sederhana untuk membantu analisis:
- Jumlah kunjungan per hari/bulan
- Tindakan medis yang paling banyak digunakan
- Obat yang paling sering diresepkan

---

## 💻 Teknologi yang Digunakan
- **Framework**: Laravel
- **Database**: PostgreSQL
- **Front-End**: FilamentPHP (Admin Panel)

---

## 🚀 Cara Menjalankan Proyek
1. Clone repositori ini:
   ```bash
   git clone https://github.com/dimasasna/sistem-informasi-klinik
   ```
2. Masuk ke direktori proyek:
   ```bash
   cd sistem-informasi-klinik
   ```
3. Install dependencies:
   ```bash
   composer install
   npm install && npm run dev
   ```
4. Buat file `.env` dan sesuaikan konfigurasi database.
5. Jalankan migrasi dan seeder:
   ```bash
   php artisan migrate --seed
   ```
5. Login dengan akun admin
   email: admin@example.com
   password: password123
   
6. Jalankan aplikasi:
   ```bash
   php artisan serve
   ```
