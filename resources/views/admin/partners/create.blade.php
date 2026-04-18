@extends('admin.layout')

@section('title', 'Tambah Mitra')
@section('page-title', 'Tambah Mitra Baru')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.partners.index') }}">Mitra</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="content-card">
            <div class="content-card-header">
                <h5><i class="fas fa-handshake me-2"></i>Form Tambah Mitra</h5>
            </div>

            <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Mitra <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           placeholder="Contoh: PT. ABC Indonesia"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="logo" class="form-label">Logo Mitra <span class="text-danger">*</span></label>
                    <input type="file" 
                           class="form-control @error('logo') is-invalid @enderror" 
                           id="logo" 
                           name="logo" 
                           accept="image/*"
                           onchange="previewLogo(event)"
                           required>
                    @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Format: JPG, PNG, SVG. Max: 2MB. Rekomendasi: Logo transparan (PNG)</small>
                    
                    <div id="logo-preview" class="mt-3" style="display: none;">
                        <img id="preview-image" src="" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input type="url" 
                           class="form-control @error('website') is-invalid @enderror" 
                           id="website" 
                           name="website" 
                           value="{{ old('website') }}"
                           placeholder="https://www.example.com">
                    @error('website')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">URL lengkap website mitra (opsional)</small>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="3"
                              placeholder="Deskripsi singkat tentang mitra...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                    <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary">
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

            <h6><i class="fas fa-image text-primary me-2"></i>Tips Logo:</h6>
            <ul class="small mb-3">
                <li>Gunakan logo dengan background transparan (PNG)</li>
                <li>Ukuran ideal: 200x100px atau rasio 2:1</li>
                <li>Resolusi tinggi untuk tampilan yang jernih</li>
                <li>File tidak lebih dari 2MB</li>
            </ul>

            <h6><i class="fas fa-palette text-success me-2"></i>Kualitas Logo:</h6>
            <ul class="small mb-3">
                <li>Logo harus jelas dan mudah dibaca</li>
                <li>Hindari logo yang terlalu kompleks</li>
                <li>Pastikan logo terlihat baik pada background putih</li>
            </ul>

            <h6><i class="fas fa-sort text-warning me-2"></i>Urutan Tampilan:</h6>
            <p class="small mb-0">
                Urutan logo akan otomatis diatur di akhir. 
                Anda dapat mengubah urutan dengan drag & drop di halaman daftar mitra.
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewLogo(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
            document.getElementById('logo-preview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection
