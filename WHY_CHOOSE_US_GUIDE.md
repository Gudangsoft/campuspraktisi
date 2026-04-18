# Why Choose Us - Dynamic Feature Cards System

## Overview
Sistem dinamis untuk mengelola kartu fitur unggulan ("Why Choose Us") yang ditampilkan di halaman utama website. Admin dapat menambahkan, mengedit, menghapus, dan mengatur urutan kartu serta fitur-fiturnya tanpa coding.

## Features Implemented

### 1. Database Structure
- **Table: `why_choose_us`**
  - `id` - Primary key
  - `icon` - Icon Font Awesome (default: 'fa-star')
  - `title` - Judul utama card (required)
  - `subtitle` - Sub-judul (optional)
  - `icon_color` - Warna icon dalam format hex (default: '#4a5568')
  - `background_color` - Warna background card (default: '#ffffff')
  - `order` - Urutan tampilan (integer)
  - `is_active` - Status aktif/nonaktif (boolean)
  - `timestamps`

- **Table: `why_choose_us_features`**
  - `id` - Primary key
  - `why_choose_us_id` - Foreign key ke `why_choose_us` (cascade on delete)
  - `feature_text` - Teks fitur (required)
  - `icon` - Icon untuk fitur individual (optional)
  - `order` - Urutan fitur dalam card (integer)
  - `timestamps`

### 2. Models
- **WhyChooseUs** (`app/Models/WhyChooseUs.php`)
  - Relationship: `hasMany(WhyChooseUsFeature::class)` dengan ordering
  - Scopes: `active()`, `ordered()`
  - Casts: `is_active` as boolean, `order` as integer

- **WhyChooseUsFeature** (`app/Models/WhyChooseUsFeature.php`)
  - Relationship: `belongsTo(WhyChooseUs::class)`
  - Cast: `order` as integer

### 3. Admin Controller
**WhyChooseUsController** (`app/Http/Controllers/Admin/WhyChooseUsController.php`)

**Card Management:**
- `index()` - Menampilkan daftar card dengan drag-drop reordering
- `create()` - Form tambah card baru dengan live preview
- `store()` - Simpan card baru (auto-increment order)
- `edit($whyChooseUs)` - Form edit card dengan preview existing features
- `update($whyChooseUs)` - Update card
- `destroy($whyChooseUs)` - Hapus card (cascade delete features)
- `reorder()` - AJAX endpoint untuk update urutan card

**Feature Management:**
- `features($whyChooseUs)` - Halaman kelola fitur untuk satu card
- `storeFeature($whyChooseUs)` - Tambah fitur baru ke card
- `updateFeature($whyChooseUs, $feature)` - Update fitur
- `destroyFeature($whyChooseUs, $feature)` - Hapus fitur
- `reorderFeatures($whyChooseUs)` - AJAX endpoint untuk update urutan fitur

### 4. Admin Views

**Index View** (`resources/views/admin/why-choose-us/index.blade.php`)
- Grid 3-kolom dengan card preview
- Drag-drop reordering menggunakan Sortable.js
- Badge counter untuk jumlah fitur
- Preview 3 fitur pertama di setiap card
- Action buttons: Kelola Fitur, Edit, Hapus
- Status badge (Aktif/Nonaktif)
- Tips dan informasi helper

**Create View** (`resources/views/admin/why-choose-us/create.blade.php`)
- Form dengan live preview
- Input fields:
  - Judul card (required)
  - Subjudul (optional)
  - Icon selector dengan Font Awesome integration
  - Color pickers untuk icon dan background
  - Toggle is_active
- Real-time preview yang update saat user mengetik
- Link ke Font Awesome icon reference

**Edit View** (`resources/views/admin/why-choose-us/edit.blade.php`)
- Similar dengan create view
- Menampilkan existing features
- Pre-filled dengan data existing
- Link ke halaman kelola fitur
- Live preview dengan data existing

**Features View** (`resources/views/admin/why-choose-us/features.blade.php`)
- Header menampilkan info card parent
- Form quick-add untuk fitur baru
- List fitur dengan drag-drop reordering
- Inline edit untuk setiap fitur
- Delete confirmation
- Icon circle preview dari card parent

### 5. Frontend Component
**Component** (`resources/views/components/why-choose-us.blade.php`)
- Responsive 3-column layout (col-md-4)
- Gradient background section
- Hover effects:
  - Card lift animation (translateY)
  - Icon scale & rotate
  - Shadow enhancement
- Styling features:
  - Circular icon dengan shadow
  - Uppercase title dengan letter-spacing
  - Italic subtitle
  - Feature list dengan icon checks
  - Border-bottom separator antar features
- Mobile responsive dengan adjusted sizing

**Integration**: Included in `home.blade.php` between greeting dan featured news sections

