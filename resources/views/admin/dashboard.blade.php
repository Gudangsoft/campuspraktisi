@extends('admin.layout')

@section('title','Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <i class="fas fa-newspaper"></i>
            </div>
            <h3>{{ $stats['total_news'] }}</h3>
            <p class="mb-0">Total Berita</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3>{{ $stats['published_news'] }}</h3>
            <p class="mb-0">Berita Published</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                <i class="fas fa-eye"></i>
            </div>
            <h3>{{ number_format($stats['total_views']) }}</h3>
            <p class="mb-0">Total Views</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
                <i class="fas fa-folder"></i>
            </div>
            <h3>{{ $stats['total_categories'] }}</h3>
            <p class="mb-0">Kategori</p>
        </div>
    </div>
</div>

<!-- Quick Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0"><i class="fas fa-chart-pie me-2 text-primary"></i>Status Berita</h6>
            </div>
            <div class="row text-center">
                <div class="col-6">
                    <div class="p-3 bg-light rounded">
                        <h4 class="text-success mb-1">{{ $stats['published_news'] }}</h4>
                        <small class="text-muted">Published</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 bg-light rounded">
                        <h4 class="text-warning mb-1">{{ $stats['draft_news'] }}</h4>
                        <small class="text-muted">Draft</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Quick Info</h6>
            </div>
            <div class="row text-center">
                <div class="col-4">
                    <div class="p-3 bg-light rounded">
                        <h4 class="text-primary mb-1">{{ $stats['total_menus'] }}</h4>
                        <small class="text-muted">Menus</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-3 bg-light rounded">
                        <h4 class="text-info mb-1">{{ $stats['total_categories'] }}</h4>
                        <small class="text-muted">Categories</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-3 bg-light rounded">
                        <h4 class="text-success mb-1">1</h4>
                        <small class="text-muted">Admin</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Latest & Popular News -->
<div class="row g-3">
    <div class="col-md-6">
        <div class="content-card">
            <div class="content-card-header">
                <h5><i class="fas fa-clock me-2"></i>Berita Terbaru</h5>
                <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            
            @forelse($latest_news as $news)
                <div class="d-flex mb-3 pb-3 border-bottom">
                    <div class="flex-shrink-0">
                        @if($news->image)
                            <img src="{{ asset('storage/'.$news->image) }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;" alt="">
                        @else
                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-image text-white"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">{{ Str::limit($news->title, 50) }}</h6>
                        <small class="text-muted">
                            <i class="fas fa-user me-1"></i>{{ $news->user->name }}
                            <span class="mx-2">•</span>
                            <i class="fas fa-calendar me-1"></i>{{ $news->created_at->diffForHumans() }}
                        </small>
                        <div class="mt-1">
                            <span class="badge {{ $news->status == 'published' ? 'bg-success' : 'bg-warning' }}">{{ ucfirst($news->status) }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center py-3">Belum ada berita</p>
            @endforelse
        </div>
    </div>

    <div class="col-md-6">
        <div class="content-card">
            <div class="content-card-header">
                <h5><i class="fas fa-fire me-2"></i>Berita Populer</h5>
                <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            
            @forelse($popular_news as $news)
                <div class="d-flex mb-3 pb-3 border-bottom">
                    <div class="flex-shrink-0">
                        @if($news->image)
                            <img src="{{ asset('storage/'.$news->image) }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;" alt="">
                        @else
                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-image text-white"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">{{ Str::limit($news->title, 50) }}</h6>
                        <small class="text-muted">
                            <i class="fas fa-folder me-1"></i>{{ $news->category->name }}
                            <span class="mx-2">•</span>
                            <i class="fas fa-eye me-1"></i>{{ number_format($news->views) }} views
                        </small>
                        <div class="mt-1">
                            <span class="badge bg-info">{{ $news->published_at?->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center py-3">Belum ada berita</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-3 mt-2">
    <div class="col-12">
        <div class="content-card">
            <div class="content-card-header">
                <h5><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            </div>
            <div class="row g-3">
                <div class="col-md-3">
                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary w-100 py-3">
                        <i class="fas fa-plus-circle fa-2x d-block mb-2"></i>
                        Buat Berita Baru
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.news-categories.create') }}" class="btn btn-info w-100 py-3">
                        <i class="fas fa-folder-plus fa-2x d-block mb-2"></i>
                        Tambah Kategori
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.menus.create') }}" class="btn btn-success w-100 py-3">
                        <i class="fas fa-bars fa-2x d-block mb-2"></i>
                        Tambah Menu
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary w-100 py-3">
                        <i class="fas fa-cog fa-2x d-block mb-2"></i>
                        Pengaturan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
