<!-- Why Choose Us Section -->
@if(setting('why_choose_us_enabled', '1') == '1' && isset($whyChooseUs) && $whyChooseUs->count() > 0)
<section class="why-choose-us-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">{{ setting('why_choose_us_title', 'Kenapa Memilih Kami?') }}</h2>
            <p class="text-muted">{{ setting('why_choose_us_description', 'Keunggulan yang kami tawarkan untuk kesuksesan Anda') }}</p>
        </div>

        <div class="row g-4">
            @foreach($whyChooseUs as $item)
            <div class="col-md-4">
                <div class="why-card h-100" style="background-color: {{ $item->background_color }};">
                    <div class="why-card-icon" style="background-color: {{ $item->icon_color }};">
                        <i class="fas {{ $item->icon }}"></i>
                    </div>
                    <h4 class="why-card-title">{{ $item->title }}</h4>
                    @if($item->subtitle)
                        <p class="why-card-subtitle">{{ $item->subtitle }}</p>
                    @endif
                    
                    @if($item->features->count() > 0)
                        <ul class="why-card-features">
                            @foreach($item->features as $feature)
                            <li>
                                @if($feature->icon)
                                    <i class="fas {{ $feature->icon }}"></i>
                                @else
                                    <i class="fas fa-check"></i>
                                @endif
                                {{ $feature->feature_text }}
                            </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.why-choose-us-section {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.why-card {
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.why-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.why-card-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: white;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.why-card:hover .why-card-icon {
    transform: scale(1.1) rotate(5deg);
}

.why-card-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #2c3e50;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.why-card-subtitle {
    color: #7f8c8d;
    font-size: 0.95rem;
    margin-bottom: 1.5rem;
    font-style: italic;
}

.why-card-features {
    list-style: none;
    padding: 0;
    margin: 0;
    text-align: left;
}

.why-card-features li {
    padding: 0.6rem 0;
    color: #34495e;
    font-size: 0.95rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.why-card-features li:last-child {
    border-bottom: none;
}

.why-card-features li i {
    color: #27ae60;
    margin-top: 0.2rem;
    font-size: 1rem;
    flex-shrink: 0;
}

@media (max-width: 768px) {
    .why-card {
        margin-bottom: 1.5rem;
    }
    
    .why-card-title {
        font-size: 1.25rem;
    }
    
    .why-card-icon {
        width: 70px;
        height: 70px;
        font-size: 2rem;
    }
}
</style>
@endif
