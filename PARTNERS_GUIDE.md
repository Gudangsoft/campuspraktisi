# Panduan Fitur Mitra (Partners)

## Deskripsi
Fitur Mitra memungkinkan admin untuk mengelola dan menampilkan logo mitra/partner institusi seperti perusahaan, organisasi, atau lembaga yang bekerja sama dengan kampus. Logo ditampilkan dalam grid yang responsif dengan efek hover yang menarik.

## Fitur Utama

### Admin Panel
1. **CRUD Management** (`/admin/partners`)
   - Tambah, edit, dan hapus mitra
   - Upload logo dengan preview
   - Drag & drop untuk reorder logo
   - Toggle aktif/non-aktif per mitra

2. **Data Mitra**
   - Nama mitra (wajib)
   - Logo (wajib, image upload)
   - Website (opsional, dengan validasi URL)
   - Deskripsi (opsional)
   - Status aktif/non-aktif
   - Urutan tampilan (auto + manual reorder)

3. **Toggle Section**
   - ON/OFF untuk menampilkan/menyembunyikan seluruh section
   - Pengaturan judul section
   - Pengaturan subtitle section

### Frontend Display
1. **Grid Layout**
   - Responsive grid (6 kolom mobile, 4 tablet, 3-6 desktop)
   - Logo dalam card putih dengan shadow
   - Efek grayscale → color on hover
   - Hover effect: translate up + shadow lebih besar

2. **Logo Styling**
   - Logo grayscale default (70% opacity)
   - Full color on hover (100% opacity)
   - Max height: 80px (desktop), 60px (tablet), 50px (mobile)
   - Object-fit: contain (maintain aspect ratio)

3. **Clickable Links**
   - Logo clickable jika website URL tersedia
   - Open in new tab
   - Rel="noopener noreferrer" untuk keamanan

## Cara Penggunaan

### Menambah Mitra Baru

