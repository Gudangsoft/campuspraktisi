<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - {{ setting('site_name', 'Kampus') }}</title>
    @if(setting('site_favicon'))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/'.setting('site_favicon')) }}">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #2c3e50;
            --primary-dark: #1a252f;
            --accent: #3498db;
            --accent-hover: #2980b9;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Sidebar Styles */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 20px;
            background: rgba(0,0,0,0.2);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h4 {
            margin: 0;
            font-weight: 700;
            font-size: 1.3rem;
        }

        .sidebar-header small {
            color: rgba(255,255,255,0.7);
        }

        .sidebar-menu {
            padding: 15px 0 180px 0;
            overflow-y: auto;
            flex: 1;
        }

        .menu-section-title {
            padding: 15px 20px 10px;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
            font-weight: 600;
            letter-spacing: 1px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: var(--accent);
        }

        .sidebar-menu a.active {
            background: rgba(52, 152, 219, 0.2);
            color: white;
            border-left-color: var(--accent);
            font-weight: 600;
        }

        .sidebar-menu a i {
            width: 25px;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .sidebar-menu a .badge {
            margin-left: auto;
        }

        .sidebar-footer {
            margin-top: auto;
            width: 100%;
            padding: 15px 20px;
            background: rgba(0,0,0,0.2);
            border-top: 1px solid rgba(255,255,255,0.1);
            flex-shrink: 0;
        }

        .sidebar-footer .user-info {
            display: flex;
            align-items: center;
            color: rgba(255,255,255,0.9);
        }

        .sidebar-footer .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-weight: 700;
        }

        /* Main Content */
        .admin-main {
            padding-left: 260px !important;
            min-height: 100vh;
            width: 100% !important;
            position: relative;
        }

        .admin-topbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
            width: 100%;
        }

        .admin-topbar h5 {
            margin: 0;
            font-weight: 600;
            color: var(--primary);
        }

        .admin-topbar .breadcrumb {
            margin: 0;
            background: none;
            padding: 0;
        }

        .topbar-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .admin-content {
            padding: 20px 20px 30px 20px;
            max-width: 100%;
            overflow-x: hidden;
        }

        /* Cards & Components */
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }

        .stat-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }

        .stat-card p {
            color: #6c757d;
            margin: 5px 0 0;
        }

        .content-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            max-width: 100%;
            overflow-x: auto;
        }

        .content-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .content-card-header h5 {
            margin: 0;
            font-weight: 700;
            color: var(--primary);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }
        }

        /* Custom Buttons */
        .btn-primary {
            background: var(--accent);
            border-color: var(--accent);
        }

        .btn-primary:hover {
            background: var(--accent-hover);
            border-color: var(--accent-hover);
        }

        /* Table Improvements */
        .table thead {
            background: #f8f9fa;
        }

        .table tbody tr {
            transition: background 0.2s;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        /* Alert Improvements */
        .alert {
            border-radius: 8px;
            border: none;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        /* Scrollbar */
        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.1);
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            @if(setting('site_logo'))
                <div class="mb-2">
                    <img src="{{ asset('storage/'.setting('site_logo')) }}" 
                         alt="{{ setting('site_name', 'Admin Panel') }}" 
                         style="max-height: 40px; max-width: 100%;">
                </div>
            @else
                <h4><i class="fas fa-graduation-cap me-2"></i>{{ setting('site_name', 'Admin Panel') }}</h4>
            @endif
            <small>Management System</small>
        </div>

        <div class="sidebar-menu">
            <div class="menu-section-title">Main Menu</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>

            <div class="menu-section-title">Content Management</div>
            <a href="{{ route('admin.pages.index') }}" class="{{ request()->is('admin/pages*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                <span>Halaman</span>
                <span class="badge bg-info">{{ \App\Models\Page::count() }}</span>
            </a>
            <a href="{{ route('admin.news.index') }}" class="{{ request()->is('admin/news*') ? 'active' : '' }}">
                <i class="fas fa-newspaper"></i>
                <span>Berita</span>
                <span class="badge bg-primary">{{ \App\Models\News::count() }}</span>
            </a>
            <a href="{{ route('admin.news-categories.index') }}" class="{{ request()->is('admin/news-categories*') ? 'active' : '' }}">
                <i class="fas fa-folder"></i>
                <span>Kategori Berita</span>
            </a>
            <a href="{{ route('admin.menus.index') }}" class="{{ request()->is('admin/menus*') ? 'active' : '' }}">
                <i class="fas fa-bars"></i>
                <span>Menu Navigasi</span>
            </a>

            <div class="menu-section-title">Media & Gallery</div>
            <a href="{{ route('admin.sliders.index') }}" class="{{ request()->is('admin/sliders*') ? 'active' : '' }}">
                <i class="fas fa-images"></i>
                <span>Sliders</span>
                <span class="badge bg-success">{{ \App\Models\Slider::count() }}</span>
            </a>
            <a href="{{ route('admin.gallery-photos.index') }}" class="{{ request()->is('admin/gallery-photos*') ? 'active' : '' }}">
                <i class="fas fa-camera"></i>
                <span>Galeri Foto</span>
                <span class="badge bg-warning">{{ \App\Models\GalleryPhoto::count() }}</span>
            </a>
            <a href="{{ route('admin.gallery-videos.index') }}" class="{{ request()->is('admin/gallery-videos*') ? 'active' : '' }}">
                <i class="fas fa-video"></i>
                <span>Galeri Video</span>
                <span class="badge bg-danger">{{ \App\Models\GalleryVideo::count() }}</span>
            </a>

            <div class="menu-section-title">Informasi</div>
            <a href="{{ route('admin.prodi-unggulan.index') }}" class="{{ request()->is('admin/prodi-unggulan*') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap"></i>
                <span>Prodi Unggulan</span>
                <span class="badge bg-secondary">{{ \App\Models\ProdiUnggulan::count() }}</span>
            </a>
            <a href="{{ route('admin.greetings.index') }}" class="{{ request()->is('admin/greetings*') ? 'active' : '' }}">
                <i class="fas fa-hand-paper"></i>
                <span>Sambutan</span>
                <span class="badge bg-success">{{ \App\Models\Greeting::count() }}</span>
            </a>
            <a href="{{ route('admin.pimpinan.index') }}" class="{{ request()->is('admin/pimpinan*') ? 'active' : '' }}">
                <i class="fas fa-user-tie"></i>
                <span>Jajaran Pimpinan</span>
                <span class="badge bg-primary">{{ \App\Models\Pimpinan::count() }}</span>
            </a>
            <a href="{{ route('admin.agendas.index') }}" class="{{ request()->is('admin/agendas*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Agenda</span>
                <span class="badge bg-info">{{ \App\Models\Agenda::count() }}</span>
            </a>
            <a href="{{ route('admin.announcements.index') }}" class="{{ request()->is('admin/announcements*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn"></i>
                <span>Pengumuman</span>
                <span class="badge bg-primary">{{ \App\Models\Announcement::count() }}</span>
            </a>
            <a href="{{ route('admin.downloads.index') }}" class="{{ request()->is('admin/downloads*') ? 'active' : '' }}">
                <i class="fas fa-download"></i>
                <span>Download Center</span>
                <span class="badge bg-secondary">{{ \App\Models\Download::count() }}</span>
            </a>
            <a href="{{ route('admin.why-choose-us.index') }}" class="{{ request()->is('admin/why-choose-us*') ? 'active' : '' }}">
                <i class="fas fa-star"></i>
                <span>Why Choose Us</span>
                <span class="badge bg-warning">{{ \App\Models\WhyChooseUs::count() }}</span>
            </a>
            <a href="{{ route('admin.advantages.index') }}" class="{{ request()->is('admin/advantages*') ? 'active' : '' }}">
                <i class="fas fa-trophy"></i>
                <span>Keunggulan Kami</span>
                @php
                    try {
                        $advantageCount = \App\Models\Advantage::count();
                    } catch (\Exception $e) {
                        $advantageCount = 0;
                    }
                @endphp
                <span class="badge bg-success">{{ $advantageCount }}</span>
            </a>
            <a href="{{ route('admin.academic-calendar.index') }}" class="{{ request()->is('admin/academic-calendar*') ? 'active' : '' }}">
                <i class="fas fa-calendar-days"></i>
                <span>Kalender Akademik</span>
                <span class="badge bg-primary">{{ \App\Models\AcademicCalendar::active()->count() }}</span>
            </a>
            <a href="{{ route('admin.partners.index') }}" class="{{ request()->is('admin/partners*') ? 'active' : '' }}">
                <i class="fas fa-handshake"></i>
                <span>Mitra</span>
                <span class="badge bg-info">{{ \App\Models\Partner::active()->count() }}</span>
            </a>
            <a href="{{ route('admin.testimonials.index') }}" class="{{ request()->is('admin/testimonials*') ? 'active' : '' }}">
                <i class="fas fa-quote-left"></i>
                <span>Testimoni Alumni</span>
                <span class="badge bg-warning">{{ \App\Models\Testimonial::active()->count() }}</span>
            </a>

            <div class="menu-section-title">System</div>
            <a href="{{ route('admin.theme.index') }}" class="{{ request()->is('admin/theme*') ? 'active' : '' }}">
                <i class="fas fa-palette"></i>
                <span>Theme Customization</span>
            </a>
            <a href="{{ route('admin.footer.index') }}" class="{{ request()->is('admin/footer*') ? 'active' : '' }}">
                <i class="fas fa-shoe-prints"></i>
                <span>Footer Management</span>
                <span class="badge bg-info">{{ \App\Models\FooterSection::count() }}</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="{{ request()->is('admin/settings*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Setting Web</span>
            </a>
            <a href="{{ route('admin.backup.index') }}" class="{{ request()->is('admin/backup*') ? 'active' : '' }}">
                <i class="fas fa-database"></i>
                <span>Backup Database</span>
            </a>
            <a href="{{ route('home') }}" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                <span>Lihat Website</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight: 600; font-size: 0.9rem;">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <small style="color: rgba(255,255,255,0.6); font-size: 0.75rem;">{{ auth()->user()->email ?? '' }}</small>
                </div>
            </div>
            <div class="d-flex gap-2 mt-2">
                <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-light flex-fill" title="Edit Profile">
                    <i class="fas fa-user"></i>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex-fill">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light w-100" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="admin-main">
        <!-- Top Bar -->
        <div class="admin-topbar">
            <div>
                <h5>@yield('page-title', 'Dashboard')</h5>
                @if(trim($__env->yieldContent('breadcrumb')))
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                @endif
            </div>
            <div class="topbar-actions">
                <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye me-1"></i> View Site
                </a>
            </div>
        </div>

        <!-- Content Area -->
        <div class="admin-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('show');
        }
    </script>
    @yield('scripts')
</body>
</html>
