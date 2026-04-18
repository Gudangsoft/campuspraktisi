# Website Kampus - Akademi Keperawatan / STIKES

Website kampus modern dengan Laravel 12 dan MySQL, dengan tema clean, professional, dan responsive.

## Fitur

### Frontend (Public)
- ✅ Homepage dengan hero section dan berita terbaru
- ✅ Halaman berita dengan pagination
- ✅ Detail berita dengan related articles
- ✅ Filter berita by category
- ✅ Responsive design (Bootstrap 5)
- ✅ Modern UI dengan gradient & hover effects
- ✅ Dynamic settings (site name, contact info, social media)

### Admin Panel
- ✅ Dashboard admin
- ✅ **Menu Management** - CRUD untuk menu navigasi dengan support parent/child
- ✅ **News Categories** - Kelola kategori berita
- ✅ **News Management** - CRUD berita lengkap dengan:
  - Upload gambar
  - WYSIWYG content
  - Status draft/published
  - Auto slug generation
  - View counter
- ✅ **Settings Management** - Konfigurasi website (nama, tagline, kontak, social media)
- ✅ Authentication dengan Laravel Breeze

## Tech Stack

- **Laravel 12** - PHP Framework
- **MySQL** - Database
- **Bootstrap 5** - CSS Framework
- **Font Awesome** - Icons
- **Laravel Breeze** - Authentication

## Instalasi

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM (opsional untuk asset compilation)

### Langkah Instalasi

1. **Clone / Setup Project**
   ```bash
   cd d:\PROJECT-KAMPUS\campus
   ```

2. **Buat Database MySQL**
   ```sql
   CREATE DATABASE kampus_db;
   ```

3. **Konfigurasi Environment**
   
   File `.env` sudah dikonfigurasi:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kampus_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Install Dependencies**
   ```bash
   composer install
   ```

5. **Generate Key**
   ```bash
   php artisan key:generate
   ```

6. **Jalankan Migration & Seeder**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

8. **Jalankan Development Server**
   ```bash
   php artisan serve
   ```

9. **Akses Website**
   - Frontend: http://127.0.0.1:8000
   - Admin Panel: http://127.0.0.1:8000/admin
   - Login: http://127.0.0.1:8000/login

## Default Login Admin

```
Email: admin@kampus.ac.id
Password: password
```

## Struktur Database

### Tables
1. **users** - Admin users (Laravel default + Breeze)
2. **settings** - Site configuration (key-value pairs)
3. **menus** - Navigation menu items (hierarchical)
4. **news_categories** - News categories
5. **news** - News articles with images, slug, views, etc.

## Cara Menggunakan

### 1. Login ke Admin Panel
- Buka http://127.0.0.1:8000/login
- Gunakan kredensial admin di atas
- Redirect ke dashboard admin

### 2. Kelola Settings
- Menu: Admin → Settings
- Edit site name, tagline, contact info, social media links
- Settings otomatis muncul di frontend

### 3. Buat Kategori Berita
- Menu: Admin → Categories
- Klik "Create Category"
- Isi nama, slug (opsional), deskripsi
- Set active/inactive

### 4. Buat Berita
- Menu: Admin → News
- Klik "Create News"
- Pilih kategori
- Isi judul, slug (auto-generate jika kosong)
- Tulis excerpt & content
- Upload gambar (opsional)
- Set status: Draft atau Published
- Set published date

### 5. Kelola Menu
- Menu: Admin → Menus
- Buat menu item dengan URL
- Support parent-child menu
- Set order untuk urutan tampil
- Active/inactive toggle

## Customization

### Warna & Tema
Edit file `resources/views/frontend/layout.blade.php` di bagian CSS:
```css
:root {
    --primary: #0056b3;
    --secondary: #003d82;
    --accent: #ff6b35;
}
```

### Logo & Branding
Edit di Admin → Settings:
- `site_name` - Nama kampus
- `site_tagline` - Tagline
- `site_description` - Deskripsi singkat

### Social Media
Edit di Admin → Settings:
- `facebook_url`
- `twitter_url`
- `instagram_url`

## File Penting

```
app/
├── Http/Controllers/
│   ├── HomeController.php           # Frontend homepage
│   ├── NewsPublicController.php     # Frontend news pages
│   └── Admin/
│       ├── DashboardController.php  # Admin dashboard
│       ├── MenuController.php       # Menu CRUD
│       ├── NewsController.php       # News CRUD
│       ├── NewsCategoryController.php
│       └── SettingController.php    # Settings management
├── Models/
│   ├── Setting.php                  # Setting model with helper
│   ├── Menu.php                     # Menu with parent/child
│   ├── News.php                     # News with slug auto-gen
│   └── NewsCategory.php
└── helpers.php                      # Helper functions (setting())

resources/views/
├── admin/                           # Admin panel views
│   ├── layout.blade.php             # Admin layout
│   ├── dashboard.blade.php
│   ├── menus/
│   ├── news/
│   ├── news_categories/
│   └── settings/
└── frontend/                        # Public views
    ├── layout.blade.php             # Frontend layout
    ├── home.blade.php               # Homepage
    └── news/
        ├── index.blade.php          # News list
        ├── show.blade.php           # News detail
        └── category.blade.php       # Category filter

database/
├── migrations/                      # Database schema
└── seeders/
    ├── UserSeeder.php               # Admin user
    └── SettingSeeder.php            # Default settings
```

## Production Deployment

1. Set `.env` untuk production:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. Optimize:
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. Set proper file permissions
4. Configure web server (Apache/Nginx)
5. Setup SSL certificate
6. Enable backup strategy

## Support

Untuk pertanyaan dan support, hubungi developer atau buka issue di repository.

## License

Open-source project untuk keperluan edukasi kampus.

---

**Dibuat dengan ❤️ menggunakan Laravel 12**
