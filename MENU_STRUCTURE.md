# Menu Structure

## Overview
Menu sistem dengan 2 level navigasi:
1. **Top Bar** - Menu horizontal di bagian atas (Staf, Mahasiswa, Alumni, dll)
2. **Main Navigation** - Menu utama di bawah logo (Tentang, Penerimaan, Pendidikan, dll)

## Menu Groups

### 1. Top Bar Menu (`topbar`)
**Lokasi:** Di bagian paling atas website, sejajar dengan contact info
**Karakteristik:**
- Link langsung (single level)
- Text kecil, horizontal
- Untuk quick access user groups
- Target bisa `_blank` atau `_self`

**Contoh Menu Top Bar:**
- Staf
- Mahasiswa  
- Alumni
- Mitra
- Pengunjung
- Pers
- My Campus (portal, new tab)
- Admission

### 2. Main Navigation (`main`)
**Lokasi:** Di bawah logo, navbar utama
**Karakteristik:**
- Bisa multi-level (dropdown)
- Text lebih besar, bold
- Menu utama website
- Support parent-child relationship

**Contoh Menu Main Navigation:**
- **Tentang** (dropdown)
  - Profil
  - Visi & Misi
  - Sejarah
  - Organisasi
- **Penerimaan** (direct link)
- **Pendidikan** (dropdown)
  - Program Sarjana
  - Program Magister
  - Program Doktor
- **Penelitian** (direct link)
- **Pengabdian** (direct link)
- **Penghargaan** (direct link)
- **Multikampus** (direct link)

### 3. Multi-level Dropdown Support ✨ NEW!
**Menu sekarang mendukung nested dropdown tanpa batas!**

**Contoh struktur bertingkat:**
```
Unit Pendukung (Level 1 - Parent)
├── LPPM (Level 2 - Child)
├── UNIT PENJAMINAN MUTU (Level 2 - Parent)
│   ├── Standar Mutu (Level 3 - Child)
│   ├── Kebijakan Mutu (Level 3 - Child)
│   ├── Instrumen Mutu (Level 3 - Child)
│   ├── Manual Mutu (Level 3 - Child)
│   ├── Monitoring dan Evaluasi (Level 3 - Child)
│   ├── Survey Kepuasan (Level 3 - Child)
│   └── Laporan Kinerja (Level 3 - Child)
```

**Fitur:**
- ✅ Unlimited nesting levels (Level 1 → 2 → 3 → 4 → ...)
- ✅ Hover to show submenu (desktop)
- ✅ Click to expand (mobile)
- ✅ Arrow indicator untuk menu dengan submenu
- ✅ Smooth animation transitions
- ✅ Responsive design

## Database Schema

### Field `menu_group`
- **Type:** ENUM('topbar', 'main')
- **Default:** 'main'
- **Required:** Yes

### Complete Fields
```php
- id (auto)
- title (required)
- url (nullable)
- parent_id (nullable, untuk submenu)
- order (integer, urutan tampil)
- is_active (boolean, status)
- target (_self / _blank)
- menu_group (topbar / main) // NEW!
- created_at
- updated_at
```

## Cara Menambah Menu

### Via Admin Panel

1. **Login Admin:** http://127.0.0.1:8000/admin
2. **Akses Menu:** `/admin/menus/create`
3. **Pilih Menu Group:**
   - **Top Bar:** Untuk menu di bagian atas (Staf, Mahasiswa, dll)
   - **Main Navigation:** Untuk menu utama (Tentang, Penerimaan, dll)
4. **Isi Form:**
   - Title: Nama menu (required)
   - URL: Link tujuan (kosongkan jika parent menu)
   - Menu Group: Pilih Top Bar atau Main Navigation
   - Parent: Pilih parent jika submenu
   - Order: Urutan tampil (semakin kecil semakin awal)
   - Target: `_self` (same tab) atau `_blank` (new tab)
   - Active: Centang untuk aktifkan menu

### Via Code/Seeder

```php
// Top Bar Menu
\App\Models\Menu::create([
    'title' => 'Mahasiswa',
    'url' => '/mahasiswa',
    'menu_group' => 'topbar',
    'order' => 1,
    'is_active' => true,
    'target' => '_self',
]);

// Main Navigation dengan Submenu
$parent = \App\Models\Menu::create([
    'title' => 'Tentang',
    'url' => '',
    'menu_group' => 'main',
    'order' => 1,
    'is_active' => true,
    'target' => '_self',
]);

\App\Models\Menu::create([
    'title' => 'Profil',
    'url' => '/profil',
    'parent_id' => $parent->id,
    'menu_group' => 'main',
    'order' => 1,
    'is_active' => true,
    'target' => '_self',
]);
```

## Model Scopes

```php
// Ambil menu Top Bar
$topbarMenus = Menu::active()->topbar()->parent()->orderBy('order')->get();

// Ambil menu Main Navigation
$mainMenus = Menu::active()->main()->parent()->orderBy('order')->get();

// Ambil semua menu aktif
$activeMenus = Menu::active()->get();

// Ambil menu parent saja (tanpa parent_id)
$parentMenus = Menu::parent()->get();
```

## Frontend Display

### Top Bar
Ditampilkan di `frontend.layout` bagian atas:
- Horizontal inline
- Text kecil
- Sejajar dengan social media icons

### Main Navigation
Ditampilkan di navbar utama:
- Support dropdown untuk menu dengan children
- Bootstrap dropdown component
- Responsive mobile menu

## Admin View

Di `/admin/menus` menu dipisah menjadi 2 tabel:
1. **Top Bar Menu** - Tabel pertama
2. **Main Navigation** - Tabel kedua

Memudahkan management dan visualisasi struktur menu.

## Migration History

```
2025_11_05_041433_add_menu_group_to_menus_table.php
- Added menu_group field (enum: topbar/main)
- Default value: main
```

## Sample Data

Run seeder untuk populate sample menu:
```bash
php artisan db:seed --class=MenuSeeder
```

Akan create:
- 8 Top Bar menus
- 7 Main Navigation menus (dengan beberapa submenu)

## Tips

1. **Order Number:**
   - Top Bar: 1-20 (left to right)
   - Main: 1-20 (left to right)
   - Submenu: 1-20 (top to bottom)

2. **URL Structure:**
   - Internal: `/tentang-kami`
   - External: `https://example.com`
   - Anchor: `/#section`
   - Empty: '' (untuk parent menu)

3. **Target:**
   - `_self`: Same window (default)
   - `_blank`: New tab (untuk external links, portal)

4. **Active Status:**
   - Uncheck untuk hide menu sementara
   - Menu inactive tidak muncul di frontend

## Troubleshooting

### Menu tidak muncul
- Cek `is_active` = true
- Cek `menu_group` sesuai (topbar/main)
- Cek URL valid
- Clear browser cache

### Dropdown tidak berfungsi
- Pastikan Bootstrap JS loaded
- Cek parent menu punya children
- Cek children menu `is_active` = true

### Urutan menu salah
- Edit order number
- Refresh browser cache
- Pastikan order unique per group
