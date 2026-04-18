@extends('admin.layout')

@section('title', 'Edit Sambutan')
@section('page-title', 'Edit Sambutan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.greetings.index') }}">Sambutan</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Sambutan</h1>
        <a href="{{ route('admin.greetings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.greetings.update', $greeting) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="section_name" class="form-label">Nama Section <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('section_name') is-invalid @enderror" 
                                   id="section_name" 
                                   name="section_name" 
                                   value="{{ old('section_name', $greeting->section_name) }}" 
                                   required>
                            <small class="text-muted">Nama section yang akan ditampilkan di halaman depan (contoh: Sambutan, Selamat Datang, Welcome)</small>
                            @error('section_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $greeting->title) }}" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subtitle" class="form-label">Subtitle</label>
                            <input type="text" 
                                   class="form-control @error('subtitle') is-invalid @enderror" 
                                   id="subtitle" 
                                   name="subtitle" 
                                   value="{{ old('subtitle', $greeting->subtitle) }}">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Konten <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" 
                                      name="content" 
                                      rows="6" 
                                      required>{{ old('content', $greeting->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="person_name" class="form-label">Nama Orang</label>
                                    <input type="text" 
                                           class="form-control @error('person_name') is-invalid @enderror" 
                                           id="person_name" 
                                           name="person_name" 
                                           value="{{ old('person_name', $greeting->person_name) }}">
                                    <small class="text-muted">Nama yang menyampaikan sambutan</small>
                                    @error('person_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="person_title" class="form-label">Jabatan</label>
                                    <input type="text" 
                                           class="form-control @error('person_title') is-invalid @enderror" 
                                           id="person_title" 
                                           name="person_title" 
                                           value="{{ old('person_title', $greeting->person_title) }}">
                                    <small class="text-muted">Contoh: Direktur, Ketua, Rektor</small>
                                    @error('person_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar</label>
                            <input type="file" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*"
                                   onchange="previewImage(event)">
                            <small class="text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <div class="mt-2">
                                @if($greeting->image)
                                    <img id="image-preview" 
                                         src="{{ Storage::url($greeting->image) }}" 
                                         alt="Current Image" 
                                         class="img-fluid rounded" 
                                         style="max-height: 200px;">
                                @else
                                    <img id="image-preview" 
                                         src="" 
                                         alt="Preview" 
                                         class="img-fluid rounded d-none" 
                                         style="max-height: 200px;">
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">Urutan</label>
                            <input type="number" 
                                   class="form-control @error('order') is-invalid @enderror" 
                                   id="order" 
                                   name="order" 
                                   value="{{ old('order', $greeting->order) }}" 
                                   min="0">
                            <small class="text-muted">Urutan tampilan (semakin kecil semakin awal)</small>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', $greeting->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Aktif
                                </label>
                            </div>
                            <small class="text-muted">Sambutan akan ditampilkan di website jika aktif</small>
                        </div>
                    </div>
                </div>

                <div class="border-top pt-3 mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a href="{{ route('admin.greetings.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(event) {
    const preview = document.getElementById('image-preview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection
