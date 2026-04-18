@extends('frontend.layout')

@section('title', $page->title)

@section('content')
<!-- Hero Section -->
<div style="background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%); padding: 100px 0; color: white; margin-top: -20px;">
    <div class="container text-center">
        <h1 class="display-4 mb-3">{{ $page->title }}</h1>
        @if($page->excerpt)
            <p class="lead">{{ $page->excerpt }}</p>
        @endif
    </div>
</div>

<!-- Content Section -->
<div class="container my-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            @if($page->image)
                <div class="text-center mb-5">
                    <img src="{{ asset('storage/'.$page->image) }}" class="img-fluid rounded shadow" alt="{{ $page->title }}" style="max-width: 800px;">
                </div>
            @endif

            @if($page->content)
                <div class="content">
                    {!! $page->content !!}
                </div>
            @endif
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
        margin-top: 2.5rem;
        margin-bottom: 1.5rem;
        color: var(--primary);
        border-left: 4px solid var(--accent);
        padding-left: 1rem;
    }
    
    .content h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: var(--secondary);
    }
    
    .content p {
        margin-bottom: 1.5rem;
        text-align: justify;
    }
    
    .content ul, .content ol {
        margin: 1.5rem 0;
        padding-left: 2rem;
    }
    
    .content li {
        margin-bottom: 0.75rem;
    }
</style>
@endsection
