# Panduan Fitur Kalender Akademik

## Deskripsi
Fitur Kalender Akademik memungkinkan admin untuk mengelola jadwal kegiatan akademik kampus seperti perkuliahan, ujian, libur, dan pendaftaran. Kalender ditampilkan secara publik dengan visualisasi timeline yang menarik dan mudah dibaca.

## Fitur Utama

### Admin Panel
1. **CRUD Management**
   - Tambah, edit, dan hapus event kalender
   - Drag & drop untuk reordering event
   - Filter berdasarkan tahun akademik, semester, kategori, dan status
   - Pagination untuk list yang panjang

2. **Data Event**
   - Tahun Akademik (format: 2024/2025)
   - Semester (Ganjil/Genap)
   - Judul dan Deskripsi event
   - Tanggal mulai dan selesai (opsional untuk event multi-hari)
   - Kategori event (Akademik, Ujian, Libur, Pendaftaran)
   - Warna kustom untuk setiap event
   - Status aktif/non-aktif
   - Urutan tampilan

3. **Kategori Event**
   - **Akademik** (🎓): Perkuliahan, orientasi, wisuda
   - **Ujian** (📝): UTS, UAS, ujian susulan
   - **Libur** (🏖️): Libur semester, hari libur nasional
   - **Pendaftaran** (📋): Daftar ulang, KRS, registrasi

### Frontend Display
1. **Timeline View**
   - Tampilan timeline yang intuitif
   - Visual marker dengan warna kustom setiap event
   - Status event (Sedang Berlangsung, Akan Datang, Sudah Lewat)
   - Badge tahun akademik, semester, dan kategori
   - Durasi event untuk event multi-hari

2. **Filter Options**
   - Filter by tahun akademik
   - Filter by semester
   - Filter by kategori
   - Reset filter untuk lihat semua

3. **Responsive Design**
   - Desktop: Timeline penuh dengan visual markers
   - Mobile: Timeline compact dengan touch-friendly

## Cara Penggunaan

### Menambah Event Baru

1. Login ke Admin Panel
2. Buka menu **Kalender Akademik** di sidebar
3. Klik tombol **Tambah Event**
4. Isi form:
   - **Tahun Akademik**: Format YYYY/YYYY (contoh: 2024/2025)
   - **Semester**: Pilih Ganjil atau Genap
   - **Judul Event**: Nama kegiatan (contoh: Ujian Tengah Semester)
   - **Deskripsi**: Detail kegiatan (opsional)
   - **Tanggal Mulai**: Tanggal dimulainya event
   - **Tanggal Selesai**: Tanggal berakhirnya event (kosongkan jika 1 hari)
   - **Kategori**: Pilih salah satu dari 4 kategori
   - **Warna**: Pilih warna untuk visual calendar
   - **Urutan**: Angka untuk urutan tampilan (opsional)
   - **Event Aktif**: Centang jika event akan ditampilkan di website
5. Klik **Simpan**

### Edit Event

1. Di halaman list Kalender Akademik
2. Klik tombol **Edit** (ikon pensil) pada event yang ingin diubah
3. Update informasi yang diperlukan
4. Klik **Update**

### Menghapus Event

1. Di halaman list Kalender Akademik
2. Klik tombol **Hapus** (ikon tempat sampah) pada event
3. Konfirmasi penghapusan

### Reorder Event

1. Di halaman list Kalender Akademik
2. Drag icon grip (☰) pada sisi kiri tabel
3. Geser event ke posisi yang diinginkan
4. Order akan tersimpan otomatis

## Tips & Best Practices

