@extends('admin.layout')

@section('title', 'Tambah Why Choose Us Card')
@section('page-title', 'Tambah Why Choose Us Card')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.why-choose-us.index') }}">Why Choose Us</a></li>
    <li class="breadcrumb-item active">Tambah Card</li>
@endsection

@section('content')
<div class="content-card">
    <div class="content-card-header">
        <h5><i class="fas fa-plus me-2"></i>Tambah Why Choose Us Card</h5>
        <small class="text-muted">Buat kartu fitur unggulan baru</small>
    </div>

    <form action="{{ route('admin.why-choose-us.store') }}" method="POST">
        @csrf
        
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
                           value="{{ old('title') }}" 
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
                           value="{{ old('subtitle') }}" 
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
                            <i id="preview-icon" class="fas fa-star"></i>
                        </span>
                        <input type="text" 
                               class="form-control @error('icon') is-invalid @enderror" 
                               name="icon" 
                               id="icon-input"
                               value="{{ old('icon', 'fa-star') }}" 
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
                                   value="{{ old('icon_color', '#4a5568') }}" 
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
                                   value="{{ old('background_color', '#ffffff') }}" 
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
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Tampilkan di website
                        </label>
                    </div>
                    <small class="text-muted">Aktifkan untuk menampilkan card di halaman utama</small>
                </div>
            </div>

            <!-- Right Column - Preview -->
            <div class="col-md-6">
                <div class="card shadow-sm" style="border-left: 4px solid #4a5568;" id="preview-card">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="icon-circle mx-auto mb-3" id="preview-icon-circle" style="background-color: #4a5568;">
                                <i id="preview-icon-large" class="fas fa-star text-white"></i>
                            </div>
                            <h5 class="card-title mb-1" id="preview-title">KULIAH PRAKTIS</h5>
                            <small class="text-muted" id="preview-subtitle">Dengan Metode Modern</small>
                        </div>
                        <div class="alert alert-info text-center mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>Preview Card<br>Fitur akan ditambahkan setelah card dibuat</small>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Tips:</strong> Setelah membuat card, Anda dapat menambahkan poin-poin fitur dari halaman daftar dengan klik tombol "Kelola Fitur".
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Card
            </button>
            <a href="{{ route('admin.why-choose-us.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
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
        previewTitle.textContent = this.value || 'KULIAH PRAKTIS';
    });

    // Live preview for subtitle
    const subtitleInput = document.querySelector('input[name="subtitle"]');
    const previewSubtitle = document.getElementById('preview-subtitle');
    
    subtitleInput.addEventListener('input', function() {
        previewSubtitle.textContent = this.value || 'Dengan Metode Modern';
        previewSubtitle.style.display = this.value ? 'block' : 'block';
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

    // Live preview for background color (optional - for future use)
    // Can be used to change card background if needed
});
</script>
@endpush
@endsection
