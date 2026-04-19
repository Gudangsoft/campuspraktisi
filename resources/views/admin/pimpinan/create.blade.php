@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Pimpinan</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.pimpinan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan') }}" required>
                        @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                            <option value="pimpinan" {{ old('kategori') == 'pimpinan' ? 'selected' : '' }}>Pimpinan Kampus</option>
                            <option value="yayasan" {{ old('kategori') == 'yayasan' ? 'selected' : '' }}>Struktur Yayasan</option>
                        </select>
                        @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Urutan (Order)</label>
                        <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
                        @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Foto</label>
                        <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">
                        <div class="form-text">Maksimal 2MB (Format: jpg, png, jpeg)</div>
                        @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email (Opsional)</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">LinkedIn URL (Opsional)</label>
                        <input type="url" name="linkedin" class="form-control" value="{{ old('linkedin') }}">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    <a href="{{ route('admin.pimpinan.index') }}" class="btn btn-secondary px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
