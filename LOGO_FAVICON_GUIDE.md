# 🎨 Logo & Favicon Upload - Panduan Lengkap

## ✅ Fitur yang Sudah Ditambahkan

### 1. Database Settings
- ✅ `site_logo` - Setting untuk upload logo website
- ✅ `site_favicon` - Setting untuk upload favicon browser

### 2. Controller Updates
- ✅ `SettingController@update` - Menangani upload gambar
- ✅ Validasi: maksimal 2MB, format image (JPG, PNG, GIF)
- ✅ Auto-delete gambar lama saat upload baru
- ✅ Storage: `storage/app/public/uploads/`

### 3. View Updates

#### Admin Settings Edit (`resources/views/admin/settings/edit.blade.php`)
- ✅ Form support `enctype="multipart/form-data"`
- ✅ File input untuk type='image'
- ✅ Preview gambar yang sudah diupload
- ✅ Informasi ukuran dan format yang direkomendasikan
- ✅ Sidebar info dengan tips upload

#### Frontend Layout (`resources/views/frontend/layout.blade.php`)
- ✅ Favicon di `<head>` section
- ✅ Logo di navbar dengan auto-sizing (max-height: 40px)
- ✅ Fallback ke text jika logo belum diupload

#### Admin Layout (`resources/views/admin\layout.blade.php`)
- ✅ Favicon di `<head>` section
- ✅ Logo di sidebar header
- ✅ Fallback ke icon + text jika logo belum diupload

### 4. Documentation
- ✅ `ADMIN_GUIDE.md` - Panduan lengkap upload logo & favicon
- ✅ `QUICK_START.md` - Quick steps untuk branding
- ✅ `LOGO_FAVICON_GUIDE.md` - Panduan khusus ini

---

## 📋 Cara Menggunakan

### Upload Logo

1. **Login ke Admin Panel**
   ```
   URL: http://127.0.0.1:8000/admin
   Email: admin@kampus.ac.id
   Password: password
   ```

2. **Masuk ke Settings**
   - Klik menu "Settings" di sidebar
   - Atau akses: http://127.0.0.1:8000/admin/settings

3. **Edit site_logo**
   - Cari setting dengan key `site_logo`
   - Klik tombol "Edit" (icon pensil)

4. **Upload File**
   - Klik "Choose File" / "Pilih File"
   - Pilih file logo dari komputer
   - **Rekomendasi:** 
     - Ukuran: 200x50 pixels (landscape)
     - Format: PNG dengan background transparan
     - Ukuran file: < 2MB

5. **Save**
   - Klik "Update Setting"
   - Logo akan langsung muncul di:
     - ✅ Navbar website (frontend)
     - ✅ Sidebar admin panel
     - ✅ Navbar admin panel

### Upload Favicon

1. **Edit site_favicon**
   - Di halaman `/admin/settings`
   - Cari setting dengan key `site_favicon`
   - Klik "Edit"

2. **Upload File**
   - Pilih file favicon
   - **Rekomendasi:**
     - Ukuran: 32x32px atau 64x64px (square)
     - Format: PNG atau ICO
     - Ukuran file: < 2MB

3. **Save & Verify**
   - Klik "Update Setting"
   - Refresh browser
   - Favicon muncul di tab browser

---

## 🎯 Rekomendasi Ukuran & Format

### Logo Website
```
Dimensi: 200px (width) x 50px (height)
Ratio: 4:1 (landscape)
Format: PNG (dengan transparansi)
File Size: < 500KB (optimal)
Background: Transparan
Color: Sesuai brand identity
```

### Favicon
```
Dimensi: 32x32px atau 64x64px (square)
Format: PNG atau ICO
File Size: < 100KB (optimal)
Background: Bisa solid atau transparan
Design: Simpel, recognizable di ukuran kecil
```

---

## 🛠️ Technical Details

### Storage Path
```
Physical: storage/app/public/uploads/
Public URL: storage/uploads/
Symlink: public/storage → storage/app/public
```

### Database Schema
```sql
settings table:
- key: site_logo | site_favicon
- value: uploads/filename.png (path relatif)
- type: image
- group: general
```

### Validation Rules
```php
'value' => 'nullable|image|max:2048'

Supported: jpeg, png, bmp, gif, svg, webp
Max size: 2048 KB (2MB)
```

### Blade Template Usage
```blade
{{-- Favicon --}}
@if(setting('site_favicon'))
    <link rel="icon" href="{{ asset('storage/'.setting('site_favicon')) }}">
@endif

{{-- Logo --}}
@if(setting('site_logo'))
    <img src="{{ asset('storage/'.setting('site_logo')) }}" 
         alt="Logo" 
         style="max-height: 40px;">
@endif
```

---

## 🔄 Update/Replace Logo

### Mengganti Logo Lama
1. Edit setting `site_logo` atau `site_favicon`
2. Upload file baru
3. File lama **otomatis terhapus** dari storage
4. Tidak perlu hapus manual

### Menghapus Logo
1. Edit setting
2. **Tidak upload file baru** (kosongkan)
3. Update setting
4. Logo akan kosong, kembali ke fallback (text/icon)

---

## 🐛 Troubleshooting

### Logo tidak muncul
- ✅ Cek storage link: `php artisan storage:link`
- ✅ Cek file exists: `storage/app/public/uploads/filename.png`
- ✅ Cek permissions folder storage
- ✅ Hard refresh browser: `Ctrl + Shift + R`

### Upload error "File too large"
- ✅ Cek ukuran file < 2MB
- ✅ Compress gambar dulu dengan tool online
- ✅ Cek php.ini: `upload_max_filesize` & `post_max_size`

### Favicon tidak update
- ✅ Clear browser cache
- ✅ Hard refresh: `Ctrl + Shift + R`
- ✅ Close & reopen browser
- ✅ Try incognito/private mode

---

## ✨ Features Implemented

1. ✅ **Multi-type Settings** - Text, Textarea, Image
2. ✅ **Image Upload** - With validation & auto-delete old file
3. ✅ **Preview** - Show current image before upload
4. ✅ **Responsive** - Logo auto-resize di berbagai device
5. ✅ **Fallback** - Text/icon jika belum upload
6. ✅ **Security** - File validation, size limit
7. ✅ **User-friendly** - Info & tips di edit page
8. ✅ **Documentation** - Lengkap dengan guide ini

---

## 📝 Next Steps (Optional)

Fitur tambahan yang bisa dikembangkan:
- [ ] Image cropping tool
- [ ] Multiple logo variants (light/dark theme)
- [ ] Logo upload via drag & drop
- [ ] Auto-generate favicon dari logo
- [ ] Logo gallery/history
- [ ] Watermark automatic
- [ ] Image optimization otomatis
- [ ] CDN integration

---

**Dibuat:** 5 Nov 2024  
**Version:** 1.0  
**Laravel:** 12.x  
**Status:** ✅ Production Ready