### 6. Routes
```php
// Resource routes
Route::resource('why-choose-us', WhyChooseUsController::class);

// Additional routes
Route::post('why-choose-us/reorder', [WhyChooseUsController::class, 'reorder'])
    ->name('why-choose-us.reorder');
Route::get('why-choose-us/{whyChooseUs}/features', [WhyChooseUsController::class, 'features'])
    ->name('why-choose-us.features');
Route::post('why-choose-us/{whyChooseUs}/features', [WhyChooseUsController::class, 'storeFeature'])
    ->name('why-choose-us.features.store');
Route::put('why-choose-us/{whyChooseUs}/features/{feature}', [WhyChooseUsController::class, 'updateFeature'])
    ->name('why-choose-us.features.update');
Route::delete('why-choose-us/{whyChooseUs}/features/{feature}', [WhyChooseUsController::class, 'destroyFeature'])
    ->name('why-choose-us.features.destroy');
Route::post('why-choose-us/{whyChooseUs}/features/reorder', [WhyChooseUsController::class, 'reorderFeatures'])
    ->name('why-choose-us.features.reorder');
```

### 7. Admin Menu
Added to sidebar navigation (`resources/views/admin/layout.blade.php`):
```html
<a href="{{ route('admin.why-choose-us.index') }}">
    <i class="fas fa-star"></i>
    <span>Why Choose Us</span>
    <span class="badge bg-warning">{{ \App\Models\WhyChooseUs::count() }}</span>
</a>
```

### 8. Home Controller Integration
Updated `HomeController::index()` to load active cards:
```php
$whyChooseUs = \App\Models\WhyChooseUs::with('features')->active()->ordered()->get();
```

