# Prayer Time & Quran Verse App

Aplikasi web berbasis **Laravel** yang menampilkan jadwal sholat 5 waktu secara real-time berdasarkan kota dan negara yang dipilih, dilengkapi dengan ayat Al-Quran harian beserta terjemahan Bahasa Indonesia.

Dibuat sebagai tugas matakuliah **Integrasi Aplikasi Enterprise** dengan mengimplementasikan Public API pada aplikasi monolith sederhana.

---

## Fitur Utama

- **Jadwal Sholat Real-time** — Subuh, Dzuhur, Ashar, Maghrib, Isya berdasarkan kota yang dipilih
- **Ayat Al-Quran Harian** — Ayat beserta teks Arab dan terjemahan Indonesia, berganti otomatis setiap hari
- **Mendukung 40+ Negara** — Mencakup seluruh negara dengan populasi Muslim di Asia, Timur Tengah, Afrika, dan Eropa
- **Tanggal Hijriyah** — Ditampilkan otomatis bersama jadwal sholat
- **Highlight Waktu Berikutnya** — Menampilkan waktu sholat yang akan datang secara otomatis
- **Responsive** — Tampilan menyesuaikan di desktop maupun mobile

---

## Public API yang Digunakan

| API | Endpoint | Fungsi | API Key |
|-----|----------|--------|---------|
| [Aladhan API](https://aladhan.com/prayer-times-api) | `api.aladhan.com/v1/timingsByCity` | Jadwal waktu sholat | Tidak perlu |
| [Al-Quran Cloud API](https://alquran.cloud/api) | `api.alquran.cloud/v1/ayah/{n}/id.indonesian` | Ayat Al-Quran + terjemahan | Tidak perlu |

---

## Teknologi yang Digunakan

- **Framework** : Laravel 11
- **Bahasa** : PHP 8.2+
- **HTTP Client** : Guzzle HTTP (built-in Laravel)
- **Template Engine** : Blade
- **Frontend** : HTML, CSS (tanpa framework CSS)
- **Server Lokal** : XAMPP

---

## Cara Instalasi & Menjalankan

### Prasyarat
Pastikan sudah terinstall:
- PHP >= 8.2
- Composer
- Git

### Langkah Instalasi

**1. Clone repository ini**
```bash
git clone https://github.com/Dimasdwisuryo/Tugas1-PublicAPI-AplikasiPrayer.git
cd Tugas1-PublicAPI-AplikasiPrayer
```

**2. Install dependensi Laravel**
```bash
composer install
```

**3. Buat file environment**
```bash
copy .env.example .env
```

**4. Generate application key**
```bash
php artisan key:generate
```

**5. Set timezone ke WIB di `config/app.php`**
```php
'timezone' => 'Asia/Jakarta',
```

**6. Jalankan server**
```bash
php artisan serve
```

**7. Buka di browser**
```
http://localhost:8000
```

---

## Cara Penggunaan

1. **Pilih Negara** — Pilih negara dari dropdown yang tersedia (40+ negara Muslim)
2. **Ketik Nama Kota** — Masukkan nama kota sesuai contoh yang muncul otomatis
3. **Klik "Cari Jadwal Sholat"** — Aplikasi akan mengambil data dari API secara real-time
4. **Lihat Hasil** — Jadwal sholat 5 waktu, waktu sholat berikutnya, tanggal Hijriyah, dan ayat harian akan ditampilkan

### Contoh Kota yang Bisa Dicari

| Negara | Contoh Kota |
|--------|-------------|
| 🇮🇩 Indonesia | Surabaya, Jakarta, Bandung, Sidoarjo |
| 🇸🇦 Arab Saudi | Makkah, Madinah, Riyadh, Jeddah |
| 🇲🇾 Malaysia | Kuala Lumpur, Johor Bahru, Penang |
| 🇹🇷 Turki | Istanbul, Ankara, Izmir |
| 🇪🇬 Mesir | Cairo, Alexandria, Giza |
| 🇵🇰 Pakistan | Karachi, Lahore, Islamabad |

---

## Struktur Project

```
prayer-app/
├── app/
│   ├── Http/Controllers/
│   │   └── PrayerController.php   # Controller utama
│   ├── Providers/
│   │   └── AppServiceProvider.php
│   └── Services/
│       ├── AladhanService.php     # Integrasi Aladhan API
│       └── QuranService.php       # Integrasi Al-Quran API
├── public/
│   ├── css/
│   │   └── app.css                # Styling aplikasi
│   └── favicon.png
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php          # Layout utama
│   └── prayer/
│       ├── index.blade.php        # Halaman form
│       └── result.blade.php       # Halaman hasil
├── routes/
│   └── web.php                    # Routing aplikasi
└── .env                           # Konfigurasi environment
```

---

## Alur Kerja Aplikasi

```
User input kota & negara
        ↓
PrayerController@show
        ↓
AladhanService::getTimings()  →  GET api.aladhan.com/v1/timingsByCity
QuranService::getDailyAyah()  →  GET api.alquran.cloud/v1/ayah/{n}/id.indonesian
        ↓
Render view prayer.result
        ↓
Tampil ke user
```

---

Project ini dibuat untuk memenuhi tugas mata kuliah Integrasi Aplikasi Enterprise akademik.
