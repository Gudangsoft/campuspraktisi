@extends('frontend.layout')

@section('title', 'Galeri Foto - '.setting('site_name'))

@section('content')
<!-- Page Header -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold mb-3">Galeri Foto</h1>
                <p class="lead">Dokumentasi kegiatan dan aktivitas kampus</p>
            </div>
        </div>
    </div>
</section>

<!-- Photos Grid -->
<section class="py-5">
    <div class="container">
        @if($photos->count() > 0)
        <div class="row g-4">
            @foreach($photos as $photo)
            <div class="col-md-4 col-lg-3">
                <div class="gallery-card" data-bs-toggle="modal" data-bs-target="#photoModal{{ $photo->id }}" style="cursor: pointer;">
                    <div class="gallery-image position-relative">
                        <img src="{{ asset('storage/'.$photo->image) }}" 
                             class="img-fluid w-100 rounded" 
                             alt="{{ $photo->title }}"
                             style="height: 250px; object-fit: cover;">
                        <div class="gallery-hover position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center rounded">
                            <i class="fas fa-search-plus text-white fs-2"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <h6 class="mb-1">{{ $photo->title }}</h6>
                        @if($photo->description)
                        <p class="text-muted small mb-0">{{ Str::limit($photo->description, 60) }}</p>
                        @endif
                    </div>
                </div>
                
                <!-- Modal -->
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
                                     style="max-height: 80vh; object-fit: contain; background: #000;">
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
        </div>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $photos->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-images fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Belum ada foto</h4>
        </div>
        @endif
    </div>
</section>
@endsection

@section('styles')
<style>
    .gallery-card {
        transition: all 0.3s ease;
    }
    
    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .gallery-image {
        overflow: hidden;
        border-radius: 8px;
        position: relative;
    }
    
    .gallery-image img {
        transition: transform 0.4s ease;
        display: block;
    }
    
    .gallery-card:hover .gallery-image img {
        transform: scale(1.15);
    }
    
    .gallery-hover {
        background: rgba(0,0,0,0.6);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }
    
    .gallery-card:hover .gallery-hover {
        opacity: 1;
    }
    
    .modal-xl {
        max-width: 1200px;
    }
    
    .modal-body img {
        display: block;
        margin: 0 auto;
    }
</style>
@endsection