### Penggunaan Warna
- **Biru** (#3498db): Event akademik umum
- **Merah** (#e74c3c, #c0392b): Ujian dan deadline penting
- **Hijau** (#2ecc71, #27ae60): Libur dan event positif
- **Oranye** (#f39c12, #e67e22): Pendaftaran dan administrasi
- **Ungu** (#9b59b6): Event spesial seperti wisuda

### Format Tanggal
- Untuk event 1 hari: Isi tanggal mulai saja, kosongkan tanggal selesai
- Untuk event multi-hari: Isi tanggal mulai dan tanggal selesai
- Contoh: UTS biasanya 5-7 hari, isi kedua tanggal

### Penamaan Event
- Gunakan nama yang jelas dan konsisten
- Contoh baik: "Ujian Tengah Semester (UTS)", "Libur Semester Ganjil"
- Hindari singkatan yang ambigu

### Tahun Akademik
- Format standar: YYYY/YYYY (contoh: 2024/2025)
- Tahun akademik biasanya mulai bulan Agustus/September
- Semester Ganjil: Agustus - Desember
- Semester Genap: Februari - Juni

### Deskripsi Event
- Tambahkan detail penting seperti lokasi, persyaratan, atau catatan khusus
- Gunakan kalimat yang jelas dan informatif
- Contoh: "Pelaksanaan ujian akhir semester untuk semua mata kuliah. Mahasiswa wajib membawa kartu ujian."

## Struktur Database

### Table: academic_calendars

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| academic_year | string(20) | Tahun akademik (2024/2025) |
| semester | string(20) | Semester (Ganjil/Genap) |
| title | string(255) | Judul event |
| description | text | Deskripsi detail (nullable) |
| start_date | date | Tanggal mulai |
| end_date | date | Tanggal selesai (nullable) |
| category | string(50) | Kategori event |
| color | string(20) | Kode warna hex |
| is_active | boolean | Status aktif |
| order | integer | Urutan tampilan |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu update terakhir |

## File-file Terkait

### Backend
- **Model**: `app/Models/AcademicCalendar.php`
- **Controller**: `app/Http/Controllers/Admin/AcademicCalendarController.php`
- **Migration**: `database/migrations/2025_11_09_213639_create_academic_calendars_table.php`
- **Seeder**: `database/seeders/AcademicCalendarSeeder.php`

### Frontend
- **Admin Index**: `resources/views/admin/academic-calendar/index.blade.php`
- **Admin Create**: `resources/views/admin/academic-calendar/create.blade.php`
- **Admin Edit**: `resources/views/admin/academic-calendar/edit.blade.php`
- **Public Page**: `resources/views/frontend/academic-calendar.blade.php`
- **Component**: `resources/views/components/academic-calendar.blade.php`

### Routes
- Admin routes di `routes/web.php` (dalam admin middleware group)
- Public route: `/academic-calendar`

## API Endpoints (Admin)

```
GET    /admin/academic-calendar              - List semua events
GET    /admin/academic-calendar/create       - Form tambah event
POST   /admin/academic-calendar              - Simpan event baru
GET    /admin/academic-calendar/{id}/edit    - Form edit event
PUT    /admin/academic-calendar/{id}         - Update event
DELETE /admin/academic-calendar/{id}         - Hapus event
POST   /admin/academic-calendar/reorder      - Update urutan events
```

## Scopes pada Model

Model `AcademicCalendar` memiliki beberapa scope untuk query:

```php
// Event aktif saja
AcademicCalendar::active()->get();

// Filter by semester
AcademicCalendar::semester('Ganjil')->get();

// Filter by tahun akademik
AcademicCalendar::academicYear('2024/2025')->get();

// Filter by kategori
AcademicCalendar::category('exam')->get();

// Event yang akan datang
AcademicCalendar::upcoming()->get();

// Event yang sedang berlangsung
AcademicCalendar::current()->get();
```

## Helper Methods

```php
$event = AcademicCalendar::find(1);

// Check status event
$event->isOngoing();    // true jika sedang berlangsung
$event->isUpcoming();   // true jika akan datang
$event->hasPassed();    // true jika sudah lewat

// Get durasi
$event->getDurationDays();  // Jumlah hari event

// Get styling
$event->getCategoryBadgeClass();  // Bootstrap badge class
$event->getCategoryIcon();        // Font Awesome icon class
```

## Troubleshooting

### Event Tidak Muncul di Frontend
- Pastikan event diset **is_active = true**
- Periksa filter tahun akademik sudah sesuai
- Clear cache: `php artisan cache:clear`

### Warna Event Tidak Tampil
- Pastikan format warna hex valid (contoh: #3498db)
- Gunakan color picker di form untuk memastikan format benar

### Urutan Event Acak
- Gunakan fitur drag & drop untuk reorder
- Atau set field `order` secara manual

### Tanggal Invalid
- Format tanggal: YYYY-MM-DD
- Pastikan end_date >= start_date
- Gunakan datepicker untuk input yang akurat

## Pengembangan Lanjutan

Fitur yang bisa ditambahkan:
1. **Export Calendar**
   - Export to PDF
   - Export to iCal format (untuk sync dengan Google Calendar, Outlook, dll)

2. **Notifications**
   - Email reminder untuk event penting
   - Push notification untuk event hari ini

3. **Recurring Events**
   - Support untuk jadwal kuliah mingguan
   - Auto-generate event berulang

4. **Calendar View**
   - Tambah tampilan calendar grid (seperti Google Calendar)
   - Month view, week view, day view

5. **Integration**
   - Sync dengan sistem akademik
   - API untuk mobile app

6. **Advanced Filtering**
   - Filter by date range
   - Search by keyword
   - Save filter preferences

---

**Dibuat**: 9 November 2025  
**Versi**: 1.0  
**Status**: Production Ready
