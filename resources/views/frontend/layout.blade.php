<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', setting('site_name', 'Kampus'))</title>
    @if(setting('site_favicon'))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/'.setting('site_favicon')) }}">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary: {{ setting('theme_primary_color', '#1e90ff') }};
            --secondary: {{ setting('theme_secondary_color', '#6c757d') }};
            --success: {{ setting('theme_success_color', '#198754') }};
            --danger: {{ setting('theme_danger_color', '#dc3545') }};
            --warning: {{ setting('theme_warning_color', '#ffc107') }};
            --info: {{ setting('theme_info_color', '#0dcaf0') }};
            --topbar-bg: {{ setting('theme_topbar_bg_color', '#1a1a2e') }};
            --topbar-text: {{ setting('theme_topbar_text_color', '#e0e0e0') }};
            --header-bg: {{ setting('theme_header_bg_color', '#ffffff') }};
            --header-text: {{ setting('theme_header_text_color', '#212529') }};
            --footer-bg: {{ setting('theme_footer_bg_color', '#003366') }};
            --footer-text: {{ setting('theme_footer_text_color', '#ffffff') }};
            --button-bg: {{ setting('theme_button_bg_color', '#1e90ff') }};
            --button-text: {{ setting('theme_button_text_color', '#ffffff') }};
            --link-color: {{ setting('theme_link_color', '#1e90ff') }};
            --link-hover-color: {{ setting('theme_link_hover_color', '#0066cc') }};
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        
        /* Links */
        a {
            color: var(--link-color);
            text-decoration: none;
        }
        
        a:hover {
            color: var(--link-hover-color);
        }
        
        /* Modern Top Bar */
        .topbar {
            background: var(--topbar-bg);
            color: var(--topbar-text);
            padding: 12px 0;
            font-size: 0.875rem;
            border-bottom: 2px solid var(--primary);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .topbar-item {
            display: inline-flex;
            align-items: center;
            color: var(--topbar-text);
            transition: all 0.3s ease;
        }
        
        .topbar-item i {
            color: var(--accent);
            margin-right: 8px;
            font-size: 0.9rem;
        }
        
        .topbar-item span {
            font-weight: 400;
        }
        
        .topbar-item:hover {
            color: #fff;
        }
        
        .topbar-link {
            color: var(--topbar-text);
            text-decoration: none;
            padding: 5px 12px;
            margin-right: 5px;
            transition: all 0.3s ease;
            border-radius: 4px;
            font-weight: 500;
        }
        
        .topbar-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .topbar-social {
            display: inline-flex;
            gap: 8px;
            margin-left: 15px;
            padding-left: 15px;
            border-left: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: var(--topbar-text);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        
        .social-icon:hover {
            background: var(--accent);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
        }
        
        /* Responsive Top Bar */
        @media (max-width: 768px) {
            .topbar {
                padding: 10px 0;
            }
            
            .topbar-left {
                margin-bottom: 10px;
            }
            
            .topbar-item {
                font-size: 0.8rem;
                margin-right: 15px !important;
            }
            
            .topbar-right {
                justify-content: flex-start !important;
            }
            
            .topbar-social {
                margin-left: 10px;
                padding-left: 10px;
            }
        }
        
        @media (max-width: 576px) {
            .topbar-item span {
                display: none;
            }
            
            .topbar-item i {
                margin-right: 0;
            }
            
            .topbar-link {
                font-size: 0.75rem;
                padding: 3px 8px;
            }
        }
        
        .navbar-main {
            background: var(--header-bg);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--header-text) !important;
        }
        
        .navbar-main .nav-link {
            color: var(--header-text) !important;
            padding: 10px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .navbar-main .nav-link:hover,
        .navbar-main .nav-link.active {
            background-color: rgba(255, 255, 255, 0.25);
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        /* Multi-level Dropdown Menu Styles */
        .navbar-nav .dropdown-menu {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-top: 0;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .navbar-nav .dropdown-menu .dropdown-item {
            padding: 10px 20px;
            transition: all 0.3s ease;
            position: relative;
            border-radius: 5px;
            margin: 2px 5px;
        }
        
        .navbar-nav .dropdown-menu .dropdown-item:hover {
            background: var(--primary);
            color: white !important;
            padding-left: 25px;
            transform: translateX(3px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        
        .navbar-nav .dropdown-menu .dropdown-item:active {
            background: var(--secondary);
            color: white !important;
        }
        
        /* Visual indicator for items with submenu */
        .navbar-nav .dropend > .dropdown-toggle {
            position: relative;
            padding-right: 2.5rem;
        }
        
        .navbar-nav .dropend > .dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.15) !important;
            color: #ffffff !important;
        }
        
        .navbar-nav .dropend > .dropdown-toggle::after {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
        }
        
        /* ===== MULTILEVEL DROPDOWN MENU ===== */
        
        /* Level 1 dropdown - MUST allow overflow for submenus */
        .navbar-nav .dropdown-menu {
            display: none;
            overflow: visible !important;
        }
        
        .navbar-nav .dropdown:hover > .dropdown-menu {
            display: block;
        }
        
        /* Submenu (level 2+) */
        .dropdown-submenu {
            position: relative;
        }
        
        .dropdown-submenu .dropdown-menu {
            position: absolute;
            top: 0;
            left: 100%;
            margin-top: 0;
            margin-left: 0;
            display: none;
            min-width: 200px;
            z-index: 9999;
        }
        
        .dropdown-submenu:hover > .dropdown-menu {
            display: block;
        }
        
        /* Arrow indicator for items with submenu */
        .dropdown-submenu > .dropdown-item::after {
            content: "›";
            float: right;
            margin-left: 10px;
        }
            line-height: 1;
        }
        
        /* Multi-level nested support */
        .navbar-nav .dropdown-menu .dropdown-menu {
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        }
        
        /* Show nested dropdown on hover */
        @media (min-width: 992px) {
            .navbar-nav .dropdown:hover > .dropdown-menu {
                display: block;
                animation: fadeInDown 0.3s;
            }
            
            .navbar-nav .dropend:hover > .dropdown-menu {
                display: block;
                animation: fadeInRight 0.3s;
            }
            
            /* Prevent dropdown from closing when hovering over submenu */
            .navbar-nav .dropdown-menu:hover {
                display: block;
            }
            
            /* Position adjustment for deeply nested menus */
            .navbar-nav .dropend .dropend .dropdown-menu {
                margin-left: 0.25rem;
            }
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Mobile Menu Styles */
        @media (max-width: 991px) {
            .navbar-nav .dropdown-menu {
                border: none;
                padding-left: 15px;
                box-shadow: none;
                background-color: transparent;
                display: none; /* Hidden by default */
            }
            
            .navbar-nav .dropdown-menu.show {
                display: block !important;
            }
            
            .navbar-nav .dropend .dropdown-menu {
                position: static !important;
                transform: none !important;
                margin-left: 0;
                padding-left: 15px;
                margin-top: 0.25rem;
            }
            
            .navbar-nav .dropdown-item {
                color: rgba(255,255,255,0.9);
                padding: 0.5rem 1rem;
                white-space: normal;
            }
            
            .navbar-nav .dropdown-item:hover,
            .navbar-nav .dropdown-item:focus {
                background-color: rgba(255,255,255,0.1);
                color: #fff;
            }
            
            /* Arrow indicator for mobile nested items */
            .navbar-nav .dropend > .dropdown-toggle::after {
                margin-top: 0.3em;
            }
            
            /* Indent for each nesting level */
            .navbar-nav .dropend .dropend .dropdown-menu {
                padding-left: 20px;
            }
            
            .navbar-nav .dropend .dropend .dropend .dropdown-menu {
                padding-left: 25px;
            }
        }
        
        .hero-section {
            background: var(--primary);
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
        }
        
        .hero-section h1 {
            font-weight: 700;
            font-size: 3rem;
            margin-bottom: 20px;
        }
        
        /* Hero Slider Styles */
        .hero-slider {
            position: relative;
            margin-top: 0;
        }
        
        .hero-slider .carousel-item {
            position: relative;
            min-height: 700px;
        }
        
        .hero-slider .carousel-item img {
            width: 100%;
            height: 700px;
            object-fit: cover;
        }
        
        .hero-slider .carousel-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.5) 100%);
            z-index: 1;
        }
        
        .hero-slider .carousel-caption {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 2;
            padding: 0;
        }
        
        .hero-slider .slider-content {
            max-width: 800px;
            padding: 2rem;
        }
        
        .hero-slider .carousel-control-prev,
        .hero-slider .carousel-control-next {
            width: 5%;
            opacity: 0.8;
        }
        
        .hero-slider .carousel-control-prev:hover,
        .hero-slider .carousel-control-next:hover {
            opacity: 1;
        }
        
        .hero-slider .carousel-indicators {
            bottom: 30px;
        }
        
        .hero-slider .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 5px;
        }
        
        @media (max-width: 768px) {
            .hero-slider .carousel-item {
                min-height: 300px;
            }
            
            .hero-slider .carousel-item img {
                height: 300px;
            }
            
            .hero-slider .slider-content h1 {
                font-size: 2rem !important;
            }
            
            .hero-slider .slider-content p {
                font-size: 1rem !important;
            }
        }

        
        .card-news {
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .card-news:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        .card-news img {
            height: 200px;
            object-fit: cover;
        }
        
        /* News Horizontal Card */
        .news-card-horizontal {
            transition: all 0.3s ease;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .news-card-horizontal:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        }
        
        .news-card-horizontal img {
            height: 100%;
            min-height: 180px;
            object-fit: cover;
        }
        
        .news-placeholder-img {
            min-height: 180px;
        }
        
        /* Sidebar Styles */
        .sidebar-widget {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        
        .sidebar-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid var(--primary);
        }
        
        .sidebar-news-img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }
        
        .sidebar-news-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #333;
            line-height: 1.4;
            transition: color 0.3s ease;
        }
        
        .list-group-item-action:hover .sidebar-news-title {
            color: var(--primary);
        }
        
        .list-group-item-action {
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0 !important;
            transition: all 0.3s ease;
        }
        
        .list-group-item-action:hover {
            background-color: #f8f9fa;
            padding-left: 10px;
        }
        
        .list-group-item-action:last-child {
            border-bottom: none !important;
        }
        
        /* Responsive Styles */
        @media (max-width: 991px) {
            .news-card-horizontal .col-md-4 {
                max-height: 200px;
            }
            
            .sidebar-widget {
                margin-top: 30px;
            }
        }
        
        @media (max-width: 576px) {
            .sidebar-news-img {
                width: 60px;
                height: 60px;
            }
            
            .sidebar-news-title {
                font-size: 0.85rem;
            }
            
            .news-placeholder-img {
                min-height: 150px;
            }
        }
        
        .section-title {
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--accent);
        }
        
        footer {
            background: var(--footer-bg);
            color: #ffffff;
            padding: 40px 0 20px;
            margin-top: 60px;
        }
        
        footer h5,
        footer h6,
        footer p,
        footer li {
            color: #ffffff !important;
        }
        
        footer a {
            color: #ffffff;
            opacity: 0.9;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        footer a:hover {
            opacity: 1;
            color: #ffffff;
            text-decoration: underline;
        }
        
        .footer-social {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .footer-social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        
        .footer-social-icon:hover {
            background: var(--accent);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
        }
        
        /* Bootstrap Color Overrides */
        .btn-primary {
            background: var(--button-bg);
            border-color: var(--button-bg);
            color: var(--button-text);
        }
        
        .btn-primary:hover,
        .btn-primary:focus {
            background: var(--primary);
            border-color: var(--primary);
            color: var(--button-text);
        }
        
        .bg-primary {
            background-color: var(--primary) !important;
        }
        
        .text-primary {
            color: var(--primary) !important;
        }
        
        .badge.bg-primary {
            background-color: var(--primary) !important;
        }
        
        .badge.bg-secondary {
            background-color: var(--secondary) !important;
        }
        
        .badge.bg-success {
            background-color: var(--success) !important;
        }
        
        .badge.bg-danger {
            background-color: var(--danger) !important;
        }
        
        .badge.bg-warning {
            background-color: var(--warning) !important;
        }
        
        .badge.bg-info {
            background-color: var(--info) !important;
        }
        
        .featured-card {
            transition: all 0.3s ease;
        }
        
        .featured-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        }
        
        .featured-card .card-title a:hover {
            color: var(--primary) !important;
        }
        
        .video-card {
            transition: all 0.3s ease;
        }
        
        .video-card:hover {
            transform: translateY(-5px);
        }
        
        .video-thumbnail {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .video-overlay {
            background: rgba(0,0,0,0.3);
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 8px;
        }
        
        .video-card:hover .video-overlay {
            opacity: 1;
        }
        
        .video-overlay .btn {
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }
        
        .video-overlay .btn:hover {
            transform: scale(1.1);
        }
        
        .gallery-item {
            overflow: hidden;
            border-radius: 8px;
            cursor: pointer;
            position: relative;
        }
        
        .gallery-item img {
            transition: transform 0.3s ease;
            display: block;
        }
        
        .gallery-item:hover img {
            transform: scale(1.15);
        }
        
        .gallery-overlay {
            background: rgba(0,0,0,0.6);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }
        
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
        
        .modal-xl .modal-body img {
            display: block;
            margin: 0 auto;
        }

        /* Greeting Section Styles */
        .greeting-section {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            position: relative;
            overflow: hidden;
        }

        .greeting-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255, 107, 53, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(0, 123, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .greeting-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
        }

        .greeting-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .greeting-card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px 30px;
            position: relative;
            overflow: hidden;
        }

        .greeting-card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-30px, -30px); }
        }

        .greeting-card-title {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        .greeting-card-image {
            position: relative;
            height: 300px;
            overflow: hidden;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .greeting-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .greeting-card:hover .greeting-card-image img {
            transform: scale(1.1);
        }

        .greeting-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.3) 100%);
            pointer-events: none;
        }

        .greeting-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .placeholder-content {
            text-align: center;
            color: white;
            padding: 20px;
        }

        .placeholder-content i {
            opacity: 0.9;
        }

        .placeholder-content h4 {
            color: white;
            font-weight: 600;
        }

        .greeting-card-body {
            padding: 30px;
        }

        .greeting-title {
            color: #2d3748;
            font-weight: 700;
            font-size: 1.5rem;
            line-height: 1.3;
        }

        .greeting-subtitle {
            font-size: 1.1rem;
            font-style: italic;
        }

        .greeting-content {
            color: #4a5568;
            font-size: 0.95rem;
        }

        .greeting-author {
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
        }

        /* Custom Language Selector with Flags */
        .language-selector {
            position: relative;
            display: inline-block;
        }

        .language-selector-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 6px 12px;
            border-radius: 4px;
            color: var(--topbar-text);
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }

        .language-selector-btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            color: #fff;
        }

        .language-selector-btn img {
            width: 20px;
            height: 15px;
            object-fit: cover;
            border-radius: 2px;
        }

        .language-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 5px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            min-width: 200px;
            display: none;
            z-index: 9999;
            max-height: 400px;
            overflow-y: auto;
        }

        .language-dropdown.show {
            display: block;
        }

        .language-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            cursor: pointer;
            transition: background 0.2s;
            color: #333;
            text-decoration: none;
        }

        .language-option:hover {
            background: #f5f5f5;
        }

        .language-option img {
            width: 24px;
            height: 18px;
            object-fit: cover;
            border-radius: 2px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }

        .language-option span {
            font-size: 0.9rem;
            color: #333;
        }

        /* Hide original Google Translate widget */
        #google_translate_element {
            position: absolute;
            left: -9999px;
            visibility: hidden;
            opacity: 0;
            pointer-events: none;
        }

        #google_translate_element .goog-te-combo {
            visibility: hidden !important;
        }

        /* Hide Google Translate banner and toolbar */
        .goog-te-banner-frame.skiptranslate {
            display: none !important;
        }

        body {
            top: 0 !important;
            position: static !important;
        }

        .skiptranslate {
            display: none !important;
        }
        
        /* Fix body margin when Google Translate is active */
        body > .skiptranslate {
            display: none !important;
        }
        
        iframe.skiptranslate {
            display: none !important;
        }

        .author-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .author-name {
            color: #2d3748;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .author-title {
            font-size: 0.9rem;
            font-style: italic;
        }

        .btn-greeting-more {
            display: inline-flex;
            align-items: center;
            padding: 12px 28px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-greeting-more:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-greeting-more i {
            transition: transform 0.3s ease;
        }

        .btn-greeting-more:hover i {
            transform: translateX(5px);
        }

        /* Modal Enhancements */
        .modal-content {
            border: none;
            border-radius: 16px;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 16px 16px 0 0;
        }

        .modal-header .modal-title {
            color: white;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .greeting-full-content {
            font-size: 1rem;
            color: #4a5568;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .greeting-card-header {
                padding: 15px 20px;
            }

            .greeting-card-title {
                font-size: 1.25rem;
            }

            .greeting-card-image {
                height: 250px;
            }

            .greeting-card-body {
                padding: 20px;
            }

            .greeting-title {
                font-size: 1.25rem;
            }

            .author-info {
                align-items: flex-start;
            }
        }

        /* ===== BACK TO TOP BUTTON ===== */
        #backToTop {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            border: none;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            z-index: 998;
            box-shadow: 0 4px 12px rgba(0, 86, 179, 0.4);
            transition: all 0.3s ease;
        }

        #backToTop:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 86, 179, 0.6);
        }

        #backToTop.show {
            display: flex;
            animation: fadeInUp 0.3s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== WHATSAPP FLOAT BUTTON ===== */
        .whatsapp-float {
            position: fixed;
            bottom: 90px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: #25d366;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
            z-index: 999;
            text-decoration: none;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }

        .whatsapp-float:hover {
            background: #128c7e;
            color: white;
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
            animation: none;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 6px 16px rgba(37, 211, 102, 0.6);
            }
        }

        /* Tooltip untuk WhatsApp */
        .whatsapp-float::before {
            content: "Ada yang bisa kami bantu?";
            position: absolute;
            right: 70px;
            background: #25d366;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            white-space: nowrap;
            font-size: 14px;
            font-family: 'Segoe UI', sans-serif;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .whatsapp-float:hover::before {
            opacity: 1;
        }

        /* ===== SOCIAL SHARE BUTTONS ===== */
        .social-share {
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .social-share-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .social-share-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn-social-share {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            color: white;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-social-share:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            color: white;
        }

        .btn-social-share i {
            font-size: 16px;
        }

        .btn-facebook {
            background: #1877f2;
        }

        .btn-facebook:hover {
            background: #145dbf;
        }

        .btn-twitter {
            background: #1da1f2;
        }

        .btn-twitter:hover {
            background: #0d8bd9;
        }

        .btn-whatsapp-share {
            background: #25d366;
        }

        .btn-whatsapp-share:hover {
            background: #128c7e;
        }

        .btn-telegram {
            background: #0088cc;
        }

        .btn-telegram:hover {
            background: #006699;
        }

        .btn-linkedin {
            background: #0077b5;
        }

        .btn-linkedin:hover {
            background: #005885;
        }

        .btn-copy-link {
            background: #6c757d;
        }

        .btn-copy-link:hover {
            background: #5a6268;
        }

        /* Responsive untuk mobile */
        @media (max-width: 768px) {
            #backToTop {
                bottom: 20px;
                right: 20px;
                width: 45px;
                height: 45px;
                font-size: 18px;
            }

            .whatsapp-float {
                bottom: 75px;
                right: 20px;
                width: 55px;
                height: 55px;
                font-size: 28px;
            }

            .whatsapp-float::before {
                display: none;
            }

            .social-share-buttons {
                flex-direction: column;
            }

            .btn-social-share {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Top Bar -->
    <div class="topbar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="topbar-left d-flex align-items-center flex-wrap">
                        <!-- Custom Language Selector with Flags -->
                        <div class="language-selector me-4">
                            <div class="language-selector-btn" id="languageBtn">
                                <img src="https://flagcdn.com/w40/id.png" alt="ID" id="currentFlag">
                                <span id="currentLang">ID</span>
                                <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                            </div>
                            <div class="language-dropdown" id="languageDropdown">
                                <a href="javascript:void(0)" class="language-option" data-lang="id" data-flag="id">
                                    <img src="https://flagcdn.com/w40/id.png" alt="Indonesia">
                                    <span>Indonesia</span>
                                </a>
                                <a href="javascript:void(0)" class="language-option" data-lang="en" data-flag="gb">
                                    <img src="https://flagcdn.com/w40/gb.png" alt="English">
                                    <span>English</span>
                                </a>
                                <a href="javascript:void(0)" class="language-option" data-lang="ar" data-flag="sa">
                                    <img src="https://flagcdn.com/w40/sa.png" alt="Arabic">
                                    <span>العربية (Arabic)</span>
                                </a>
                                <a href="javascript:void(0)" class="language-option" data-lang="zh-CN" data-flag="cn">
                                    <img src="https://flagcdn.com/w40/cn.png" alt="Chinese">
                                    <span>中文 (Chinese)</span>
                                </a>
                                <a href="javascript:void(0)" class="language-option" data-lang="ja" data-flag="jp">
                                    <img src="https://flagcdn.com/w40/jp.png" alt="Japanese">
                                    <span>日本語 (Japanese)</span>
                                </a>
                                <a href="javascript:void(0)" class="language-option" data-lang="ko" data-flag="kr">
                                    <img src="https://flagcdn.com/w40/kr.png" alt="Korean">
                                    <span>한국어 (Korean)</span>
                                </a>
                                <a href="javascript:void(0)" class="language-option" data-lang="fr" data-flag="fr">
                                    <img src="https://flagcdn.com/w40/fr.png" alt="French">
                                    <span>Français (French)</span>
                                </a>
                                <a href="javascript:void(0)" class="language-option" data-lang="es" data-flag="es">
                                    <img src="https://flagcdn.com/w40/es.png" alt="Spanish">
                                    <span>Español (Spanish)</span>
                                </a>
                                <a href="javascript:void(0)" class="language-option" data-lang="de" data-flag="de">
                                    <img src="https://flagcdn.com/w40/de.png" alt="German">
                                    <span>Deutsch (German)</span>
                                </a>
                                <a href="javascript:void(0)" class="language-option" data-lang="ru" data-flag="ru">
                                    <img src="https://flagcdn.com/w40/ru.png" alt="Russian">
                                    <span>Русский (Russian)</span>
                                </a>
                                <a href="javascript:void(0)" class="language-option" data-lang="pt" data-flag="pt">
                                    <img src="https://flagcdn.com/w40/pt.png" alt="Portuguese">
                                    <span>Português (Portuguese)</span>
                                </a>
                                <a href="javascript:void(0)" class="language-option" data-lang="hi" data-flag="in">
                                    <img src="https://flagcdn.com/w40/in.png" alt="Hindi">
                                    <span>हिन्दी (Hindi)</span>
                                </a>
                                <a href="javascript:void(0)" class="language-option" data-lang="th" data-flag="th">
                                    <img src="https://flagcdn.com/w40/th.png" alt="Thai">
                                    <span>ไทย (Thai)</span>
                                </a>
                                <a href="javascript:void(0)" class="language-option" data-lang="vi" data-flag="vn">
                                    <img src="https://flagcdn.com/w40/vn.png" alt="Vietnamese">
                                    <span>Tiếng Việt (Vietnamese)</span>
                                </a>
                            </div>
                        </div>
                        
                        <div class="topbar-item me-4">
                            <i class="fas fa-envelope"></i>
                            <span>{{ setting('contact_email', 'info@akperkbn.ac.id') }}</span>
                        </div>
                        <div class="topbar-item me-4">
                            <i class="fas fa-phone-alt"></i>
                            <span>{{ setting('contact_phone', '(0293) 3149517') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="topbar-right d-flex align-items-center justify-content-md-end">
                        @php
                            $topbarMenus = \App\Models\Menu::active()->topbar()->parent()->orderBy('order')->get();
                        @endphp
                        @foreach($topbarMenus as $menu)
                            <a href="{{ $menu->url }}" class="topbar-link" target="{{ $menu->target ?? '_self' }}">
                                {{ $menu->title }}
                            </a>
                        @endforeach
                        
                        <!-- Hidden Google Translate Element -->
                        <div id="google_translate_element"></div>
                        
                        <div class="topbar-social">
                            @php
                                $socialMedia = [
                                    'facebook_url' => ['icon' => 'fab fa-facebook-f', 'label' => 'Facebook'],
                                    'twitter_url' => ['icon' => 'fab fa-twitter', 'label' => 'Twitter'],
                                    'instagram_url' => ['icon' => 'fab fa-instagram', 'label' => 'Instagram'],
                                    'threads_url' => ['icon' => 'fab fa-square-threads', 'label' => 'Threads'],
                                    'youtube_url' => ['icon' => 'fab fa-youtube', 'label' => 'YouTube'],
                                    'linkedin_url' => ['icon' => 'fab fa-linkedin-in', 'label' => 'LinkedIn'],
                                    'tiktok_url' => ['icon' => 'fab fa-tiktok', 'label' => 'TikTok'],
                                ];
                            @endphp
                            
                            @foreach($socialMedia as $key => $social)
                                @if(setting($key))
                                    <a href="{{ setting($key) }}" 
                                       target="_blank" 
                                       class="social-icon" 
                                       title="{{ $social['label'] }}">
                                        <i class="{{ $social['icon'] }}"></i>
                                    </a>
                                @endif
                            @endforeach
                            
                            @if(setting('whatsapp_number'))
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp_number')) }}" 
                                   target="_blank" 
                                   class="social-icon"
                                   title="WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-main">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                @if(setting('site_logo'))
                    <img src="{{ asset('storage/'.setting('site_logo')) }}" 
                         alt="{{ setting('site_name', 'KAMPUS') }}" 
                         style="max-height: 40px; margin-right: 10px;">
                @endif
                {{ setting('site_name', 'KAMPUS') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    
                    @php
                        // Load all active main menus
                        $allMainMenus = \App\Models\Menu::where('is_active', true)
                            ->where('menu_group', 'main')
                            ->orderBy('order')
                            ->get();
                        
                        // Get only root menus
                        $mainMenus = $allMainMenus->whereNull('parent_id');
                        
                        // FIXED render function - Bootstrap 5 compatible
                        function renderMenuItem($menu, $allMenus, $level = 0) {
                            $children = $allMenus->where('parent_id', $menu->id)->where('is_active', true);
                            $hasChildren = $children->count() > 0;
                            
                            if ($level === 0) {
                                // Top level menu
                                if ($hasChildren) {
                                    ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><?= e($menu->title) ?></a>
                                        <ul class="dropdown-menu">
                                            <?php foreach ($children as $child) {
                                                renderMenuItem($child, $allMenus, $level + 1);
                                            } ?>
                                        </ul>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= e($menu->url ?: '#') ?>"><?= e($menu->title) ?></a>
                                    </li>
                                    <?php
                                }
                            } else {
                                // Submenu (level 1+)
                                if ($hasChildren) {
                                    ?>
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item" href="#"><?= e($menu->title) ?></a>
                                        <ul class="dropdown-menu">
                                            <?php foreach ($children as $child) {
                                                renderMenuItem($child, $allMenus, $level + 1);
                                            } ?>
                                        </ul>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li><a class="dropdown-item" href="<?= e($menu->url ?: '#') ?>"><?= e($menu->title) ?></a></li>
                                    <?php
                                }
                            }
                        }
                    @endphp
                    
                    @foreach($mainMenus as $menu)
                        @php renderMenuItem($menu, $allMainMenus); @endphp
                    @endforeach
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('pimpinan*') ? 'active' : '' }}" href="{{ route('pimpinan') }}">Pimpinan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('news*') ? 'active' : '' }}" href="{{ route('news.index') }}">Berita</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <!-- About Section -->
                <div class="col-md-3 mb-3">
                    <h5>{{ setting('site_name', 'KAMPUS') }}</h5>
                    <p style="color: rgba(255, 255, 255, 0.85);">{{ setting('site_description', '') }}</p>
                </div>
                
                <!-- Dynamic Footer Sections -->
                @php
                    $footerSections = \App\Models\FooterSection::with('activeLinks')->active()->ordered()->get();
                @endphp
                
                @foreach($footerSections->take(1) as $section)
                <div class="col-md-2 mb-3">
                    <h5>{{ $section->title }}</h5>
                    @if($section->activeLinks->count() > 0)
                        <ul class="list-unstyled">
                            @foreach($section->activeLinks as $link)
                                <li>
                                    <a href="{{ $link->url }}" {{ $link->open_new_tab ? 'target="_blank"' : '' }}>
                                        {{ $link->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                @endforeach
                
                <!-- Contact Section -->
                <div class="col-md-3 mb-3">
                    <h5>Kontak Kami</h5>
                    @if(setting('contact_address'))
                    <p style="color: rgba(255, 255, 255, 0.85);" class="mb-1">
                        <i class="fas fa-map-marker-alt me-2"></i>{{ setting('contact_address') }}
                    </p>
                    @endif
                    @if(setting('contact_phone'))
                    <p style="color: rgba(255, 255, 255, 0.85);" class="mb-1">
                        <i class="fas fa-phone me-2"></i>{{ setting('contact_phone') }}
                    </p>
                    @endif
                    @if(setting('contact_email'))
                    <p style="color: rgba(255, 255, 255, 0.85);" class="mb-0">
                        <i class="fas fa-envelope me-2"></i>{{ setting('contact_email') }}
                    </p>
                    @endif
                </div>

                <!-- Social Media Section -->
                <div class="col-md-4 mb-3">
                    <h5>Ikuti Kami</h5>
                    <div class="footer-social mt-3">
                        @php
                            $socialMedia = [
                                'facebook_url' => ['icon' => 'fab fa-facebook-f', 'label' => 'Facebook'],
                                'twitter_url' => ['icon' => 'fab fa-twitter', 'label' => 'Twitter'],
                                'instagram_url' => ['icon' => 'fab fa-instagram', 'label' => 'Instagram'],
                                'threads_url' => ['icon' => 'fab fa-square-threads', 'label' => 'Threads'],
                                'youtube_url' => ['icon' => 'fab fa-youtube', 'label' => 'YouTube'],
                                'linkedin_url' => ['icon' => 'fab fa-linkedin-in', 'label' => 'LinkedIn'],
                                'tiktok_url' => ['icon' => 'fab fa-tiktok', 'label' => 'TikTok'],
                            ];
                        @endphp
                        
                        @foreach($socialMedia as $key => $social)
                            @if(setting($key))
                                <a href="{{ setting($key) }}" 
                                   target="_blank" 
                                   class="footer-social-icon" 
                                   title="{{ $social['label'] }}">
                                    <i class="{{ $social['icon'] }}"></i>
                                </a>
                            @endif
                        @endforeach
                        
                        @if(setting('whatsapp_number'))
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp_number')) }}" 
                               target="_blank" 
                               class="footer-social-icon"
                               title="WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            
            <hr class="bg-light">
            
            <div class="text-center text-muted">
                <p class="mb-0">&copy; {{ date('Y') }} {{ setting('site_name', 'Kampus') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Google Translate Script - MUST BE BEFORE DOMContentLoaded -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'en,id,ar,zh-CN,ja,ko,fr,es,de,ru,pt,hi,th,vi',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
    <script>
        // Custom Language Selector Logic
        document.addEventListener('DOMContentLoaded', function() {
            const languageBtn = document.getElementById('languageBtn');
            const languageDropdown = document.getElementById('languageDropdown');
            const currentFlag = document.getElementById('currentFlag');
            const currentLang = document.getElementById('currentLang');
            const languageOptions = document.querySelectorAll('.language-option');
            
            // Toggle dropdown
            if (languageBtn) {
                languageBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    languageDropdown.classList.toggle('show');
                });
            }
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (languageBtn && !languageBtn.contains(e.target) && !languageDropdown.contains(e.target)) {
                    languageDropdown.classList.remove('show');
                }
            });
            
            // Language selection
            languageOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    const lang = this.getAttribute('data-lang');
                    const flag = this.getAttribute('data-flag');
                    const langName = this.querySelector('span').textContent;
                    
                    // Update button display
                    currentFlag.src = `https://flagcdn.com/w40/${flag}.png`;
                    currentLang.textContent = langName.split(' ')[0];
                    
                    // Close dropdown
                    languageDropdown.classList.remove('show');
                    
                    // Trigger Google Translate
                    triggerGoogleTranslate(lang);
                });
            });
            
            function triggerGoogleTranslate(lang) {
                console.log('Attempting to translate to:', lang);
                
                // Method 1: Try to find and trigger the select element
                let attempts = 0;
                const maxAttempts = 50; // 5 seconds
                
                const checkGoogleTranslate = setInterval(function() {
                    attempts++;
                    const selectElement = document.querySelector('.goog-te-combo');
                    
                    if (selectElement) {
                        console.log('Google Translate select found, changing to:', lang);
                        clearInterval(checkGoogleTranslate);
                        selectElement.value = lang;
                        selectElement.dispatchEvent(new Event('change'));
                        
                        // Also try to trigger with different events
                        setTimeout(() => {
                            selectElement.dispatchEvent(new Event('click'));
                        }, 100);
                    } else if (attempts >= maxAttempts) {
                        console.error('Google Translate widget not found after', maxAttempts * 100, 'ms');
                        clearInterval(checkGoogleTranslate);
                    }
                }, 100);
            }
        });
        
        // Multilevel dropdown hover for desktop
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth >= 992) {
                // Desktop only - enable hover
                const dropdowns = document.querySelectorAll('.navbar .dropdown');
                const submenus = document.querySelectorAll('.navbar .dropdown-submenu');
                
                dropdowns.forEach(dropdown => {
                    dropdown.addEventListener('mouseenter', function() {
                        this.querySelector('.dropdown-menu')?.classList.add('show');
                    });
                    dropdown.addEventListener('mouseleave', function() {
                        this.querySelector('.dropdown-menu')?.classList.remove('show');
                    });
                });
                
                submenus.forEach(submenu => {
                    submenu.addEventListener('mouseenter', function() {
                        this.querySelector('.dropdown-menu')?.classList.add('show');
                    });
                    submenu.addEventListener('mouseleave', function() {
                        this.querySelector('.dropdown-menu')?.classList.remove('show');
                    });
                });
            }
        });
    </script>
    
    <!-- Back to Top Button -->
    <button id="backToTop" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- WhatsApp Float Button -->
    @if(setting('whatsapp_number') && setting('whatsapp_float_enabled', '1') == '1')
    @php
        $whatsappMessage = setting('whatsapp_message', 'Halo, saya ingin bertanya tentang {site_name}');
        $whatsappMessage = str_replace('{site_name}', setting('site_name'), $whatsappMessage);
    @endphp
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp_number')) }}?text={{ urlencode($whatsappMessage) }}" 
       class="whatsapp-float" 
       target="_blank"
       aria-label="Chat WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
    @endif

    <script>
        // Back to Top Button Script
        (function() {
            const backToTopButton = document.getElementById('backToTop');
            
            if (backToTopButton) {
                // Show/hide button on scroll
                window.addEventListener('scroll', function() {
                    if (window.pageYOffset > 300) {
                        backToTopButton.classList.add('show');
                    } else {
                        backToTopButton.classList.remove('show');
                    }
                });

                // Scroll to top on click
                backToTopButton.addEventListener('click', function() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }
        })();

        // Copy to clipboard function for share buttons
        function copyToClipboard(text) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(function() {
                    alert('Link berhasil disalin!');
                }).catch(function(err) {
                    console.error('Failed to copy: ', err);
                });
            } else {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                document.body.appendChild(textArea);
                textArea.select();
                try {
                    document.execCommand('copy');
                    alert('Link berhasil disalin!');
                } catch (err) {
                    console.error('Failed to copy: ', err);
                }
                document.body.removeChild(textArea);
            }
        }
    </script>
    
    @yield('scripts')
</body>
</html>
