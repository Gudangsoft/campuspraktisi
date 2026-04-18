# Fitur Social Media Dinamis

## 📋 Deskripsi

Sistem social media icon yang dinamis sudah berhasil diimplementasikan. Icon-icon social media sekarang dapat dikonfigurasi langsung melalui halaman admin Settings, dan akan otomatis muncul/hilang di website berdasarkan apakah URL sudah diisi atau belum.

## ✅ Status Implementasi

### File yang Telah Dimodifikasi:

1. **Database Migration** (`database/migrations/2025_11_05_102458_add_new_social_media_settings.php`)
   - Menambahkan 4 platform social media baru ke tabel settings
   - Status: ✅ **Sudah dijalankan** (Migration completed)

2. **Database Seeder** (`database/seeders/SettingSeeder.php`)
   - Menambahkan youtube_url, linkedin_url, tiktok_url, whatsapp_number
   - Status: ✅ **Sudah diupdate**

3. **Frontend Layout** (`resources/views/frontend/layout.blade.php`)
   - Top Bar: Icon social media dinamis
   - Footer: Icon social media dinamis
   - Status: ✅ **Sudah diimplementasikan**

## 🎯 Platform Social Media yang Didukung

### 7 Platform Tersedia:
1. **Facebook** (`facebook_url`)
2. **Twitter** (`twitter_url`)
3. **Instagram** (`instagram_url`)
4. **YouTube** (`youtube_url`) ⭐ *BARU*
5. **LinkedIn** (`linkedin_url`) ⭐ *BARU*
6. **TikTok** (`tiktok_url`) ⭐ *BARU*
7. **WhatsApp** (`whatsapp_number`) ⭐ *BARU*

## 📍 Lokasi Icon Social Media

Icon social media muncul di 2 lokasi:

### 1. Top Bar (Bagian atas website)
- Posisi: Kanan atas halaman
- Warna: Putih dengan hover effect orange
- Ukuran: 32px × 32px
- Layout: Horizontal (flex row)

### 2. Footer (Bagian bawah website)
- Posisi: Kolom "Kontak" di footer
- Heading: "Ikuti Kami"
- Warna: Transparan dengan hover effect orange
- Ukuran: 38px × 38px (circular)
- Layout: Horizontal dengan flex wrap

## 🔧 Cara Mengkonfigurasi

### Langkah 1: Login ke Admin Panel
```
URL: http://127.0.0.1:8000/admin/login
```

### Langkah 2: Buka Menu Settings
```
Admin → Settings
```

### Langkah 3: Edit Settings Social Media

Cari dan edit settings berikut sesuai kebutuhan:

| Setting Key | Contoh Value | Keterangan |
|------------|-------------|------------|
| `facebook_url` | `https://facebook.com/akperkbn` | URL halaman Facebook |
| `twitter_url` | `https://twitter.com/akperkbn` | URL profil Twitter |
| `instagram_url` | `https://instagram.com/akperkbn` | URL profil Instagram |
| `youtube_url` | `https://youtube.com/@akperkbn` | URL channel YouTube |
| `linkedin_url` | `https://linkedin.com/company/akperkbn` | URL company/profil LinkedIn |
| `tiktok_url` | `https://tiktok.com/@akperkbn` | URL profil TikTok |
| `whatsapp_number` | `628123456789` | Nomor WhatsApp (format: 628xxx) |

### Langkah 4: Simpan Perubahan

Klik tombol **Update** pada setiap setting yang diubah.

### Langkah 5: Refresh Website

Icon akan **otomatis muncul** di website jika URL sudah diisi, dan **otomatis hilang** jika URL dikosongkan.

## 🎨 Cara Kerja Sistem Dinamis

### Konsep Array Mapping

```php
@php
    $socialMedia = [
        'facebook_url' => ['icon' => 'fab fa-facebook-f', 'label' => 'Facebook'],
        'twitter_url' => ['icon' => 'fab fa-twitter', 'label' => 'Twitter'],
        'instagram_url' => ['icon' => 'fab fa-instagram', 'label' => 'Instagram'],
        'youtube_url' => ['icon' => 'fab fa-youtube', 'label' => 'YouTube'],
        'linkedin_url' => ['icon' => 'fab fa-linkedin-in', 'label' => 'LinkedIn'],
        'tiktok_url' => ['icon' => 'fab fa-tiktok', 'label' => 'TikTok'],
    ];
@endphp
```

### Loop Dinamis dengan Conditional

```php
@foreach($socialMedia as $key => $social)
    @if(setting($key))
        <a href="{{ setting($key) }}" target="_blank" 
           class="social-icon" 
           title="{{ $social['label'] }}">
            <i class="{{ $social['icon'] }}"></i>
        </a>
    @endif
@endforeach
```

