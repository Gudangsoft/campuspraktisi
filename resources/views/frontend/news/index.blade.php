@extends('frontend.layout')

@section('title', 'Berita - '.setting('site_name'))

@section('content')
<div class="bg-primary text-white py-5 mb-5">
    <div class="container">
        <h1 class="mb-0">Berita & Informasi</h1>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <div class="col-md-9">
            <div class="row g-4">
                @forelse($news as $item)
                    <div class="col-md-6">
                        <div class="card card-news">
                            @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}" class="card-img-top" alt="{{ $item->title }}">
                            @else
                                <img src="https://via.placeholder.com/400x200?text={{ urlencode($item->title) }}" class="card-img-top" alt="{{ $item->title }}">
                            @endif
                            <div class="card-body">
                                <span class="badge bg-primary mb-2">{{ $item->category->name }}</span>
                                <h5 class="card-title">{{ Str::limit($item->title, 60) }}</h5>
                                <p class="text-muted small mb-2">
                                    <i class="far fa-calendar"></i> {{ $item->published_at->format('d M Y') }}
                                    <span class="ms-2"><i class="far fa-eye"></i> {{ $item->views }}</span>
                                </p>
                                <p class="card-text">{{ Str::limit($item->excerpt ?? strip_tags($item->content), 120) }}</p>
                                <a href="{{ route('news.show', $item->slug) }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">Belum ada berita yang dipublikasikan.</div>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-4">
                {{ $news->links() }}
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Kategori</h5>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($categories as $cat)
                        <a href="{{ route('news.category', $cat->slug) }}" class="list-group-item list-group-item-action">
                            {{ $cat->name }}
                            <span class="badge bg-secondary float-end">{{ $cat->news_count ?? $cat->news->count() }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
