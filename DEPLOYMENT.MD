# PROMPT LENGKAP PEMBANGUNAN SISTEM KATHAHEALTHY

## Nama Aplikasi

**KathaHealthy**

## Tagline

**Smart Blood Pressure Monitoring System**

---

# PERAN AI

Bertindak sebagai **Senior Software Architect**, **Senior UI/UX Designer**, **Senior Backend Developer**, **Senior Frontend Developer**, **Senior Database Architect**, **Senior Security Engineer**, **Senior QA Engineer**, dan **Senior DevOps Engineer**.

Bangun sistem yang siap digunakan di lingkungan produksi (Production Ready), bukan sekadar demo.

---

# TUJUAN SISTEM

Bangun aplikasi web profesional yang **khusus untuk pencatatan, monitoring, analisis, dan visualisasi tekanan darah (tensi) pasien**.

Sistem harus:

* Cepat digunakan.
* Ringan.
* Modern.
* Responsif.
* Mudah dipelajari.
* Aman.
* Memiliki mekanisme Self-Healing.
* Menggunakan konsep **Single Page Dashboard**.
* Seluruh aktivitas dilakukan tanpa reload halaman.

Fokus utama adalah **monitoring tekanan darah**, bukan EMR lengkap.

---

# TEKNOLOGI WAJIB

## Backend

* PHP Native 8.3
* MVC Architecture
* PDO
* MySQL / MariaDB
* Repository Pattern
* Service Layer
* Router Native
* Helper
* Middleware
* Session
* CSRF Protection
* UUID
* JSON API Internal
* AJAX Response

DILARANG menggunakan:

* Laravel
* CodeIgniter
* Symfony
* Framework lain

---

## Frontend

Gunakan FULL CDN

* TailwindCSS
* AlpineJS
* jQuery
* DataTables
* ApexCharts
* SweetAlert2
* Toastify
* Font Awesome
* Flatpickr
* DayJS
* TomSelect
* LoadingOverlay
* html2canvas
* jsPDF
* SheetJS
* Animate.css
* AOS

---

# REALTIME

Gunakan

AJAX Polling

Bukan Websocket.

Polling otomatis

* Dashboard
* Grafik
* Statistik
* Riwayat
* Notifikasi

Interval default

5 detik.

Gunakan adaptive polling.

---

# KONSEP SISTEM

Target penggunaan

Cari Pasien

↓

Input Tensi

↓

Klik Simpan

↓

Grafik langsung berubah

↓

Riwayat langsung bertambah

↓

Statistik berubah

↓

Analisis muncul

↓

Notifikasi tampil

Semua tanpa reload halaman.

---

# USER ROLE

* Super Admin
* Administrator
* Dokter
* Perawat
* Operator
* Pasien

Gunakan RBAC lengkap.

Permission

* View
* Create
* Update
* Delete
* Export
* Print

---

# DASHBOARD

Single Page Dashboard

Layout

HEADER

SIDEBAR

CONTENT

RIGHT PANEL

FOOTER

---

# HEADER

Logo

Nama Klinik

Search Pasien

Notification

Dark Mode

Profile

Logout

---

# SIDEBAR

Dashboard

Pasien

Pemeriksaan

Grafik

Riwayat

Laporan

Pengaturan

Log Sistem

Health Check

---

# DASHBOARD

Widget

Total Pasien

Total Pemeriksaan

Hari Ini

Normal

Hipotensi

Elevated

Hipertensi Stage 1

Hipertensi Stage 2

Krisis Hipertensi

Pasien Baru

Laki-laki

Perempuan

Semua realtime.

---

# AREA IDENTITAS PASIEN

Cari menggunakan

* Nama
* Nomor RM
* NIK
* QR Code

Menampilkan

Foto

Nama

Nomor RM

Umur

Jenis Kelamin

Alamat

No HP

Golongan Darah

Tekanan Terakhir

Tanggal Pemeriksaan Terakhir

Status Terakhir

Health Score

---

# FORM PEMERIKSAAN

Input

Tanggal

Jam

Sistolik

Diastolik

Heart Rate

Berat Badan

Tinggi Badan

Catatan

Petugas

Tombol

Simpan

Reset

Cetak

---

# PERHITUNGAN OTOMATIS

Saat angka diketik

langsung hitung

Kategori

Hipotensi

Normal

Elevated

Hipertensi Stage 1

Hipertensi Stage 2

Hypertensive Crisis

MAP

Pulse Pressure

BMI

Status

Health Score

Trend

Tanpa klik tombol.

---

# GRAFIK

Gunakan ApexCharts.

Grafik

Tekanan Darah

Heart Rate

BMI

Berat Badan

Filter

Hari

Minggu

Bulan