**Penjelasan:**
- Loop melalui array `$socialMedia`
- Cek apakah setting memiliki value dengan `@if(setting($key))`
- Jika ada value, render link dengan icon
- Jika kosong, skip (tidak render apapun)

### WhatsApp Special Case

WhatsApp menggunakan format URL khusus dengan nomor telepon:

```php
@if(setting('whatsapp_number'))
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp_number')) }}" 
       target="_blank" 
       class="social-icon" 
       title="WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
@endif
```

**Fungsi `preg_replace('/[^0-9]/', '', ...)` :**
- Membersihkan karakter non-angka dari nomor
- Input: `+62 812-3456-7890` → Output: `628123456789`
- Diperlukan untuk format URL `wa.me/628123456789`

## 🎨 Styling CSS

### Top Bar Social Icons

```css
.topbar-social {
    display: flex;
    gap: 10px;
    margin-left: 15px;
}

.social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    transition: all 0.3s ease;
}

.social-icon:hover {
    background: var(--accent); /* Orange */
    transform: translateY(-2px);
}
```

### Footer Social Icons

```css
.footer-social {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.footer-social-icon {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    color: #adb5bd;
    transition: all 0.3s ease;
}

.footer-social-icon:hover {
    background: var(--accent);
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
}
```

## 📱 Responsive Design

### Desktop
- Top Bar: Icons dalam satu baris horizontal
- Footer: Icons dalam satu baris dengan gap 10px

### Mobile
- Top Bar: Tetap horizontal, scrollable jika perlu
- Footer: Flex wrap, otomatis wrap ke baris baru jika space tidak cukup

## 🔍 Testing Checklist

### Test 1: Icon Visibility
- [ ] Login ke admin
- [ ] Set `youtube_url` = `https://youtube.com/@test`
- [ ] Refresh homepage
- [ ] ✅ Icon YouTube harus muncul di top bar dan footer

### Test 2: Icon Hiding
- [ ] Login ke admin
- [ ] Kosongkan value `youtube_url`
- [ ] Refresh homepage
- [ ] ✅ Icon YouTube harus hilang

### Test 3: WhatsApp Number Format
- [ ] Set `whatsapp_number` = `+62 812-3456-7890`
- [ ] Klik icon WhatsApp di website
- [ ] ✅ Harus redirect ke `wa.me/628123456789`

### Test 4: Hover Effects
- [ ] Hover mouse ke icon di top bar
- [ ] ✅ Background berubah orange, icon naik sedikit
- [ ] Hover mouse ke icon di footer
- [ ] ✅ Background orange, icon naik, muncul shadow

### Test 5: All Platforms
- [ ] Isi semua 7 platform dengan URL
- [ ] Refresh homepage
- [ ] ✅ 7 icon harus muncul di top bar
- [ ] ✅ 7 icon harus muncul di footer

## 🚀 Keuntungan Sistem Dinamis

### ✅ Fleksibilitas
Admin dapat menambah/mengurangi platform tanpa edit code

### ✅ Clean Code
Tidak ada hardcoded URL di template

### ✅ Scalable
Menambah platform baru hanya perlu:
1. Tambah setting di database
2. Tambah entry di array `$socialMedia`

### ✅ User-Friendly
Non-technical admin bisa manage social media links

### ✅ Consistent UI
Icon otomatis mengikuti style guide yang sama

## 📝 Menambah Platform Baru (Advanced)

Jika suatu saat ingin menambah platform lain (misal: Telegram, Discord):

### Step 1: Buat Migration
```bash
php artisan make:migration add_telegram_url_setting
```

### Step 2: Edit Migration
```php
DB::table('settings')->insert([
    'key' => 'telegram_url',
    'value' => '',
    'type' => 'text',
    'group' => 'social',
    'created_at' => now(),
    'updated_at' => now(),
]);
```

### Step 3: Jalankan Migration
```bash
php artisan migrate
```

### Step 4: Update Array di Layout
Tambah ke array `$socialMedia` di `layout.blade.php`:
```php
'telegram_url' => ['icon' => 'fab fa-telegram', 'label' => 'Telegram'],
```

### Done! ✅
Icon Telegram akan otomatis muncul saat URL diisi.

## 📞 Support

Jika ada pertanyaan atau issue, hubungi developer atau buat ticket di project management system.

## 📅 Changelog

### Version 1.0 (05 November 2025)
- ✅ Implementasi sistem social media dinamis
- ✅ Menambahkan 4 platform baru (YouTube, LinkedIn, TikTok, WhatsApp)
- ✅ Top bar dan footer integration
- ✅ Hover effects dan responsive design
- ✅ WhatsApp number formatting

---

**Developer Notes:**
- Font Awesome 6.4.0 digunakan untuk icon
- Helper function `setting()` mengambil value dari database
- CSS custom variables `--accent` untuk orange theme color
- Bootstrap 5.3.2 untuk grid system