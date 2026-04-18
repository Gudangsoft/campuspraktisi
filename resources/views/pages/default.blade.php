@extends('frontend.layout')

@section('title', $page->title)

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">{{ $page->title }}</li>
                </ol>
            </nav>

            <h1 class="mb-4">{{ $page->title }}</h1>

            @if($page->image)
                <img src="{{ asset('storage/'.$page->image) }}" class="img-fluid rounded mb-4" alt="{{ $page->title }}">
            @endif

            @if($page->excerpt)
                <p class="lead">{{ $page->excerpt }}</p>
                <hr>
            @endif

            @if($page->content)
                <div class="content">
                    {!! $page->content !!}
                </div>
            @endif

            <div class="mt-5 pt-4 border-top">
                <small class="text-muted">Last updated: {{ $page->updated_at->format('d M Y') }}</small>
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
    
    .content h2 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: var(--primary);
    }
    
    .content h3 {
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        color: var(--secondary);
    }
    
    .content ul, .content ol {
        margin: 1rem 0;
        padding-left: 2rem;
    }
    
    .content li {
        margin-bottom: 0.5rem;
    }
</style>
@endsection
