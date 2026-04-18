@extends('frontend.layout')

@section('title', setting('site_name'))

@section('content')
<!-- Hero Slider Section -->
@if($sliders->count() > 0)
<section class="hero-slider mb-5">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($sliders as $index => $slider)
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" 
                    class="{{ $index === 0 ? 'active' : '' }}" 
                    aria-current="{{ $index === 0 ? 'true' : 'false' }}" 
                    aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($sliders as $index => $slider)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/' . $slider->image) }}" class="d-block w-100" alt="{{ $slider->title ?? 'Slider Image' }}">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center h-100">
                    <div class="slider-content text-center">
                        @if($slider->title)
                        <h1 class="display-3 fw-bold text-white mb-3" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                            {{ $slider->title }}
                        </h1>
                        @endif
                        @if($slider->description)
                        <p class="lead text-white mb-4" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.5); font-size: 1.25rem;">
                            {{ $slider->description }}
                        </p>
                        @endif
                        @if($slider->button_text && $slider->button_url)
                        <a href="{{ $slider->button_url }}" class="btn btn-light btn-lg px-5 py-3">
                            {{ $slider->button_text }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if($sliders->count() > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        @endif
    </div>
</section>
@else
<!-- Fallback Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <h1>{{ setting('site_name', 'Akademi Keperawatan') }}</h1>
        <p class="lead">{{ setting('site_tagline', 'Excellence in Nursing Education') }}</p>
        <a href="{{ route('news.index') }}" class="btn btn-light btn-lg mt-3">Lihat Berita Terbaru</a>
    </div>
</section>
@endif

<!-- Greeting Section -->
@if(isset($greetings) && $greetings->count() > 0)
<section class="greeting-section py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($greetings as $greeting)
            <div class="col-lg-6">
                <div class="greeting-card h-100">
                    <!-- Card Header with Title -->
                    <div class="greeting-card-header">
                        <h3 class="greeting-card-title">{{ $greeting->section_name }}</h3>
                    </div>
                    
                    <!-- Card Image -->
                    @if($greeting->image)
                    <div class="greeting-card-image">
                        <img src="{{ Storage::url($greeting->image) }}" 
                             alt="{{ $greeting->title }}" 
                             class="w-100">
                        <div class="greeting-overlay"></div>
                    </div>
                    @else
                    <div class="greeting-card-image greeting-placeholder">
                        <div class="placeholder-content">
                            <i class="fas fa-user-tie fa-4x mb-3"></i>
                            <h4>{{ $greeting->title }}</h4>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Card Content -->
                    <div class="greeting-card-body">
                        <h4 class="greeting-title mb-3">{{ $greeting->title }}</h4>
                        
                        @if($greeting->subtitle)
                        <p class="greeting-subtitle text-muted mb-3">{{ $greeting->subtitle }}</p>
                        @endif
                        
                        <div class="greeting-content">
                            <p class="text-muted" style="line-height: 1.8; text-align: justify;">
                                {{ Str::limit($greeting->content, 350) }}
                            </p>
                        </div>
                        
                        @if($greeting->person_name || $greeting->person_title)
                        <div class="greeting-author mt-4">
                            <div class="author-info">
                                @if($greeting->person_name)
                                <p class="author-name mb-1">{{ $greeting->person_name }}</p>
                                @endif
                                @if($greeting->person_title)
                                <p class="author-title text-muted mb-0">{{ $greeting->person_title }}</p>
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        <!-- Read More Button -->
                        <div class="mt-4">
                            <a href="javascript:void(0)" 
                               class="btn-greeting-more" 
                               data-bs-toggle="modal" 
                               data-bs-target="#greetingModal{{ $greeting->id }}">
                                Selengkapnya 
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal for Full Content -->
            <div class="modal fade" id="greetingModal{{ $greeting->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-bold">{{ $greeting->section_name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if($greeting->image)
                            <img src="{{ Storage::url($greeting->image) }}" 
                                 alt="{{ $greeting->title }}" 
                                 class="img-fluid rounded mb-4 w-100"
                                 style="max-height: 400px; object-fit: cover;">
                            @endif
                            
                            <h4 class="fw-bold mb-3">{{ $greeting->title }}</h4>
                            
                            @if($greeting->subtitle)
                            <p class="text-muted mb-4"><em>{{ $greeting->subtitle }}</em></p>
                            @endif
                            
                            <div class="greeting-full-content" style="line-height: 2; text-align: justify;">
                                {!! nl2br(e($greeting->content)) !!}
                            </div>
                            
                            @if($greeting->person_name || $greeting->person_title)
                            <div class="mt-5 pt-4 border-top">
                                <div class="text-end">
                                    @if($greeting->person_name)
                                    <p class="fw-bold mb-1 fs-5">{{ $greeting->person_name }}</p>
                                    @endif
                                    @if($greeting->person_title)
                                    <p class="text-muted mb-0">{{ $greeting->person_title }}</p>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Prodi Unggulan Section -->
@if(isset($prodiUnggulan) && $prodiUnggulan->count() > 0)
<section class="prodi-unggulan-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Program Studi Unggulan</h2>
            <p class="text-muted">Pilihan program studi terbaik untuk masa depan Anda</p>
        </div>
        <div class="row g-4">
            @foreach($prodiUnggulan as $prodi)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4" style="transition: transform 0.3s;">
                    <div class="card-img-top mb-3">
                        @if($prodi->gambar)
                            <img src="{{ asset('storage/'.$prodi->gambar) }}" alt="{{ $prodi->nama }}" style="width: 100px; height: 100px; object-fit: contain; border-radius: 50%;">
                        @else
                            <div class="mx-auto bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <i class="fas fa-graduation-cap text-white fa-3x"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <h4 class="card-title fw-bold">{{ $prodi->nama }}</h4>
                        <p class="card-text text-muted mt-3">{{ Str::limit($prodi->deskripsi, 120) }}</p>
                    </div>
                    @if($prodi->link)
                    <div class="card-footer bg-white border-0 pt-3">
                        <a href="{{ $prodi->link }}" target="_blank" class="btn btn-outline-primary rounded-pill px-4">Selengkapnya</a>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Why Choose Us Section -->
@include('components.why-choose-us')

<!-- Advantages Section -->
@include('components.advantages')

<!-- Featured News Section -->
@if($featuredNews->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0">Berita Utama</h2>
            <a href="{{ route('news.index') }}" class="btn btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="row">
            @foreach($featuredNews as $news)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 featured-card">
                    @if($news->image)
                    <div class="position-relative">
                        <img src="{{ asset('storage/'.$news->image) }}" class="card-img-top" alt="{{ $news->title }}" style="height: 250px; object-fit: cover;">
                        <span class="badge bg-danger position-absolute top-0 start-0 m-3">
                            <i class="fas fa-star me-1"></i>Utama
                        </span>
                    </div>
                    @endif
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge bg-primary">{{ $news->category->name }}</span>
                            <small class="text-muted ms-2">
                                <i class="far fa-calendar me-1"></i>{{ $news->published_at?->format('d M Y') }}
                            </small>
                        </div>
                        <h5 class="card-title">
                            <a href="{{ route('news.show', $news->slug) }}" class="text-decoration-none text-dark">
                                {{ $news->title }}
                            </a>
                        </h5>
                        <p class="card-text text-muted">{{ Str::limit($news->excerpt, 120) }}</p>
                        @if($news->tags->count() > 0)
                        <div class="mb-3">
                            @foreach($news->tags as $tag)
                                <span class="badge bg-secondary me-1">
                                    <i class="fas fa-tag me-1"></i>{{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                        @endif
                        <a href="{{ route('news.show', $news->slug) }}" class="btn btn-sm btn-outline-primary">
                            Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Latest News Section -->
<section class="container mb-5">
    <h2 class="section-title">Berita Terbaru</h2>
    
    <div class="row g-3">
        @forelse($latestNews->take(6) as $news)
            <div class="col-md-6 col-lg-4">
                <div class="card news-card h-100 border-0 shadow-sm">
                    @if($news->image)
                        <img src="{{ asset('storage/'.$news->image) }}" class="card-img-top" alt="{{ $news->title }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="fas fa-newspaper fa-3x text-white opacity-50"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge bg-primary">{{ $news->category->name }}</span>
                            <small class="text-muted ms-2">
                                <i class="far fa-calendar me-1"></i>{{ $news->published_at->format('d M Y') }}
                            </small>
                        </div>
                        <h5 class="card-title">
                            <a href="{{ route('news.show', $news->slug) }}" class="text-decoration-none text-dark">
                                {{ Str::limit($news->title, 80) }}
                            </a>
                        </h5>
                        <p class="card-text text-muted">{{ Str::limit($news->excerpt ?? strip_tags($news->content), 120) }}</p>
                        @if($news->tags->count() > 0)
                        <div class="mb-2">
                            @foreach($news->tags as $tag)
                                <span class="badge bg-secondary me-1" style="font-size: 0.75rem;">
                                    <i class="fas fa-tag me-1"></i>{{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                        @endif
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                <i class="far fa-eye me-1"></i>{{ $news->views }}
                            </small>
                            <a href="{{ route('news.show', $news->slug) }}" class="btn btn-sm btn-outline-primary">
                                Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Belum ada berita yang dipublikasikan.</div>
            </div>
        @endforelse
    </div>
    
    @if($latestNews->count() > 0)
        <div class="text-center mt-4">
            <a href="{{ route('news.index') }}" class="btn btn-primary">
                Lihat Semua Berita <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    @endif
</section>

<!-- Gallery Section (Photos & Videos Combined) -->
@if($galleryPhotos->count() > 0 || $galleryVideos->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0">Gallery</h2>
            <div>
                @if($galleryPhotos->count() > 0)
                <a href="{{ route('gallery.photo') }}" class="btn btn-outline-primary me-2">
                    <i class="fas fa-images me-1"></i>Foto
                </a>
                @endif
                @if($galleryVideos->count() > 0)
                <a href="{{ route('gallery.video') }}" class="btn btn-outline-primary">
                    <i class="fas fa-video me-1"></i>Video
                </a>
                @endif
            </div>
        </div>
        
        <div class="row g-3">
            <!-- Photos -->
            @foreach($galleryPhotos->take(4) as $photo)
            <div class="col-6 col-md-3 col-lg-2">
                <div class="gallery-item position-relative" data-bs-toggle="modal" data-bs-target="#photoModal{{ $photo->id }}">
                    <img src="{{ asset('storage/'.$photo->image) }}" 
                         class="img-fluid rounded shadow-sm w-100" 
                         alt="{{ $photo->title }}"
                         style="height: 180px; object-fit: cover;">
                    <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center rounded">
                        <i class="fas fa-search-plus text-white fs-3"></i>
                    </div>
                </div>
                
                <!-- Modal for each photo -->
                <div class="modal fade" id="photoModal{{ $photo->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">{{ $photo->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-0">
                                <img src="{{ asset('storage/'.$photo->image) }}" 
                                     class="img-fluid w-100" 
                                     alt="{{ $photo->title }}"
                                     style="max-height: 80vh; object-fit: contain;">
                            </div>
                            @if($photo->description)
                            <div class="modal-footer border-0 justify-content-center">
                                <p class="text-muted mb-0">{{ $photo->description }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
            <!-- Videos -->
            @foreach($galleryVideos->take(4) as $video)
            <div class="col-6 col-md-3 col-lg-2">
                <div class="gallery-item position-relative" role="button" data-bs-toggle="modal" data-bs-target="#videoModal{{ $video->id }}">
                    <img src="{{ $video->thumbnail_url }}" 
                         class="img-fluid rounded shadow-sm w-100" 
                         alt="{{ $video->title }}"
                         style="height: 180px; object-fit: cover;">
                    <div class="video-badge position-absolute top-0 end-0 m-2">
                        <span class="badge bg-danger">
                            <i class="fab fa-youtube"></i> Video
                        </span>
                    </div>
                    <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center rounded">
                        <div class="btn btn-light btn-lg rounded-circle"
                             style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-play text-danger" style="margin-left: 3px;"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal for Video -->
            <div class="modal fade" id="videoModal{{ $video->id }}" tabindex="-1" aria-labelledby="videoModalLabel{{ $video->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="videoModalLabel{{ $video->id }}">{{ $video->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="ratio ratio-16x9">
                                <iframe src="{{ $video->embed_url }}" 
                                        frameborder="0" 
                                        allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen></iframe>
                            </div>
                        </div>
                        @if($video->description)
                        <div class="modal-footer border-0 justify-content-start">
                            <p class="text-muted mb-0">{{ $video->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Agenda & Pengumuman Section -->
@if(setting('agenda_section_enabled', '1') == '1' || setting('announcement_section_enabled', '1') == '1')
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Agenda -->
            @if(setting('agenda_section_enabled', '1') == '1')
            <div class="col-lg-{{ setting('announcement_section_enabled', '1') == '1' ? '6' : '12' }} mb-4 mb-lg-0">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title mb-0">Agenda</h2>
                    @if($agendas->count() > 0)
                        <a href="#" class="btn btn-outline-primary btn-sm">Selengkapnya</a>
                    @endif
                </div>

                @forelse($agendas as $agenda)
                <div class="agenda-item d-flex mb-3 border-bottom pb-3">
                    <div class="agenda-date text-center flex-shrink-0 me-3">
                        <div class="bg-primary text-white rounded p-3" style="width: 80px;">
                            <div style="font-size: 1.5rem; font-weight: bold; line-height: 1;">
                                {{ $agenda->event_date->format('d') }}
                            </div>
                            <div style="font-size: 0.9rem; text-transform: uppercase;">
                                {{ $agenda->event_date->translatedFormat('M') }}
                            </div>
                        </div>
                    </div>
                    <div class="agenda-content flex-grow-1">
                        <h5 class="mb-1">{{ $agenda->title }}</h5>
                        @if($agenda->description)
                            <p class="text-muted mb-1" style="font-size: 0.9rem;">
                                {{ Str::limit($agenda->description, 100) }}
                            </p>
                        @endif
                        <div class="d-flex gap-3 text-muted" style="font-size: 0.85rem;">
                            @if($agenda->location)
                                <span><i class="fas fa-map-marker-alt me-1"></i>{{ $agenda->location }}</span>
                            @endif
                            @if($agenda->start_time)
                                <span><i class="fas fa-clock me-1"></i>
                                    {{ date('H:i', strtotime($agenda->start_time)) }}
                                    @if($agenda->end_time)
                                        - {{ date('H:i', strtotime($agenda->end_time)) }}
                                    @endif
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-5">
                    <i class="fas fa-calendar-times fa-3x mb-3 d-block opacity-25"></i>
                    <p>Belum ada agenda</p>
                </div>
                @endforelse
            </div>
            @endif

            <!-- Pengumuman -->
            @if(setting('announcement_section_enabled', '1') == '1')
            <div class="col-lg-{{ setting('agenda_section_enabled', '1') == '1' ? '6' : '12' }}">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title mb-0">Pengumuman</h2>
                    @if($announcements->count() > 0)
                        <a href="#" class="btn btn-outline-primary btn-sm">Selengkapnya</a>
                    @endif
                </div>

                @forelse($announcements as $announcement)
                <div class="announcement-item mb-3 border-bottom pb-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="mb-0">
                            @if($announcement->is_important)
                                <span class="badge bg-danger me-2">Penting</span>
                            @endif
                            {{ $announcement->title }}
                        </h5>
                        @if($announcement->category)
                            <span class="badge bg-info">{{ $announcement->category }}</span>
                        @endif
                    </div>
                    <p class="text-muted mb-2" style="font-size: 0.9rem;">
                        {{ Str::limit(strip_tags($announcement->content), 120) }}
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $announcement->published_date->format('d M Y') }}
                        </small>
                        @if($announcement->file)
                            <a href="{{ asset('storage/'.$announcement->file) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-download me-1"></i>Unduh
                            </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-5">
                    <i class="fas fa-bullhorn fa-3x mb-3 d-block opacity-25"></i>
                    <p>Belum ada pengumuman</p>
                </div>
                @endforelse
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Testimonials Section -->
@include('components.testimonials')

<!-- Partners Section -->
@include('components.partners')

<!-- About Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="section-title">Tentang Kami</h2>
                <div>{!! setting('about_us', '<p>Kami adalah institusi pendidikan tinggi yang berkomitmen untuk menghasilkan tenaga kesehatan profesional yang berkualitas.</p><p>Dengan pengalaman bertahun-tahun dalam pendidikan keperawatan, kami menyediakan program akademik yang komprehensif dan fasilitas modern untuk mendukung pembelajaran mahasiswa.</p>') !!}</div>
            </div>
            <div class="col-md-6">
                @php
                    $mapsInput = setting('google_maps_embed');
                    $mapsUrl = '';
                    
                    if ($mapsInput) {
                        // Extract URL from iframe or use direct URL
                        if (str_contains($mapsInput, '<iframe')) {
                            // Extract src from iframe
                            preg_match('/src="([^"]+)"/', $mapsInput, $matches);
                            $mapsUrl = $matches[1] ?? '';
                        } else {
                            // Direct URL
                            $mapsUrl = $mapsInput;
                        }
                    }
                @endphp
                
                @if($mapsUrl)
                    <!-- Google Maps Embed -->
                    <div class="ratio ratio-16x9 rounded shadow">
                        <iframe 
                            src="{{ $mapsUrl }}"
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                @else
                    <!-- Fallback: Default map -->
                    <div class="ratio ratio-16x9 rounded shadow">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.6984887387744!2d112.6244!3d-7.9553!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwNTcnMTkuMSJTIDExMsKwMzcnMjcuOCJF!5e0!3m2!1sen!2sid!4v1234567890"
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Stop video when modal is closed
    document.addEventListener('DOMContentLoaded', function() {
        const videoModals = document.querySelectorAll('[id^="videoModal"]');
        
        videoModals.forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function () {
                const iframe = this.querySelector('iframe');
                if (iframe) {
                    const src = iframe.src;
                    iframe.src = src; // Reload iframe to stop video
                }
            });
        });
    });
</script>
@endsection
