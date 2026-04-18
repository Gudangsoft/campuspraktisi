@extends('frontend.layout')

@section('title', $page->title)

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="mb-4">{{ $page->title }}</h1>

            @if($page->excerpt)
                <p class="lead mb-4">{{ $page->excerpt }}</p>
            @endif

            @if($page->content)
                <div class="content mb-5">
                    {!! $page->content !!}
                </div>
            @endif

            <!-- Contact Information Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4"><i class="fas fa-address-card me-2"></i>Informasi Kontak</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <i class="fas fa-map-marker-alt fa-lg text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Alamat</h6>
                                    <p class="text-muted mb-0">{{ setting('contact_address', 'Jl. Pendidikan No. 123, Jakarta') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <i class="fas fa-phone fa-lg text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Telepon</h6>
                                    <p class="text-muted mb-0">{{ setting('contact_phone', '+62 21 1234567') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <i class="fas fa-envelope fa-lg text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Email</h6>
                                    <p class="text-muted mb-0">{{ setting('contact_email', 'info@kampus.ac.id') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <i class="fas fa-share-alt fa-lg text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Social Media</h6>
                                    <div>
                                        @if(setting('facebook_url'))
                                            <a href="{{ setting('facebook_url') }}" class="btn btn-sm btn-outline-primary me-1" target="_blank">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        @endif
                                        @if(setting('twitter_url'))
                                            <a href="{{ setting('twitter_url') }}" class="btn btn-sm btn-outline-info me-1" target="_blank">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        @endif
                                        @if(setting('instagram_url'))
                                            <a href="{{ setting('instagram_url') }}" class="btn btn-sm btn-outline-danger" target="_blank">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4"><i class="fas fa-paper-plane me-2"></i>Kirim Pesan</h5>
                    
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subjek</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pesan</label>
                            <textarea class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
    }
</style>
@endsection