1. Login ke Admin Panel
2. Buka menu **Mitra** di sidebar
3. Klik tombol **Tambah Mitra**
4. Isi form:
   - **Nama Mitra**: Nama lengkap perusahaan/institusi
   - **Logo**: Upload file image (JPG, PNG, SVG max 2MB)
     - Rekomendasi: PNG transparan
     - Ukuran ideal: 200x100px atau rasio 2:1
     - Resolusi tinggi untuk tampilan jernih
   - **Website**: URL lengkap (https://...) - opsional
   - **Deskripsi**: Info singkat tentang mitra - opsional
   - **Tampilkan di website**: Centang untuk aktifkan
5. Klik **Simpan**

### Edit Mitra

1. Di halaman list Mitra
2. Klik tombol **Edit** pada card mitra
3. Update informasi yang diperlukan
4. Upload logo baru jika ingin mengganti (kosongkan jika tidak)
5. Klik **Update**

### Menghapus Mitra

1. Di halaman list Mitra
2. Klik tombol **Hapus** pada card mitra
3. Konfirmasi penghapusan
4. Logo akan otomatis terhapus dari storage

### Reorder Logo

1. Di halaman list Mitra
2. Drag icon grip (☰☰) pada bagian atas card
3. Geser card ke posisi yang diinginkan
4. Order akan tersimpan otomatis via AJAX
5. Alert success muncul jika berhasil

### Pengaturan Section

1. Di halaman Mitra, bagian atas terdapat card **Pengaturan Section Mitra**
2. Toggle switch untuk ON/OFF section
3. Atur judul section (default: "Mitra Kami")
4. Atur subtitle (default: "Institusi dan Perusahaan yang Bekerja Sama dengan Kami")
5. Klik **Simpan Pengaturan**

## Tips & Best Practices

### Logo Guidelines
- **Format File**: PNG dengan background transparan (recommended)
- **Ukuran**: 200x100px atau rasio 2:1
- **Resolusi**: 72-150 DPI (retina-ready)
- **Warna**: Logo berwarna (akan di-grayscale otomatis, full color on hover)
- **File Size**: Max 2MB (lebih kecil lebih baik untuk performance)

### Desain Logo
- Logo harus jelas dan mudah dibaca
- Hindari logo yang terlalu kompleks
- Pastikan logo terlihat baik pada background putih
- Test logo dalam ukuran kecil (thumbnail)
- Konsistensi style antar logo (jika memungkinkan)

### Urutan Tampilan
- Urutkan berdasarkan tingkat kemitraan (platinum, gold, silver)
- Atau alfabetis
- Atau berdasarkan bidang kerjasama
- Gunakan drag & drop untuk fleksibilitas

### Performance
- Kompres logo sebelum upload (TinyPNG, ImageOptim, dll)
- Hindari upload logo resolusi sangat tinggi
- Batch upload jika ada banyak mitra

## Struktur Database

### Table: partners

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string(255) | Nama mitra |
| logo | string(255) | Path file logo |
| website | string(255) | URL website (nullable) |
| description | text | Deskripsi mitra (nullable) |
| is_active | boolean | Status aktif |
| order | integer | Urutan tampilan |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu update terakhir |

### Settings

| Key | Default Value | Description |
|-----|---------------|-------------|
| partners_section_enabled | '1' | Toggle section (1=aktif, 0=non-aktif) |
| partners_title | 'Mitra Kami' | Judul section |
| partners_subtitle | 'Institusi dan Perusahaan...' | Subtitle section |

## File-file Terkait

### Backend
- **Model**: `app/Models/Partner.php`
- **Controller**: `app/Http/Controllers/Admin/PartnerController.php`
- **Migration**: `database/migrations/2025_11_09_235959_create_partners_table.php`
- **Seeder**: `database/seeders/PartnerSeeder.php` (optional)

### Frontend
- **Admin Index**: `resources/views/admin/partners/index.blade.php`
- **Admin Create**: `resources/views/admin/partners/create.blade.php`
- **Admin Edit**: `resources/views/admin/partners/edit.blade.php`
- **Component**: `resources/views/components/partners.blade.php`

### Routes
```php
// Admin routes (dalam middleware auth)
POST   /admin/partners/update-settings     - Update settings section
POST   /admin/partners/reorder              - Reorder logo
GET    /admin/partners                      - List semua mitra
GET    /admin/partners/create               - Form tambah mitra
POST   /admin/partners                      - Simpan mitra baru
GET    /admin/partners/{id}/edit            - Form edit mitra
PUT    /admin/partners/{id}                 - Update mitra
DELETE /admin/partners/{id}                 - Hapus mitra
```

### Storage
- Logo disimpan di: `storage/app/public/partners/`
- Accessible via: `public/storage/partners/`

## Scopes pada Model

```php
// Mitra aktif saja
Partner::active()->get();

// Mitra terurut by order
Partner::ordered()->get();

// Kombinasi
Partner::active()->ordered()->get();
```

## Frontend Component Usage

Di `home.blade.php`:
```blade
@include('components.partners')
```

Component otomatis:
- Load mitra aktif
- Check setting enabled
- Apply ordering
- Render grid responsif

## Troubleshooting

### Logo Tidak Muncul
- Pastikan symlink storage sudah dibuat: `php artisan storage:link`
- Check permission folder `storage/app/public/partners`
- Pastikan file logo ter-upload dengan benar

### Section Tidak Tampil di Frontend
- Check setting `partners_section_enabled` = '1'
- Pastikan ada minimal 1 mitra dengan `is_active` = true
- Clear cache: `php artisan view:clear`

### Upload Logo Gagal
- Check max upload size di `php.ini` (upload_max_filesize, post_max_size)
- Check permission folder storage
- Pastikan format file valid (jpeg, png, jpg, gif, svg)
- Pastikan file size < 2MB

### Reorder Tidak Berfungsi
- Check JavaScript console untuk error
- Pastikan Sortable.js ter-load
- Check CSRF token valid
- Check route `/admin/partners/reorder` accessible

### Logo Terlalu Besar/Kecil
- Adjust CSS max-height di component
- Kompres logo source file
- Check aspect ratio logo (rekomendasi 2:1)

## Contoh Implementasi

### Menampilkan Jumlah Mitra di Dashboard
```php
$totalPartners = Partner::count();
$activePartners = Partner::active()->count();
```

### Filter Mitra by Keyword (untuk Search)
```php
Partner::where('name', 'like', '%' . $keyword . '%')
       ->orWhere('description', 'like', '%' . $keyword . '%')
       ->get();
```

### Custom Order Logic
```php
// Order by name alphabetically
Partner::active()->orderBy('name', 'asc')->get();

// Order by created date (newest first)
Partner::active()->latest()->get();
```

## Pengembangan Lanjutan

Fitur yang bisa ditambahkan:
1. **Kategori Mitra**
   - Platinum, Gold, Silver partners
   - Filter by kategori

2. **Statistik**
   - Click tracking per logo
   - View count

3. **Multi-logo**
   - Upload multiple logo versions
   - Dark/light mode logo

4. **Advanced Layout**
   - Slider/carousel view
   - Grid dengan logo size berbeda

5. **Integration**
   - Auto-import from API
   - Sync dengan database eksternal

---

**Dibuat**: 9 November 2025  
**Versi**: 1.0  
**Status**: Production Ready
