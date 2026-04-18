@extends('admin.layout')

@section('title', 'Edit Mitra')
@section('page-title', 'Edit Mitra')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.partners.index') }}">Mitra</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="content-card">
            <div class="content-card-header">
                <h5><i class="fas fa-handshake me-2"></i>Form Edit Mitra</h5>
            </div>

            <form action="{{ route('admin.partners.update', $partner) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Mitra <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $partner->name) }}"
                           placeholder="Contoh: PT. ABC Indonesia"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="logo" class="form-label">Logo Mitra</label>
                    
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $partner->logo) }}" 
                             alt="{{ $partner->name }}"
                             class="img-thumbnail"
                             style="max-height: 150px;">
                    </div>
                    
                    <input type="file" 
                           class="form-control @error('logo') is-invalid @enderror" 
                           id="logo" 
                           name="logo" 
                           accept="image/*"
                           onchange="previewLogo(event)">
                    @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah logo. Max: 2MB</small>
                    
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
                           value="{{ old('website', $partner->website) }}"
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
                              placeholder="Deskripsi singkat tentang mitra...">{{ old('description', $partner->description) }}</textarea>
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
                               {{ old('is_active', $partner->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Tampilkan di website
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update
                    </button>
                    <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="content-card bg-light">
            <div class="content-card-header">
                <h5><i class="fas fa-info-circle me-2"></i>Info Mitra</h5>
            </div>

            <div class="mb-3">
                <small class="text-muted d-block mb-1">Status:</small>
                @if($partner->is_active)
                    <span class="badge bg-success fs-6">
                        <i class="fas fa-check-circle me-1"></i>Aktif
                    </span>
                @else
                    <span class="badge bg-secondary fs-6">
                        <i class="fas fa-times-circle me-1"></i>Non-aktif
                    </span>
                @endif
            </div>

            <div class="mb-3">
                <small class="text-muted d-block mb-1">Dibuat:</small>
                <small>{{ $partner->created_at->format('d M Y H:i') }}</small>
            </div>

            <div>
                <small class="text-muted d-block mb-1">Terakhir Diupdate:</small>
                <small>{{ $partner->updated_at->format('d M Y H:i') }}</small>
            </div>
        </div>

        <div class="content-card mt-3">
            <div class="content-card-header">
                <h5><i class="fas fa-lightbulb me-2"></i>Tips</h5>
            </div>

            <p class="small mb-2">
                <i class="fas fa-check-circle text-success me-1"></i>
                Gunakan logo dengan background transparan untuk hasil terbaik.
            </p>
            <hr>
            <p class="small mb-0">
                <i class="fas fa-check-circle text-success me-1"></i>
                Pastikan logo terlihat jelas dan profesional.
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
