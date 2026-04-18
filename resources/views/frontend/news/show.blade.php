@extends('frontend.layout')

@section('title', $item->title.' - '.setting('site_name'))

@section('content')
<div class="bg-light py-4 mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('news.index') }}">Berita</a></li>
                <li class="breadcrumb-item active">{{ $item->title }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="news-article">
                <h1 class="article-title mb-3">{{ $item->title }}</h1>
                
                <div class="article-meta mb-4">
                    <span class="meta-item me-3">
                        <i class="far fa-calendar"></i> {{ $item->published_at->format('d F Y') }}
                    </span>
                    <span class="meta-item me-3">
                        <i class="far fa-user"></i> {{ $item->user->name }}
                    </span>
                    <span class="meta-item me-3">
                        <i class="far fa-folder"></i> 
                        <a href="{{ route('news.category', $item->category->slug) }}">{{ $item->category->name }}</a>
                    </span>
                    <span class="meta-item">
                        <i class="far fa-eye"></i> {{ $item->views }} views
                    </span>
                </div>
                
                @if($item->image)
                    <img src="{{ asset('storage/'.$item->image) }}" 
                         class="img-fluid rounded mb-4 w-100 shadow-sm" 
                         alt="{{ $item->title }}"
                         style="max-height: 500px; object-fit: cover;">
                @endif
                
                <div class="article-content" style="line-height: 1.8; font-size: 1.1rem;">
                    {!! $item->content !!}
                </div>
                
                <!-- Social Share Section -->
                <div class="social-share">
                    <h5 class="social-share-title">
                        <i class="fas fa-share-alt me-2"></i>Bagikan Artikel Ini
                    </h5>
                    <div class="social-share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                           target="_blank" 
                           class="btn-social-share btn-facebook">
                            <i class="fab fa-facebook-f"></i>
                            <span>Facebook</span>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($item->title) }}" 
                           target="_blank" 
                           class="btn-social-share btn-twitter">
                            <i class="fab fa-twitter"></i>
                            <span>Twitter</span>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($item->title.' - '.url()->current()) }}" 
                           target="_blank" 
                           class="btn-social-share btn-whatsapp-share">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp</span>
                        </a>
                        <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($item->title) }}" 
                           target="_blank" 
                           class="btn-social-share btn-telegram">
                            <i class="fab fa-telegram-plane"></i>
                            <span>Telegram</span>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($item->title) }}" 
                           target="_blank" 
                           class="btn-social-share btn-linkedin">
                            <i class="fab fa-linkedin-in"></i>
                            <span>LinkedIn</span>
                        </a>
                        <button type="button" 
                                onclick="copyToClipboard('{{ url()->current() }}')" 
                                class="btn-social-share btn-copy-link">
                            <i class="fas fa-link"></i>
                            <span>Salin Link</span>
                        </button>
                    </div>
                </div>
            </article>
            
            @if($related->count() > 0)
                <hr class="my-5">
                <h4 class="mb-4"><i class="fas fa-newspaper me-2"></i>Berita Terkait</h4>
                <div class="row g-3">
                    @foreach($related as $rel)
                        <div class="col-md-4">
                            <div class="card card-news h-100 shadow-sm">
                                @if($rel->image)
                                    <img src="{{ asset('storage/'.$rel->image) }}" 
                                         class="card-img-top" 
                                         alt="{{ $rel->title }}" 
                                         style="height:150px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height:150px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title">{{ Str::limit($rel->title, 60) }}</h6>
                                    <p class="text-muted small mb-2">
                                        <i class="far fa-calendar me-1"></i>{{ $rel->published_at->format('d M Y') }}
                                    </p>
                                    <a href="{{ route('news.show', $rel->slug) }}" class="btn btn-sm btn-outline-primary">
                                        Baca Selengkapnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Latest News Widget -->
            <div class="sidebar-widget mb-4">
                <h5 class="widget-title">
                    <i class="fas fa-newspaper me-2"></i>Berita Terbaru
                </h5>
                <div class="widget-content">
                    @foreach($latestNews as $news)
                        <div class="sidebar-news-item mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="d-flex">
                                @if($news->image)
                                    <img src="{{ asset('storage/'.$news->image) }}" 
                                         class="rounded me-3" 
                                         alt="{{ $news->title }}"
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 80px; height: 80px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <a href="{{ route('news.show', $news->slug) }}" class="text-dark text-decoration-none">
                                            {{ Str::limit($news->title, 60) }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="far fa-calendar me-1"></i>{{ $news->published_at->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Popular News Widget -->
            <div class="sidebar-widget mb-4">
                <h5 class="widget-title">
                    <i class="fas fa-fire me-2"></i>Berita Populer
                </h5>
                <div class="widget-content">
                    @foreach($popularNews as $index => $news)
                        <div class="popular-news-item mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="d-flex align-items-start">
                                <span class="badge bg-primary me-2 mt-1" style="font-size: 1rem;">{{ $index + 1 }}</span>
                                <div>
                                    <h6 class="mb-1">
                                        <a href="{{ route('news.show', $news->slug) }}" class="text-dark text-decoration-none">
                                            {{ Str::limit($news->title, 70) }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="far fa-eye me-1"></i>{{ $news->views }} views
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Categories Widget -->
            <div class="sidebar-widget mb-4">
                <h5 class="widget-title">
                    <i class="fas fa-folder me-2"></i>Kategori
                </h5>
                <div class="widget-content">
                    @foreach($categories as $category)
                        <a href="{{ route('news.category', $category->slug) }}" 
                           class="category-link d-flex justify-content-between align-items-center mb-2 p-2 rounded text-decoration-none {{ $item->category_id == $category->id ? 'active' : '' }}">
                            <span>
                                <i class="fas fa-angle-right me-2"></i>{{ $category->name }}
                            </span>
                            <span class="badge bg-secondary">{{ $category->news_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
            
            <!-- Tags Widget (if you want to add tags in the future) -->
            <div class="sidebar-widget">
                <h5 class="widget-title">
                    <i class="fas fa-tags me-2"></i>Info Penting
                </h5>
                <div class="widget-content">
                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="fas fa-info-circle me-2"></i>Informasi
                        </h6>
                        <p class="mb-0 small">
                            Untuk informasi lebih lanjut, silakan hubungi kami melalui email atau telepon yang tertera di halaman kontak.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .news-article {
        background: #fff;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .article-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a2e;
        line-height: 1.3;
    }
    
    .article-meta {
        padding: 1rem 0;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .meta-item {
        color: #666;
        font-size: 0.9rem;
    }
    
    .meta-item i {
        color: #0056b3;
    }
    
    .meta-item a {
        color: #0056b3;
        text-decoration: none;
    }
    
    .meta-item a:hover {
        text-decoration: underline;
    }
    
    .article-content {
        font-size: 1.05rem;
        color: #333;
    }
    
    .share-section {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
    }
    
    /* Sidebar Widgets */
    .sidebar-widget {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .widget-title {
        background: linear-gradient(135deg, #003d82 0%, #0056b3 100%);
        color: #fff;
        padding: 1rem 1.25rem;
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .widget-content {
        padding: 1.25rem;
    }
    
    .sidebar-news-item h6 a {
        font-size: 0.95rem;
        line-height: 1.4;
        transition: color 0.3s ease;
    }
    
    .sidebar-news-item h6 a:hover {
        color: #0056b3 !important;
    }
    
    .popular-news-item h6 a {
        font-size: 0.9rem;
        line-height: 1.4;
        transition: color 0.3s ease;
    }
    
    .popular-news-item h6 a:hover {
        color: #0056b3 !important;
    }
    
    .category-link {
        color: #333;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    
    .category-link:hover {
        background: #f8f9fa;
        border-color: #0056b3;
        color: #0056b3;
        padding-left: 1rem !important;
    }
    
    .category-link.active {
        background: linear-gradient(135deg, #003d82 0%, #0056b3 100%);
        color: #fff;
    }
    
    .category-link.active .badge {
        background: #fff !important;
        color: #0056b3;
    }
    
    .card-news {
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
    }
    
    .card-news:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .article-title {
            font-size: 1.5rem;
        }
        
        .news-article {
            padding: 1.5rem;
        }
    }
</style>
@endsection
