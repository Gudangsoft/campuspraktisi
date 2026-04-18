# Quick Start Guide - Website Kampus

## Setup Cepat (5 Menit)

### 1. Buat Database
Buka MySQL/phpMyAdmin dan jalankan:
```sql
CREATE DATABASE kampus_db;
```

### 2. Jalankan Migration & Seeder
```bash
php artisan migrate
php artisan db:seed
```

### 3. Link Storage
```bash
php artisan storage:link
```

### 4. Jalankan Server
```bash
php artisan serve
```

### 5. Login Admin
- URL: http://127.0.0.1:8000/login
- Email: `admin@kampus.ac.id`
- Password: `password`

## Menu Admin

Setelah login, Anda dapat:

1. **Settings** - Edit informasi kampus
   - Site name, tagline, description
   - Contact info (email, phone, address)
   - Social media links

2. **Menus** - Buat menu navigasi
   - Klik "Create Menu"
   - Isi title dan URL
   - Set order untuk urutan

3. **Categories** - Buat kategori berita
   - Klik "Create Category"
   - Isi nama kategori
   - Slug auto-generate

4. **News** - Buat berita
   - Klik "Create News"
   - Pilih kategori
   - Isi title, excerpt, content
   - Upload gambar (optional)
   - Set status: Draft/Published
   - Set tanggal publish

5. **Logo & Favicon** - Upload branding
   - Masuk `/admin/settings`
   - Edit `site_logo`: Upload logo (200x50px, PNG transparan)
   - Edit `site_favicon`: Upload favicon (32x32px, ICO/PNG)
   - Logo tampil di navbar, favicon di browser tab

## Struktur URL

### Frontend (Publik)
- Homepage: `/`
- Berita: `/news`
- Detail Berita: `/news/{slug}`
- Kategori: `/category/{slug}`

### Admin
- Dashboard: `/admin`
- Menus: `/admin/menus`
- Categories: `/admin/news-categories`
- News: `/admin/news`
- Settings: `/admin/settings`

## Tips

### Auto Slug
- Slug akan otomatis dibuat dari Title
- Anda bisa edit manual jika perlu
- Slug digunakan di URL (SEO friendly)

### Image Upload
- Maksimal 2MB
- Format: JPG, PNG, GIF
- Gambar tersimpan di `storage/app/public/uploads`
- Akses via `/storage/uploads/filename.jpg`

### Status Berita
- **Draft**: Tidak muncul di frontend
- **Published**: Muncul di frontend
- Set "Published At" untuk schedule posting

### View Counter
- Otomatis bertambah setiap berita dibuka
- Tampil di list berita dan detail

## Troubleshooting Cepat

**Masalah: Tidak bisa login**
- Pastikan sudah run `php artisan db:seed`
- Check database `users` ada record email `admin@kampus.ac.id`

**Masalah: Gambar tidak muncul**
- Run `php artisan storage:link`
- Check folder `public/storage` ada link ke `storage/app/public`

**Masalah: Error 500**
- Check file `.env` DB config benar
- Run `php artisan config:clear`
- Check log di `storage/logs/laravel.log`

**Masalah: CSS tidak load**
- Untuk production, run `npm install && npm run build`
- Development bisa langsung pakai CDN Bootstrap (sudah setup)

## Next Steps

1. **Customize Design**
   - Edit `resources/views/frontend/layout.blade.php`
   - Ganti warna di CSS variables

2. **Add Content**
   - Buat kategori berita
   - Upload berita dengan gambar
   - Set menu navigasi

3. **Configure Settings**
   - Update site name
   - Add contact info
   - Add social media links

4. **Go Live**
   - Set production .env
   - Run optimize commands
   - Deploy to hosting

---

Selamat menggunakan! 🎉