Tahun

Custom

Realtime.

---

# RIWAYAT

Gunakan DataTables.

Fitur

Search

Filter

Sorting

Pagination

Export Excel

Export PDF

Print

Copy

Responsive

Auto Refresh

Highlight Data Baru

---

# TIMELINE PASIEN

Tampilkan histori pemeriksaan.

Tanggal

Tekanan

Status

Petugas

Catatan

---

# ANALISIS CERDAS

Sistem memberikan informasi otomatis.

Contoh

* Tekanan darah stabil.
* Tekanan meningkat dibanding minggu lalu.
* Risiko hipertensi meningkat.
* Pemeriksaan rutin disarankan.

---

# PERINGATAN

Jika

≥180 / ≥120

Muncul

KRISIS HIPERTENSI

Jika

<90 / <60

HIPOTENSI

Gunakan SweetAlert2.

---

# MASTER PASIEN

CRUD

Nomor RM

QR Code

NIK

Nama

TTL

Jenis Kelamin

Alamat

No HP

Golongan Darah

BPJS

Foto

Status

---

# LAPORAN

Laporan

Harian

Bulanan

Tahunan

Per Pasien

Per Dokter

Per Petugas

Export

Excel

PDF

Print

---

# SELF HEALING SYSTEM

Bangun sistem dengan konsep **Self Healing**, **Self Monitoring**, dan **Auto Recovery**.

## Auto Error Handler

Tangani

* PHP Error
* Exception
* Fatal Error
* AJAX Error
* JSON Error
* PDO Error
* Session Error

Semua masuk log.

---

## Database Recovery

Jika database gagal

Retry otomatis 3x.

Jika masih gagal

Masuk maintenance mode.

---

## AJAX Recovery

Retry otomatis.

Tidak boleh terjadi request bertumpuk.

---

## Auto Save

Draft otomatis setiap 10 detik.

Gunakan Local Storage.

Jika browser tertutup

Draft dipulihkan.

---

## Offline Mode

Jika internet putus

Simpan data ke Local Storage / IndexedDB.

Ketika online

Sinkron otomatis.

Gunakan UUID agar tidak terjadi duplikasi.

---

## Session Recovery

Jika session habis

Refresh session.

Jika gagal

Login ulang.

Kembali ke halaman sebelumnya.

---

## Cache Recovery

Jika cache rusak

Bangun ulang otomatis.

---

## File Recovery

Jika upload gagal

Rollback.

Gunakan gambar default jika file rusak.

---

## Log System

Folder

storage/logs

Isi

Tanggal

User

IP

Browser

URL

Controller

Method

Pesan

Stack Trace

Level

---

## Log Cleaner

Hapus log lama otomatis.

Arsipkan log penting.

---

# HEALTH CHECK

Halaman khusus administrator.

Menampilkan

Database

Storage

Uploads

Logs

Cache

Session

Polling

Disk

Memory

CPU

PHP

Extensions

Permission Folder

Semua dengan indikator

Hijau

Kuning

Merah

---

# KEAMANAN

Gunakan

* CSRF Token
* Prepared Statement
* XSS Filtering
* SQL Injection Protection
* Rate Limiter
* Login Attempt Limiter
* Password Hash
* Secure Session
* Secure Cookie
* UUID

---

# DATABASE

Gunakan

Foreign Key

Soft Delete

Created At

Updated At

Deleted At

UUID

Audit Trail

---

# STRUKTUR MVC

app/

Controllers

Models

Repositories

Services

Helpers

Traits

Libraries

Middleware

Views

Config

Routes

public/

assets

uploads

ajax

api

storage/

cache

logs

temp

backups

---

# UI/UX

Tema

Medical Dashboard

Dominasi

Putih

Emerald

Hijau

Biru

Abu-abu

Card

Rounded XL

Shadow

Modern

Responsive

Dark Mode

Light Mode

Loading Skeleton

Toast Notification

Animasi halus.

---

# STANDAR KODE

* PSR-12.
* Clean Code.
* SOLID Principle.
* DRY.
* KISS.
* Repository Pattern.
* Service Layer.
* Validasi Client & Server.
* Reusable Component.
* Modular.
* Mudah dikembangkan.
* Mudah dipelihara.
* Siap Production.

---

# TARGET HASIL

Hasil akhir harus berupa aplikasi profesional yang:

* Fokus pada pencatatan tekanan darah pasien.
* Cepat digunakan (input pemeriksaan <15 detik).
* Realtime menggunakan AJAX Polling.
* Stabil berkat Self-Healing System.
* Aman, modular, dan mudah dikembangkan.
* Siap diperluas di masa depan menjadi sistem EMR lengkap tanpa mengubah arsitektur dasar aplikasi.
