@extends('frontend.layout')

@section('content')
<!-- Hero Section -->
<section class="py-5 bg-primary text-white position-relative" style="background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%); overflow: hidden;">
    <div class="container py-4 position-relative" style="z-index: 2;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Struktur Organisasi</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold mb-3">Jajaran Pimpinan</h1>
        <p class="lead opacity-75">Struktur Kepemimpinan Politeknik Praktisi dan Penyelenggara Pendidikan.</p>
    </div>
    <!-- Decoration -->
    <div class="position-absolute top-50 end-0 translate-middle-y opacity-10" style="font-size: 20rem; transform: rotate(-15deg); margin-right: -100px;">
        <i class="fas fa-university"></i>
    </div>
</section>

<!-- Pimpinan Perguruan Tinggi -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase mb-2" style="letter-spacing: 2px;">Leadership Team</h6>
            <h2 class="fw-bold fs-1">Pimpinan Perguruan Tinggi</h2>
            <div class="mx-auto mt-3" style="width: 60px; height: 4px; background: #0d47a1; border-radius: 2px;"></div>
        </div>

        <div class="row justify-content-center g-4">
            @foreach($pimpinan as $index => $item)
                @if($index == 0) <!-- Direktur usually first -->
                <div class="col-md-5 col-lg-4">
                    <div class="card border-0 shadow-sm pimpinan-card h-100">
                        <div class="p-4 text-center">
                            <div class="profile-img-container mx-auto mb-4">
                                @if($item->foto)
                                    <img src="{{ asset('storage/'.$item->foto) }}" alt="{{ $item->nama }}" class="img-fluid rounded-circle shadow-sm border border-4 border-white">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->nama) }}&background=0D47A1&color=fff&size=200" alt="{{ $item->nama }}" class="img-fluid rounded-circle shadow-sm border border-4 border-white">
                                @endif
                            </div>
                            <h4 class="fw-bold text-dark mb-1">{{ $item->nama }}</h4>
                            <p class="text-primary fw-bold mb-3 text-uppercase small" style="letter-spacing: 1px;">{{ $item->jabatan }}</p>
                            @if($item->email || $item->linkedin)
                            <div class="social-links d-flex justify-content-center gap-2">
                                @if($item->email)
                                    <a href="mailto:{{ $item->email }}" class="btn btn-primary btn-sm rounded-circle text-white d-flex align-items-center justify-content-center"><i class="fas fa-envelope"></i></a>
                                @endif
                                @if($item->linkedin)
                                    <a href="{{ $item->linkedin }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle d-flex align-items-center justify-content-center"><i class="fab fa-linkedin-in"></i></a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <div class="row justify-content-center g-4 mt-2">
            @foreach($pimpinan as $index => $item)
                @if($index > 0)
                <div class="col-md-5 col-lg-4">
                    <div class="card border-0 shadow-sm pimpinan-card h-100">
                        <div class="p-4 text-center">
                            <div class="profile-img-container mx-auto mb-4">
                                @if($item->foto)
                                    <img src="{{ asset('storage/'.$item->foto) }}" alt="{{ $item->nama }}" class="img-fluid rounded-circle shadow-sm border border-4 border-white">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->nama) }}&background=1976D2&color=fff&size=200" alt="{{ $item->nama }}" class="img-fluid rounded-circle shadow-sm border border-4 border-white">
                                @endif
                            </div>
                            <h4 class="fw-bold text-dark mb-1">{{ $item->nama }}</h4>
                            <p class="text-secondary fw-bold mb-3 text-uppercase small" style="letter-spacing: 1px;">{{ $item->jabatan }}</p>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</section>

<!-- Penyelenggara Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="text-start">
                    <h6 class="text-primary fw-bold text-uppercase mb-2" style="letter-spacing: 2px;">Governance</h6>
                    <h2 class="fw-bold mb-4 display-6">Penyelenggara Perguruan Tinggi</h2>
                    <p class="text-muted mb-5 lead">Politeknik Praktisi diselenggarakan secara profesional di bawah naungan {{ setting('yayasan_nama', 'Yayasan Pengkajian Dan Penerapan Akuntansi') }}.</p>
                    
                    <div class="card border-0 bg-light p-4 rounded-4 shadow-sm mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-3 d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-landmark"></i>
                            </div>
                            <h5 class="fw-bold m-0 text-dark">{{ setting('yayasan_nama', 'Yayasan Pengkajian Dan Penerapan Akuntansi') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg position-relative overflow-hidden" style="border-radius: 20px;">
                    <div class="card-header bg-dark text-white p-4 border-0">
                        <h5 class="m-0 fw-bold"><i class="fas fa-file-contract me-2"></i>Data Legalitas & Struktur Yayasan</h5>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <!-- Dynamic Yayasan Personnel -->
                        @foreach($yayasan as $item)
                        <div class="mb-4 d-flex align-items-center p-3 bg-light rounded-3 shadow-sm border-start border-4 border-primary">
                            <div class="flex-shrink-0 me-3">
                                @if($item->foto)
                                    <img src="{{ asset('storage/'.$item->foto) }}" alt="{{ $item->nama }}" class="rounded-circle shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-user-tie fa-2x"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h6 class="text-muted m-0 small fw-bold">{{ strtoupper($item->jabatan) }}</h6>
                                <h5 class="fw-bold m-0 text-primary">{{ $item->nama }}</h5>
                            </div>
                        </div>
                        @endforeach

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
                                <div>
                                    <i class="fas fa-calendar-check text-muted me-2"></i>
                                    <span class="text-muted small fw-bold">TGL AKTA NOTARIS</span>
                                </div>
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">{{ setting('yayasan_akta_notaris', '2007-08-15') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0">
                                <div>
                                    <i class="fas fa-id-card text-muted me-2"></i>
                                    <span class="text-muted small fw-bold">NO. REG HUMHAM</span>
                                </div>
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ setting('yayasan_no_reg_ham', 'C-3973 HT 01.02 TH 2007') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .pimpinan-card {
        transition: all 0.4s ease;
        border-radius: 20px;
        overflow: hidden;
    }
    .pimpinan-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }
    .profile-img-container {
        width: 180px;
        height: 180px;
        position: relative;
    }
    .profile-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .pimpinan-card .btn-sm {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    .pimpinan-card .btn-sm:hover {
        transform: rotate(360deg) scale(1.1);
    }
    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.5);
    }
</style>
@endpush
@endsection
