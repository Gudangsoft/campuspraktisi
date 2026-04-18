@php
    $partners = \App\Models\Partner::active()->ordered()->get();
@endphp

@if(setting('partners_section_enabled', '1') == '1' && $partners->count() > 0)
<section class="partners-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">{{ setting('partners_title', 'Mitra Kami') }}</h2>
            <p class="text-muted">{{ setting('partners_subtitle', 'Institusi dan Perusahaan yang Bekerja Sama dengan Kami') }}</p>
        </div>

        <div class="row g-4 align-items-center justify-content-center">
            @foreach($partners as $partner)
            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="partner-logo-wrapper">
                    @if($partner->website)
                        <a href="{{ $partner->website }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="partner-link"
                           title="{{ $partner->name }}">
                            <img src="{{ asset('storage/' . $partner->logo) }}" 
                                 alt="{{ $partner->name }}"
                                 class="partner-logo">
                        </a>
                    @else
                        <div class="partner-link" title="{{ $partner->name }}">
                            <img src="{{ asset('storage/' . $partner->logo) }}" 
                                 alt="{{ $partner->name }}"
                                 class="partner-logo">
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.partners-section {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.partner-logo-wrapper {
    background: white;
    border-radius: 10px;
    padding: 20px;
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.partner-logo-wrapper:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.partner-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    text-decoration: none;
}

.partner-logo {
    max-width: 100%;
    max-height: 80px;
    object-fit: contain;
    filter: grayscale(100%);
    opacity: 0.7;
    transition: all 0.3s ease;
}

.partner-logo-wrapper:hover .partner-logo {
    filter: grayscale(0%);
    opacity: 1;
}

@media (max-width: 768px) {
    .section-title {
        font-size: 2rem;
    }
    
    .partner-logo-wrapper {
        height: 100px;
        padding: 15px;
    }
    
    .partner-logo {
        max-height: 60px;
    }
}

@media (max-width: 576px) {
    .partner-logo-wrapper {
        height: 80px;
        padding: 10px;
    }
    
    .partner-logo {
        max-height: 50px;
    }
}
</style>
@endif
