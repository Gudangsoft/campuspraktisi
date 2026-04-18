@extends('frontend.layout')

@section('title', 'Gallery Video - '.setting('site_name'))

@section('content')
<!-- Page Header -->
<section class="py-5" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h1 class="display-4 fw-bold mb-3">Gallery Video</h1>
                <p class="lead">Kumpulan video kegiatan dan aktivitas kampus</p>
            </div>
        </div>
    </div>
</section>

<!-- Videos Grid -->
<section class="py-5">
    <div class="container">
        @if($videos->count() > 0)
        <div class="row g-4">
            @foreach($videos as $video)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm video-item">
                    <div class="video-thumbnail position-relative" role="button" data-bs-toggle="modal" data-bs-target="#videoModal{{ $video->id }}">
                        <img src="{{ $video->thumbnail_url }}" 
                             class="card-img-top" 
                             alt="{{ $video->title }}"
                             style="height: 250px; object-fit: cover;">
                        <div class="video-overlay-full position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                            <div class="btn btn-danger btn-lg rounded-circle"
                                 style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                                <i class="fab fa-youtube fs-3"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $video->title }}</h5>
                        @if($video->description)
                        <p class="card-text text-muted">{{ Str::limit($video->description, 100) }}</p>
                        @endif
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="far fa-calendar me-1"></i>{{ $video->video_date ? $video->video_date->format('d M Y') : $video->created_at->format('d M Y') }}
                            </small>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#videoModal{{ $video->id }}">
                                <i class="fas fa-play me-1"></i>Tonton
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal for Video Playback -->
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
                            <div class="text-start">
                                <h6 class="fw-bold">Deskripsi:</h6>
                                <p class="text-muted mb-0">{{ $video->description }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $videos->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-video fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Belum ada video</h4>
        </div>
        @endif
    </div>
</section>
@endsection

@section('styles')
<style>
    .video-item {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .video-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.2) !important;
    }
    
    .video-thumbnail {
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }
    
    .video-overlay-full {
        background: rgba(0,0,0,0.4);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .video-item:hover .video-overlay-full {
        opacity: 1;
    }
    
    .video-overlay-full .btn {
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }
    
    .video-item:hover .video-overlay-full .btn {
        animation: none;
        transform: scale(1.2);
    }
    
    .video-overlay-full .btn:hover {
        transform: scale(1.15);
        box-shadow: 0 8px 25px rgba(0,0,0,0.4);
    }
</style>
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
