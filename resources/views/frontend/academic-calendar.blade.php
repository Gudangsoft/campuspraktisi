@extends('frontend.layout')

@section('title', 'Kalender Akademik - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="page-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 80px 0;">
    <div class="container">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-calendar-days me-3"></i>Kalender Akademik
            </h1>
            <p class="lead mb-0">Jadwal lengkap kegiatan akademik kampus</p>
        </div>
    </div>
</div>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light">
    <div class="container">
        <ol class="breadcrumb py-3 mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kalender Akademik</li>
        </ol>
    </div>
</nav>

<!-- Calendar Component -->
@include('components.academic-calendar')

@endsection