### 9. Initial Data Seeder
**WhyChooseUsSeeder** (`database/seeders/WhyChooseUsSeeder.php`)
- Creates 3 sample cards:
  1. **KULIAH PRAKTIS** (icon: graduation-cap, color: blue #3498db)
     - 4 features tentang pembelajaran praktis
  2. **INSTAN KERJA** (icon: briefcase, color: red #e74c3c)
     - 4 features tentang career readiness
  3. **KARIR MANDIRI** (icon: rocket, color: orange #f39c12)
     - 4 features tentang entrepreneurship

## Usage Guide

### For Admin Users:

#### Menambah Card Baru:
1. Login ke admin panel
2. Klik menu "Why Choose Us" di sidebar
3. Klik tombol "Tambah Card"
4. Isi form:
   - Judul card (wajib) - contoh: "KULIAH PRAKTIS"
   - Subjudul (opsional) - contoh: "Dengan Metode Modern"
   - Pilih icon dari Font Awesome - contoh: fa-graduation-cap
   - Pilih warna icon menggunakan color picker
   - Pilih warna background card
   - Centang "Tampilkan di website" jika ingin langsung aktif
5. Lihat live preview di kolom kanan
6. Klik "Simpan Card"

#### Menambah Fitur ke Card:
1. Dari halaman daftar, klik tombol "Fitur (x)" pada card yang ingin dikelola
2. ATAU dari halaman edit card, klik "Kelola Fitur"
3. Di halaman kelola fitur, gunakan form quick-add:
   - Ketik teks fitur - contoh: "Jadwal kuliah yang fleksibel"
   - (Opsional) Masukkan icon - default: fa-check
   - Klik "Tambah"
4. Fitur akan muncul di list

#### Mengubah Urutan Card/Fitur:
- **Card**: Di halaman index, seret icon grip-vertical di pojok kanan card
- **Fitur**: Di halaman kelola fitur, seret icon grip-vertical di sebelah kiri fitur
- Urutan akan otomatis tersimpan

#### Edit Card/Fitur:
- **Card**: Klik tombol kuning (edit icon) di card
- **Fitur**: Klik tombol kuning (edit icon), form akan muncul inline

#### Hapus Card/Fitur:
- **Card**: Klik tombol merah (trash icon), konfirmasi penghapusan
  - PERHATIAN: Semua fitur di dalam card juga akan terhapus
- **Fitur**: Klik tombol merah di setiap fitur, konfirmasi penghapusan

### For Frontend Users:
- Section akan otomatis tampil di homepage antara greeting dan berita utama
- Hanya card dengan status "Aktif" yang ditampilkan
- Card diurutkan sesuai field `order`
- Hover di card untuk melihat animasi interaktif
- Responsive untuk mobile, tablet, dan desktop

## Technical Notes

### Dependencies:
- **Sortable.js** v1.15.0 - Drag-drop functionality
  - Loaded via CDN: `https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js`
  - Used in: index.blade.php, features.blade.php

### CSS Features:
- Gradient background: `linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%)`
- Card hover lift: `transform: translateY(-10px)`
- Icon hover animation: `scale(1.1) rotate(5deg)`
- Shadow depth on hover: `0 15px 40px rgba(0, 0, 0, 0.15)`
- Mobile breakpoint: 768px

### AJAX Endpoints:
- **Reorder Cards**: POST `/admin/why-choose-us/reorder`
  - Payload: `{ items: [{id: 1, order: 0}, {id: 2, order: 1}, ...] }`
  - Response: `{ success: true, message: "..." }`

- **Reorder Features**: POST `/admin/why-choose-us/{id}/features/reorder`
  - Payload: `{ items: [{id: 1, order: 0}, {id: 2, order: 1}, ...] }`
  - Response: `{ success: true, message: "..." }`

### Validation Rules:
**Card:**
```php
'icon' => 'required|string|max:255',
'title' => 'required|string|max:255',
'subtitle' => 'nullable|string|max:255',
'icon_color' => 'required|string|max:7',  // Hex color
'background_color' => 'required|string|max:7',  // Hex color
'is_active' => 'boolean'
```

**Feature:**
```php
'feature_text' => 'required|string',
'icon' => 'nullable|string|max:255'
```

## Migration Commands
```bash
# Create migrations
php artisan make:migration create_why_choose_us_table
php artisan make:migration create_why_choose_us_features_table

# Run migrations
php artisan migrate

# Rollback if needed
php artisan migrate:rollback

# Seed initial data
php artisan db:seed --class=WhyChooseUsSeeder
```

## Testing Checklist
- [x] Create card dengan required fields
- [x] Create card dengan optional subtitle
- [x] Edit card dan update semua fields
- [x] Delete card (verify cascade delete features)
- [x] Drag-drop reorder cards
- [x] Add features to card
- [x] Edit feature inline
- [x] Delete feature
- [x] Drag-drop reorder features
- [x] Toggle is_active dan verify frontend visibility
- [x] Live preview saat create/edit
- [x] Frontend display dengan responsive layout
- [x] Hover animations
- [x] Mobile responsive

## Future Enhancements (Optional)
1. Rich text editor untuk feature_text
2. Image upload untuk card background
3. Animation settings (enable/disable per card)
4. Color scheme presets
5. Multi-language support
6. Analytics tracking (views, clicks)
7. A/B testing different card designs
8. Export/import card configurations

## Troubleshooting

### Card tidak muncul di frontend:
- Pastikan `is_active` = true
- Check apakah ada data di database: `WhyChooseUs::active()->get()`
- Verify `$whyChooseUs` variable passed ke view di HomeController
- Check browser console untuk JavaScript errors

### Drag-drop tidak berfungsi:
- Pastikan Sortable.js loaded: Check browser network tab
- Verify CSRF token tersedia: `{{ csrf_token() }}`
- Check browser console untuk AJAX errors
- Pastikan route `/admin/why-choose-us/reorder` terdaftar

### Icon tidak tampil:
- Pastikan Font Awesome CSS loaded di layout
- Verify icon class format: `fa-star` (bukan `fas fa-star`)
- Check icon tersedia di Font Awesome version yang digunakan
- Prefix `fas` ditambahkan otomatis di code

### Foreign key error saat migrate:
- Pastikan migration `why_choose_us` dijalankan sebelum `why_choose_us_features`
- Check `constrained('why_choose_us')` ditulis dengan benar (bukan 'why_choose_uses')
- Rollback dan re-migrate jika tabel sudah ada dengan constraint salah

## Files Modified/Created

### Created:
- `database/migrations/2025_11_09_170147_create_why_choose_us_table.php`
- `database/migrations/2025_11_09_170210_create_why_choose_us_features_table.php`
- `app/Models/WhyChooseUs.php`
- `app/Models/WhyChooseUsFeature.php`
- `app/Http/Controllers/Admin/WhyChooseUsController.php`
- `resources/views/admin/why-choose-us/index.blade.php`
- `resources/views/admin/why-choose-us/create.blade.php`
- `resources/views/admin/why-choose-us/edit.blade.php`
- `resources/views/admin/why-choose-us/features.blade.php`
- `resources/views/components/why-choose-us.blade.php`
- `database/seeders/WhyChooseUsSeeder.php`

### Modified:
- `routes/web.php` - Added Why Choose Us routes
- `resources/views/admin/layout.blade.php` - Added sidebar menu item
- `app/Http/Controllers/HomeController.php` - Load WhyChooseUs data
- `resources/views/frontend/home.blade.php` - Include component

## Author Notes
Feature ini dirancang untuk memberikan fleksibilitas maksimal kepada admin dalam mengelola konten "Why Choose Us" tanpa perlu mengedit code. Setiap aspek visual (warna, icon, teks) dapat dikustomisasi melalui admin panel. Drag-drop interface membuat pengaturan urutan menjadi intuitif. Live preview membantu admin melihat hasil akhir sebelum disimpan.

Cascade delete pada relationship memastikan tidak ada orphaned features saat card dihapus. AJAX-based reordering memberikan user experience yang smooth tanpa page reload.

---
**Version**: 1.0  
**Date**: November 2025  
**Laravel Version**: 10+  
**Bootstrap Version**: 5.3.2  
**Font Awesome Version**: 6.4.0
