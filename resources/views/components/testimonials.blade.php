@php
    $enabled = \App\Models\Setting::where('key', 'testimonials_section_enabled')->value('value') ?? '1';
    $title = \App\Models\Setting::where('key', 'testimonials_title')->value('value') ?? 'Testimoni Alumni';
    $subtitle = \App\Models\Setting::where('key', 'testimonials_subtitle')->value('value') ?? 'Apa Kata Mereka Tentang Kami';
    
    $testimonials = \App\Models\Testimonial::active()->ordered()->get();
@endphp

@if($enabled == '1' && $testimonials->count() > 0)
<section class="testimonials-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-4">
                <h2 class="section-title">{{ $title }}</h2>
                <p class="section-subtitle text-muted">{{ $subtitle }}</p>
            </div>
        </div>

        <div class="row g-4">
            @foreach($testimonials as $testimonial)
            <div class="col-lg-3 col-md-6">
                <div class="testimonial-card h-100">
                    <!-- Photo -->
                    <div class="testimonial-photo-wrapper">
                        @if($testimonial->photo)
                            <img src="{{ asset('storage/' . $testimonial->photo) }}" 
                                 alt="{{ $testimonial->name }}" 
                                 class="testimonial-photo">
                        @else
                            <div class="testimonial-photo-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                        
                        <!-- Name and Info Overlay -->
                        <div class="testimonial-overlay">
                            <h5 class="testimonial-name">{{ $testimonial->name }}</h5>
                            <div class="testimonial-info">
                                @if($testimonial->current_position || $testimonial->company)
                                    <span class="d-block">
                                        @if($testimonial->current_position)
                                            {{ $testimonial->current_position }}
                                        @endif
                                        @if($testimonial->company)
                                            @if($testimonial->current_position), @endif
                                            {{ $testimonial->company }}
                                        @endif
                                    </span>
                                @endif
                                @if($testimonial->graduation_year)
                                    <span class="d-block">{{ $testimonial->graduation_year }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Testimonial Content -->
                    <div class="testimonial-content">
                        <p class="testimonial-text">{{ $testimonial->testimonial }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.testimonials-section {
    position: relative;
    overflow: hidden;
}

.section-title {
    font-size: 2rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 0.5rem;
}

.section-subtitle {
    font-size: 1.1rem;
    margin-bottom: 0;
    color: #6c757d;
}

.testimonial-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.testimonial-photo-wrapper {
    position: relative;
    width: 100%;
    height: 280px;
    overflow: hidden;
}

.testimonial-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.testimonial-photo-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.testimonial-photo-placeholder i {
    font-size: 5rem;
    color: rgba(255,255,255,0.7);
}

.testimonial-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 70%, transparent 100%);
    padding: 15px;
    color: white;
}

.testimonial-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: white;
    margin-bottom: 3px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.testimonial-info {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.9);
    line-height: 1.4;
}

.testimonial-info span {
    text-shadow: 0 1px 3px rgba(0,0,0,0.3);
}

.testimonial-content {
    padding: 15px;
    flex-grow: 1;
    display: flex;
    align-items: center;
}

.testimonial-text {
    color: #555;
    font-size: 0.875rem;
    line-height: 1.6;
    font-style: italic;
    margin-bottom: 0;
    text-align: justify;
}

@media (max-width: 992px) {
    .testimonial-photo-wrapper {
        height: 300px;
    }
    
    .section-title {
        font-size: 1.75rem;
    }
}

@media (max-width: 768px) {
    .testimonial-photo-wrapper {
        height: 280px;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .section-subtitle {
        font-size: 1rem;
    }
    
    .testimonial-name {
        font-size: 1.1rem;
    }
    
    .testimonial-text {
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .testimonial-photo-wrapper {
        height: 250px;
    }
}
</style>

@endif
