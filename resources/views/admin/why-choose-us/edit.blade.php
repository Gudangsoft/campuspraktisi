@extends('admin.layout')

@section('title', 'Edit Why Choose Us Card')
@section('page-title', 'Edit Why Choose Us Card')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.why-choose-us.index') }}">Why Choose Us</a></li>
    <li class="breadcrumb-item active">Edit Card</li>
@endsection

@section('content')
<div class="content-card">
    <div class="content-card-header">
        <h5><i class="fas fa-edit me-2"></i>Edit Why Choose Us Card</h5>
        <small class="text-muted">Edit kartu fitur unggulan</small>
    </div>

    <form action="{{ route('admin.why-choose-us.update', $whyChooseUs->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">
                        Judul Card <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control @error('title') is-invalid @enderror" 
                           name="title" 
                           value="{{ old('title', $whyChooseUs->title) }}" 
                           placeholder="Contoh: KULIAH PRAKTIS" 
                           required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Judul utama yang akan ditampilkan di card</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Subjudul (Opsional)</label>
                    <input type="text" 
                           class="form-control @error('subtitle') is-invalid @enderror" 
                           name="subtitle" 
                           value="{{ old('subtitle', $whyChooseUs->subtitle) }}" 
                           placeholder="Contoh: Dengan Metode Modern">
                    @error('subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Teks kecil di bawah judul (opsional)</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Icon Font Awesome <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i id="preview-icon" class="{{ $whyChooseUs->icon }}"></i>
                        </span>
                        <input type="text" 
                               class="form-control @error('icon') is-invalid @enderror" 
                               name="icon" 
                               id="icon-input"
                               value="{{ old('icon', $whyChooseUs->icon) }}" 
                               placeholder="fa-star" 
                               required>
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">
                        Kode icon dari <a href="https://fontawesome.com/icons" target="_blank">Font Awesome</a>. 
                        Contoh: fa-star, fa-rocket, fa-graduation-cap
                    </small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">
                                Warna Icon <span class="text-danger">*</span>
                            </label>
                            <input type="color" 
                                   class="form-control form-control-color @error('icon_color') is-invalid @enderror" 
                                   name="icon_color" 
                                   id="icon-color"
                                   value="{{ old('icon_color', $whyChooseUs->icon_color) }}" 
                                   required>
                            @error('icon_color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">
                                Warna Background <span class="text-danger">*</span>
                            </label>
                            <input type="color" 
                                   class="form-control form-control-color @error('background_color') is-invalid @enderror" 
                                   name="background_color" 
                                   value="{{ old('background_color', $whyChooseUs->background_color) }}" 
                                   required>
                            @error('background_color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="is_active" 
                               id="is_active" 
                               {{ old('is_active', $whyChooseUs->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Tampilkan di website
                        </label>
                    </div>
                    <small class="text-muted">Aktifkan untuk menampilkan card di halaman utama</small>
                </div>
            </div>

            <!-- Right Column - Preview -->
            <div class="col-md-6">
                <div class="card shadow-sm" style="border-left: 4px solid {{ $whyChooseUs->icon_color }};" id="preview-card">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="icon-circle mx-auto mb-3" id="preview-icon-circle" style="background-color: {{ $whyChooseUs->icon_color }};">
                                <i id="preview-icon-large" class="fas {{ $whyChooseUs->icon }} text-white"></i>
                            </div>
                            <h5 class="card-title mb-1" id="preview-title">{{ $whyChooseUs->title }}</h5>
                            @if($whyChooseUs->subtitle)
                                <small class="text-muted" id="preview-subtitle">{{ $whyChooseUs->subtitle }}</small>
                            @else
                                <small class="text-muted" id="preview-subtitle" style="display: none;"></small>
                            @endif
                        </div>
                        
                        @if($whyChooseUs->features->isNotEmpty())
                            <ul class="list-unstyled mb-0">
                                @foreach($whyChooseUs->features->take(3) as $feature)
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    {{ $feature->feature_text }}
                                </li>
                                @endforeach
                                @if($whyChooseUs->features->count() > 3)
                                    <li class="text-muted">
                                        <small>+ {{ $whyChooseUs->features->count() - 3 }} fitur lainnya</small>
                                    </li>
                                @endif
                            </ul>
                        @else
                            <div class="alert alert-info text-center mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                <small>Belum ada fitur. Tambahkan fitur dari menu "Kelola Fitur".</small>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Kelola Fitur:</strong> 
                    <a href="{{ route('admin.why-choose-us.features', $whyChooseUs->id) }}" class="alert-link">
                        Klik di sini
                    </a> untuk menambahkan atau mengedit poin-poin fitur.
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Card
            </button>
            <a href="{{ route('admin.why-choose-us.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('admin.why-choose-us.features', $whyChooseUs->id) }}" class="btn btn-info text-white">
                <i class="fas fa-list"></i> Kelola Fitur
            </a>
        </div>
    </form>
</div>

<style>
.icon-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}

.form-control-color {
    height: 45px;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Live preview for title
    const titleInput = document.querySelector('input[name="title"]');
    const previewTitle = document.getElementById('preview-title');
    
    titleInput.addEventListener('input', function() {
        previewTitle.textContent = this.value || '{{ $whyChooseUs->title }}';
    });

    // Live preview for subtitle
    const subtitleInput = document.querySelector('input[name="subtitle"]');
    const previewSubtitle = document.getElementById('preview-subtitle');
    
    subtitleInput.addEventListener('input', function() {
        if (this.value) {
            previewSubtitle.textContent = this.value;
            previewSubtitle.style.display = 'block';
        } else {
            previewSubtitle.style.display = 'none';
        }
    });

    // Live preview for icon
    const iconInput = document.getElementById('icon-input');
    const previewIconSmall = document.getElementById('preview-icon');
    const previewIconLarge = document.getElementById('preview-icon-large');
    
    iconInput.addEventListener('input', function() {
        const iconClass = this.value || 'fa-star';
        // Remove all classes and add new ones
        previewIconSmall.className = '';
        previewIconLarge.className = '';
        previewIconSmall.className = 'fas ' + iconClass;
        previewIconLarge.className = 'fas ' + iconClass + ' text-white';
    });

    // Live preview for icon color
    const iconColorInput = document.getElementById('icon-color');
    const previewIconCircle = document.getElementById('preview-icon-circle');
    const previewCard = document.getElementById('preview-card');
    
    iconColorInput.addEventListener('input', function() {
        previewIconCircle.style.backgroundColor = this.value;
        previewCard.style.borderLeftColor = this.value;
    });
});
</script>
@endpush
@endsection
