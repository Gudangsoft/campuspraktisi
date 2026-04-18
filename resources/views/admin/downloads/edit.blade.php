@extends('admin.layout')

@section('title', 'Edit File Download')
@section('page-title', 'Edit File Download')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.downloads.index') }}">Download Center</a></li>
    <li class="breadcrumb-item active">Edit File</li>
@endsection

@section('content')
<form action="{{ route('admin.downloads.update', $download) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-lg-8">
            <div class="content-card">
                <div class="content-card-header">
                    <h5><i class="fas fa-edit me-2"></i>Informasi File</h5>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul File <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title', $download->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                              rows="4">{{ old('description', $download->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">File Saat Ini</label>
                    <div class="alert alert-info">
                        @if($download->source_type === 'gdrive')
                            <i class="fab fa-google-drive me-2 text-success"></i>
                            <strong>Google Drive Link</strong>
                            <a href="{{ $download->gdrive_url }}" 
                               class="btn btn-sm btn-info float-end" target="_blank">
                                <i class="fas fa-external-link-alt"></i> Buka
                            </a>
                        @else
                            <i class="fas {{ $download->file_icon }} me-2"></i>
                            <strong>{{ $download->title }}.{{ $download->file_type }}</strong>
                            <span class="badge bg-secondary ms-2">{{ $download->file_size_formatted }}</span>
                            <a href="{{ asset('storage/' . $download->file_path) }}" 
                               class="btn btn-sm btn-info float-end" target="_blank">
                                <i class="fas fa-eye"></i> Preview
                            </a>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipe Sumber File <span class="text-danger">*</span></label>
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="source_type" id="source_upload" value="upload" 
                               {{ $download->source_type === 'upload' ? 'checked' : '' }} onchange="toggleSourceEdit()">
                        <label class="btn btn-outline-primary" for="source_upload">
                            <i class="fas fa-upload me-1"></i> Upload File
                        </label>
                        
                        <input type="radio" class="btn-check" name="source_type" id="source_gdrive" value="gdrive"
                               {{ $download->source_type === 'gdrive' ? 'checked' : '' }} onchange="toggleSourceEdit()">
                        <label class="btn btn-outline-primary" for="source_gdrive">
                            <i class="fab fa-google-drive me-1"></i> Google Drive
                        </label>
                    </div>
                </div>

                <div class="mb-3" id="upload_section" style="display: {{ $download->source_type === 'upload' ? 'block' : 'none' }};">
                    <label class="form-label">Upload File Baru (Opsional)</label>
                    <input type="file" name="file" id="file_input" class="form-control @error('file') is-invalid @enderror">
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti file. Maksimal 10 MB</small>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3" id="gdrive_section" style="display: {{ $download->source_type === 'gdrive' ? 'block' : 'none' }};">
                    <label class="form-label">Link Google Drive <span class="text-danger">*</span></label>
                    <input type="url" name="gdrive_url" id="gdrive_input" class="form-control @error('gdrive_url') is-invalid @enderror" 
                           placeholder="https://drive.google.com/file/d/..." 
                           value="{{ old('gdrive_url', $download->gdrive_url) }}">
                    <small class="text-muted">Pastikan file bisa diakses publik (Anyone with the link)</small>
                    @error('gdrive_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="content-card">
                <div class="content-card-header">
                    <h5><i class="fas fa-cog me-2"></i>Pengaturan</h5>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                        <option value="">Pilih Kategori</option>
                        <option value="formulir" {{ old('category', $download->category) == 'formulir' ? 'selected' : '' }}>Formulir</option>
                        <option value="panduan" {{ old('category', $download->category) == 'panduan' ? 'selected' : '' }}>Panduan</option>
                        <option value="brosur" {{ old('category', $download->category) == 'brosur' ? 'selected' : '' }}>Brosur</option>
                        <option value="peraturan" {{ old('category', $download->category) == 'peraturan' ? 'selected' : '' }}>Peraturan</option>
                        <option value="kurikulum" {{ old('category', $download->category) == 'kurikulum' ? 'selected' : '' }}>Kurikulum</option>
                        <option value="kalender" {{ old('category', $download->category) == 'kalender' ? 'selected' : '' }}>Kalender Akademik</option>
                        <option value="umum" {{ old('category', $download->category) == 'umum' ? 'selected' : '' }}>Umum</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                               {{ $download->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Aktifkan file ini
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Statistik</label>
                    <div class="alert alert-success mb-0">
                        <i class="fas fa-download me-2"></i>
                        Diunduh <strong>{{ number_format($download->downloads_count) }}</strong> kali
                    </div>
                </div>

                <hr>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update File
                    </button>
                    <a href="{{ route('admin.downloads.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

@section('scripts')
<script>
function toggleSourceEdit() {
    const sourceType = document.querySelector('input[name="source_type"]:checked').value;
    const uploadSection = document.getElementById('upload_section');
    const gdriveSection = document.getElementById('gdrive_section');
    const fileInput = document.getElementById('file_input');
    const gdriveInput = document.getElementById('gdrive_input');
    
    if (sourceType === 'upload') {
        uploadSection.style.display = 'block';
        gdriveSection.style.display = 'none';
        fileInput.required = false; // Optional for edit
        gdriveInput.required = false;
    } else {
        uploadSection.style.display = 'none';
        gdriveSection.style.display = 'block';
        fileInput.required = false;
        gdriveInput.required = true;
    }
}
</script>
@endsection
@endsection
