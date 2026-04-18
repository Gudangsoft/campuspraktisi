# Admin Panel - Panduan Lengkap

## Fitur Admin Panel yang Tersedia

### ✨ Design Baru
- **Modern Sidebar Navigation** dengan gradient background
- **Dashboard Statistics** dengan card interaktif
- **Responsive Design** untuk desktop dan mobile
- **Icon-rich Interface** menggunakan Font Awesome
- **Smooth Animations** dan hover effects
- **Color-coded Status** untuk kemudahan identifikasi

### 🎨 Tampilan UI

#### 1. **Sidebar Menu**
- Gradient background (primary to dark)
- Hierarchical menu sections
- Active menu highlighting
- Icon untuk setiap menu item
- Badge counters (contoh: jumlah berita)
- User info di footer sidebar
- Logout button

#### 2. **Top Bar**
- Page title dinamis
- Breadcrumb navigation
- Quick action buttons
- Mobile hamburger menu

#### 3. **Dashboard**
- **Statistics Cards** dengan gradients:
  - Total Berita
  - Berita Published
  - Total Views
  - Total Kategori
- **Status Chart** - Published vs Draft
- **Latest News** - 5 berita terbaru
- **Popular News** - 5 berita terpopuler
- **Quick Actions** - Tombol shortcut untuk CRUD

#### 4. **Content Cards**
- Clean card design dengan shadow
- Header dengan title dan action buttons
- Organized table views
- Responsive layouts

## Menu Admin

### 📊 Dashboard (`/admin`)
Halaman utama dengan:
- Overview statistics
- Recent activities
- Popular content
- Quick actions

### 📰 Berita (`/admin/news`)
**Features:**
- List view dengan thumbnail
- Filter by status (Published/Draft)
- Pagination
- Quick preview
- Edit & Delete actions
- View counter display

**Create/Edit Form:**
- Category selection
- Title & slug (auto-generate)
- Excerpt
- Full content
- Image upload (max 2MB)
- Status: Draft/Published
- Published date picker

### 📁 Kategori Berita (`/admin/news-categories`)
**Features:**
- Simple table view
- Active/Inactive status
- Auto slug generation
- Description field

**Create/Edit Form:**
- Name
- Slug (optional)
- Description
- Active checkbox

### 🍔 Menu Navigasi (`/admin/menus`)
**Features:**
- **2-Level Menu Structure**
  - **Top Bar Menu**: Staf, Mahasiswa, Alumni, Mitra, dll
  - **Main Navigation**: Tentang, Penerimaan, Pendidikan, dll
- Hierarchical menu display (parent-child)
- Separated table view per group
- Order management
- Active/Inactive toggle
- Dropdown support untuk submenu

**Create/Edit Form:**
- Title (required)
- URL (optional untuk parent menu)
- **Menu Group** (Top Bar / Main Navigation)
- Parent menu selection (untuk submenu)
- Order number (urutan tampil)
- Target (_self / _blank)
- Active checkbox

**Struktur Menu:**
- **Top Bar** (atas): Quick links untuk user groups
- **Main Navigation** (navbar): Menu utama website dengan dropdown

Lihat detail: [MENU_STRUCTURE.md](MENU_STRUCTURE.md)

### ⚙️ Settings (`/admin/settings`)
**Features:**
- Grouped by category (General, Contact, Social)
- Key-value pairs
- Direct edit access
- No delete (system settings)
- **Image uploads** for logo and favicon

**Groups:**
- **General**: 
  - site_name (text)
  - site_tagline (text)
  - site_description (textarea)
  - **site_logo** (image) - Maks 2MB, format JPG/PNG/GIF, rekomendasi 200x50px
  - **site_favicon** (image) - Maks 2MB, format JPG/PNG/GIF, rekomendasi 32x32px
- **Contact**: contact_email, contact_phone, contact_address
- **Social**: facebook_url, twitter_url, instagram_url

**Upload Logo & Favicon:**
1. Akses `/admin/settings`
2. Klik "Edit" pada setting `site_logo` atau `site_favicon`
3. Pilih gambar dari komputer (maks 2MB)
4. Klik "Update Setting"
5. Logo akan tampil di navbar website dan admin panel
6. Favicon akan tampil di browser tab

