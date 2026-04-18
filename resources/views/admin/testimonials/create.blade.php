@extends('admin.layout')

@section('title', 'Tambah Testimoni')
@section('page-title', 'Tambah Testimoni Alumni')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.testimonials.index') }}">Testimoni Alumni</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="content-card">
            <div class="content-card-header">
                <h5><i class="fas fa-quote-left me-2"></i>Form Tambah Testimoni</h5>
            </div>

            <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Alumni <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           placeholder="Contoh: John Doe"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="graduation_year" class="form-label">Tahun Lulus</label>
                        <input type="text" 
                               class="form-control @error('graduation_year') is-invalid @enderror" 
                               id="graduation_year" 
                               name="graduation_year" 
                               value="{{ old('graduation_year') }}"
                               placeholder="Contoh: 2020">
                        @error('graduation_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                        <select class="form-select @error('rating') is-invalid @enderror" 
                                id="rating" 
                                name="rating" 
                                required>
                            <option value="">Pilih Rating</option>
                            <option value="5" {{ old('rating', 5) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Bintang)</option>
                            <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Bintang)</option>
                            <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 Bintang)</option>
                            <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>⭐⭐ (2 Bintang)</option>
                            <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>⭐ (1 Bintang)</option>
                        </select>
                        @error('rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="current_position" class="form-label">Posisi/Jabatan Saat Ini</label>
                    <input type="text" 
                           class="form-control @error('current_position') is-invalid @enderror" 
                           id="current_position" 
                           name="current_position" 
                           value="{{ old('current_position') }}"
                           placeholder="Contoh: Senior Nurse">
                    @error('current_position')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="company" class="form-label">Perusahaan/Institusi</label>
                    <input type="text" 
                           class="form-control @error('company') is-invalid @enderror" 
                           id="company" 
                           name="company" 
                           value="{{ old('company') }}"
                           placeholder="Contoh: RS. Cipto Mangunkusumo">
                    @error('company')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="testimonial" class="form-label">Testimoni <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('testimonial') is-invalid @enderror" 
                              id="testimonial" 
                              name="testimonial" 
                              rows="5"
                              placeholder="Tulis testimoni alumni di sini..."
                              required>{{ old('testimonial') }}</textarea>
                    @error('testimonial')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Testimoni atau kesan alumni tentang kampus</small>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Foto Alumni</label>
                    <input type="file" 
                           class="form-control @error('photo') is-invalid @enderror" 
                           id="photo" 
                           name="photo" 
                           accept="image/*"
                           onchange="previewPhoto(event)">
                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Format: JPG, PNG. Max: 2MB. Foto profil alumni</small>
                    
                    <div id="photo-preview" class="mt-3" style="display: none;">
                        <img id="preview-image" src="" alt="Preview" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Tampilkan di website
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="content-card">
            <div class="content-card-header">
                <h5><i class="fas fa-info-circle me-2"></i>Panduan</h5>
            </div>

            <h6><i class="fas fa-user text-primary me-2"></i>Info Alumni:</h6>
            <ul class="small mb-3">
                <li>Nama lengkap alumni</li>
                <li>Tahun lulus (opsional)</li>
                <li>Posisi/jabatan saat ini (opsional)</li>
                <li>Tempat bekerja (opsional)</li>
            </ul>

            <h6><i class="fas fa-star text-warning me-2"></i>Rating:</h6>
            <p class="small mb-3">
                Berikan rating 1-5 bintang sesuai testimoni yang diberikan. Default: 5 bintang.
            </p>

            <h6><i class="fas fa-image text-success me-2"></i>Tips Foto:</h6>
            <ul class="small mb-3">
                <li>Foto formal atau semi-formal</li>
                <li>Close-up wajah (akan ditampilkan bulat)</li>
                <li>Background bersih/polos lebih baik</li>
                <li>Resolusi cukup (minimal 200x200px)</li>
            </ul>

            <h6><i class="fas fa-quote-left text-info me-2"></i>Testimoni:</h6>
            <p class="small mb-0">
                Tulis testimoni yang autentik dan positif. Fokus pada pengalaman belajar, fasilitas, atau dampak terhadap karir.
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
            document.getElementById('photo-preview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection
