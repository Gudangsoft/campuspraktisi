@extends('admin.layout')

@section('title', 'Edit Program Studi Unggulan')
@section('page-title', 'Edit Program Studi Unggulan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.prodi-unggulan.index') }}">Prodi Unggulan</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="content-card">
    <div class="content-card-header">
        <h5><i class="fas fa-edit me-2"></i>Form Edit Prodi Unggulan</h5>
    </div>

    <form action="{{ route('admin.prodi-unggulan.update', $prodiUnggulan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label">Nama Program Studi <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $prodiUnggulan->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi Singkat</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="5">{{ old('deskripsi', $prodiUnggulan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Link/Tautan Detail (Opsional)</label>
                    <input type="url" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link', $prodiUnggulan->link) }}" placeholder="https://...">
                    @error('link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Link ke website fakultas/prodi terkait.</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Gambar/Logo (Opsional)</label>
                    <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*" id="imageInput">
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    <div class="mt-3">
                        <img id="imagePreview" src="{{ $prodiUnggulan->gambar ? asset('storage/'.$prodiUnggulan->gambar) : '#' }}" alt="Preview" class="img-fluid rounded {{ $prodiUnggulan->gambar ? '' : 'd-none' }}" style="max-height: 200px; object-fit: cover;">
                        @if($prodiUnggulan->gambar)
                            <small class="text-muted d-block mt-2">Gambar saat ini.</small>
                        @endif
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update
                    </button>
                    <a href="{{ route('admin.prodi-unggulan.index') }}" class="btn btn-light border">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Image Preview
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            // Keep the old image if file selection is cancelled
            @if($prodiUnggulan->gambar)
                preview.src = "{{ asset('storage/'.$prodiUnggulan->gambar) }}";
                preview.classList.remove('d-none');
            @else
                preview.src = '#';
                preview.classList.add('d-none');
            @endif
        }
    });
</script>
@endpush
@endsection
