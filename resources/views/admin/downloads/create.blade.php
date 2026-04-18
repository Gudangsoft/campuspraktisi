@extends('admin.layout')

@section('title', 'Tambah File Download')
@section('page-title', 'Tambah File Download')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.downloads.index') }}">Download Center</a></li>
    <li class="breadcrumb-item active">Tambah File</li>
@endsection

@section('content')
<form action="{{ route('admin.downloads.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row">
        <div class="col-lg-8">
            <div class="content-card">
                <div class="content-card-header">
                    <h5><i class="fas fa-file-upload me-2"></i>Informasi File</h5>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul File <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                              rows="4">{{ old('description') }}</textarea>
                    <small class="text-muted">Deskripsi singkat tentang file ini</small>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipe Sumber File <span class="text-danger">*</span></label>
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="source_type" id="source_upload" value="upload" checked onchange="toggleSource()">
                        <label class="btn btn-outline-primary" for="source_upload">
                            <i class="fas fa-upload me-1"></i> Upload File
                        </label>
                        
                        <input type="radio" class="btn-check" name="source_type" id="source_gdrive" value="gdrive" onchange="toggleSource()">
                        <label class="btn btn-outline-primary" for="source_gdrive">
                            <i class="fab fa-google-drive me-1"></i> Google Drive
                        </label>
                    </div>
                </div>

                <div class="mb-3" id="upload_section">
                    <label class="form-label">Upload File <span class="text-danger">*</span></label>
                    <input type="file" name="file" id="file_input" class="form-control @error('file') is-invalid @enderror">
                    <small class="text-muted">Maksimal 10 MB. Format: PDF, DOC, XLS, PPT, ZIP, dll</small>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3" id="gdrive_section" style="display:none;">
                    <label class="form-label">Link Google Drive <span class="text-danger">*</span></label>
                    <input type="url" name="gdrive_url" id="gdrive_input" class="form-control @error('gdrive_url') is-invalid @enderror" 
                           placeholder="https://drive.google.com/file/d/...">
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
                        <option value="formulir" {{ old('category') == 'formulir' ? 'selected' : '' }}>Formulir</option>
                        <option value="panduan" {{ old('category') == 'panduan' ? 'selected' : '' }}>Panduan</option>
                        <option value="brosur" {{ old('category') == 'brosur' ? 'selected' : '' }}>Brosur</option>
                        <option value="peraturan" {{ old('category') == 'peraturan' ? 'selected' : '' }}>Peraturan</option>
                        <option value="kurikulum" {{ old('category') == 'kurikulum' ? 'selected' : '' }}>Kurikulum</option>
                        <option value="kalender" {{ old('category') == 'kalender' ? 'selected' : '' }}>Kalender Akademik</option>
                        <option value="umum" {{ old('category') == 'umum' ? 'selected' : '' }}>Umum</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                        <label class="form-check-label" for="is_active">
                            Aktifkan file ini
                        </label>
                    </div>
                    <small class="text-muted">File yang aktif dapat diunduh pengunjung</small>
                </div>

                <hr>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan File
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
function toggleSource() {
    const sourceType = document.querySelector('input[name="source_type"]:checked').value;
    const uploadSection = document.getElementById('upload_section');
    const gdriveSection = document.getElementById('gdrive_section');
    const fileInput = document.getElementById('file_input');
    const gdriveInput = document.getElementById('gdrive_input');
    
    if (sourceType === 'upload') {
        uploadSection.style.display = 'block';
        gdriveSection.style.display = 'none';
        fileInput.required = true;
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