**Tips:**
- Logo: Gunakan background transparan (PNG) untuk hasil terbaik
- Favicon: File square (32x32px atau 64x64px) untuk ketajaman optimal
- Gambar lama otomatis terhapus saat upload baru

### 👤 Profile
- User profile management
- Password change
- Email update

## Color Scheme

### Primary Colors
```css
--primary: #2c3e50 (Sidebar dark)
--primary-dark: #1a252f (Sidebar gradient bottom)
--accent: #3498db (Buttons, highlights)
--accent-hover: #2980b9 (Button hover)
```

### Status Colors
- **Success** (Published): Green (#28a745)
- **Warning** (Draft): Yellow (#ffc107)
- **Info** (Category): Cyan (#17a2b8)
- **Danger** (Delete): Red (#dc3545)
- **Secondary** (Order, Views): Gray (#6c757d)

### Gradient Cards
- **Purple-Pink**: News statistics
- **Pink-Red**: Published count
- **Blue-Cyan**: Views count
- **Green-Cyan**: Categories count

## Responsive Breakpoints

### Desktop (>768px)
- Full sidebar visible
- Multi-column layout
- Expanded tables

### Mobile (<768px)
- Collapsible sidebar
- Single column layout
- Responsive tables
- Hamburger menu

## Icon Guide

| Feature | Icon | Description |
|---------|------|-------------|
| Dashboard | `fa-home` | Home/overview |
| News | `fa-newspaper` | News articles |
| Categories | `fa-folder` | Category folders |
| Menus | `fa-bars` | Navigation menu |
| Settings | `fa-cog` | Configuration |
| Profile | `fa-user` | User profile |
| View Site | `fa-external-link-alt` | External link |
| Edit | `fa-edit` | Edit action |
| Delete | `fa-trash` | Delete action |
| View | `fa-eye` | View/preview |
| Save | `fa-save` | Save changes |
| Plus | `fa-plus` | Create new |

## Quick Tips

### 1. **Menambah Berita**
- Klik "Buat Berita Baru"
- Pilih kategori
- Isi title (slug auto-generate)
- Upload gambar (optional)
- Set status Published untuk langsung tampil
- Set tanggal publish

### 2. **Mengatur Menu**
- Buat parent menu dulu (tanpa URL)
- Lalu buat child menu dengan parent yang sudah dibuat
- Set order untuk urutan (0 = paling awal)

### 3. **Update Settings**
- Edit langsung dari list
- Perubahan langsung aktif
- Gunakan di view dengan `setting('key')`

### 4. **Upload Images**
- Max 2MB
- Format: JPG, PNG, GIF
- Auto resize (future enhancement)

## Keyboard Shortcuts (Future)

- `Ctrl + S` - Save form
- `Esc` - Close modal
- `/` - Focus search

## Browser Support

✅ Chrome 90+
✅ Firefox 88+
✅ Safari 14+
✅ Edge 90+

## Performance

- Lazy load images
- Pagination untuk list besar
- Optimized queries dengan eager loading
- Cached settings (future)

## Security Features

✅ Authentication required
✅ CSRF protection
✅ SQL injection prevention
✅ XSS protection
✅ Password hashing (bcrypt)
✅ Session management

## Customization

### Mengubah Warna Sidebar
Edit `resources/views/admin/layout.blade.php`:
```css
:root {
    --sidebar-width: 260px;
    --primary: #2c3e50;
    --primary-dark: #1a252f;
    --accent: #3498db;
}
```

### Menambah Menu Item
Edit sidebar section di `layout.blade.php`:
```html
<a href="{{ route('admin.new-menu') }}">
    <i class="fas fa-icon"></i>
    <span>Menu Title</span>
</a>
```

### Mengubah Logo
Replace text di `.sidebar-header`:
```html
<h4><i class="fas fa-icon me-2"></i>Your Logo</h4>
```

## Troubleshooting

**Sidebar tidak muncul di mobile**
- Click hamburger menu (☰)
- Sidebar akan slide in

**Card tidak hover**
- Check browser CSS support
- Clear cache

**Image upload error**
- Check max upload size di php.ini
- Pastikan folder `storage/app/public` writable
- Run `php artisan storage:link`

**Dashboard loading lambat**
- Optimize dengan caching
- Add indexes to database
- Use pagination

---

**Selamat menggunakan Admin Panel! 🎉**

Untuk bantuan lebih lanjut, hubungi developer atau lihat dokumentasi Laravel.
