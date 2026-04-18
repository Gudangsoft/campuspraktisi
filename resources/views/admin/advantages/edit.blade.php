@extends('admin.layout')

@section('title', 'Edit Keunggulan')
@section('page-title', 'Edit Keunggulan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.advantages.index') }}">Keunggulan Kami</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="content-card">
    <div class="content-card-header">
        <h5><i class="fas fa-edit me-2"></i>Edit Keunggulan</h5>
        <a href="{{ route('admin.advantages.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.advantages.update', $advantage->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label">Judul Keunggulan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                       name="title" value="{{ old('title', $advantage->title) }}" 
                       placeholder="Contoh: Kurikulum Berbasis Industri" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          name="description" rows="4" 
                          placeholder="Jelaskan keunggulan ini...">{{ old('description', $advantage->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Icon Font Awesome <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                       name="icon" value="{{ old('icon', $advantage->icon) }}" 
                       placeholder="fa-star" required>
                <small class="text-muted">
                    Contoh: fa-star, fa-graduation-cap, fa-users, fa-certificate
                    <a href="https://fontawesome.com/icons" target="_blank">Lihat daftar icon</a>
                </small>
                @error('icon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Warna Icon <span class="text-danger">*</span></label>
                <input type="color" class="form-control form-control-color @error('icon_color') is-invalid @enderror" 
                       name="icon_color" value="{{ old('icon_color', $advantage->icon_color) }}" required>
                <small class="text-muted">Pilih warna untuk background icon</small>
                @error('icon_color')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="is_active" 
                           name="is_active" value="1" {{ old('is_active', $advantage->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Aktif (Tampilkan di website)
                    </label>
                </div>
            </div>

            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update
                </button>
                <a href="{{ route('admin.advantages.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
