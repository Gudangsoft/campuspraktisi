@php
    try {
        $advantagesEnabled = setting('advantages_section_enabled', '1');
        $advantages = \App\Models\Advantage::active()->ordered()->get();
    } catch (\Exception $e) {
        $advantagesEnabled = '0';
        $advantages = collect();
    }
@endphp

@if($advantagesEnabled == '1' && $advantages->count() > 0)
<section class="advantages-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">{{ setting('advantages_title', 'Keunggulan Kami') }}</h2>
            @if(setting('advantages_subtitle'))
                <p class="text-muted">{{ setting('advantages_subtitle') }}</p>
            @endif
        </div>

        <div class="row g-4">
            @foreach($advantages as $advantage)
            <div class="col-lg-4 col-md-6">
                <div class="card advantage-card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle mx-auto mb-3" 
                             style="background-color: {{ $advantage->icon_color }}; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                            <i class="fas {{ $advantage->icon }} text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">{{ $advantage->title }}</h5>
                        @if($advantage->description)
                            <p class="card-text text-muted">{{ $advantage->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.advantage-card {
    transition: all 0.3s ease;
}

.advantage-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.advantage-card .icon-circle {
    transition: transform 0.3s ease;
}

.advantage-card:hover .icon-circle {
    transform: scale(1.1);
}
</style>
@endif
