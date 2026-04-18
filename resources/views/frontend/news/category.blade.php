@extends('frontend.layout')

@section('title', $category->name.' - '.setting('site_name'))

@section('content')
<div class="bg-primary text-white py-5 mb-5">
    <div class="container">
        <h1>{{ $category->name }}</h1>
        @if($category->description)
            <p class="lead">{{ $category->description }}</p>
        @endif
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        @forelse($news as $item)
            <div class="col-md-4">
                <div class="card card-news">
                    @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" class="card-img-top" alt="{{ $item->title }}">
                    @else
                        <img src="https://via.placeholder.com/400x200?text={{ urlencode($item->title) }}" class="card-img-top" alt="{{ $item->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ Str::limit($item->title, 60) }}</h5>
                        <p class="text-muted small mb-2">
                            <i class="far fa-calendar"></i> {{ $item->published_at->format('d M Y') }}
                            <span class="ms-2"><i class="far fa-eye"></i> {{ $item->views }}</span>
                        </p>
                        <p class="card-text">{{ Str::limit($item->excerpt ?? strip_tags($item->content), 100) }}</p>
                        <a href="{{ route('news.show', $item->slug) }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Belum ada berita dalam kategori ini.</div>
            </div>
        @endforelse
    </div>
    
    <div class="mt-4">
        {{ $news->links() }}
    </div>
    
    <div class="mt-3">
        <a href="{{ route('news.index') }}" class="btn btn-outline-primary">Lihat Semua Berita</a>
    </div>
</div>
@endsection
