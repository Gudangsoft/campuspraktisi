@extends('admin.layout')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Tambah Event Kalender</h1>
        <a href="{{ route('admin.academic-calendar.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.academic-calendar.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="academic_year" class="form-label">Tahun Akademik <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('academic_year') is-invalid @enderror" 
                                       id="academic_year" 
                                       name="academic_year" 
                                       value="{{ old('academic_year', date('Y') . '/' . (date('Y') + 1)) }}"
                                       placeholder="Contoh: 2024/2025"
                                       required>
                                @error('academic_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: YYYY/YYYY (contoh: 2024/2025)</small>
                            </div>

                            <div class="col-md-6">
                                <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                <select class="form-select @error('semester') is-invalid @enderror" 
                                        id="semester" 
                                        name="semester" 
                                        required>
                                    <option value="">Pilih Semester</option>
                                    <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Event <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   placeholder="Contoh: Ujian Tengah Semester"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Deskripsi detail tentang event ini...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" 
                                       name="start_date" 
                                       value="{{ old('start_date') }}"
                                       required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="end_date" class="form-label">Tanggal Selesai</label>
                                <input type="date" 
                                       class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" 
                                       name="end_date" 
                                       value="{{ old('end_date') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Kosongkan jika event hanya 1 hari</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" 
                                        id="category" 
                                        name="category" 
                                        required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="academic" {{ old('category') == 'academic' ? 'selected' : '' }}>
                                        <i class="fas fa-graduation-cap"></i> Akademik
                                    </option>
                                    <option value="exam" {{ old('category') == 'exam' ? 'selected' : '' }}>
                                        <i class="fas fa-file-pen"></i> Ujian
                                    </option>
                                    <option value="holiday" {{ old('category') == 'holiday' ? 'selected' : '' }}>
                                        <i class="fas fa-umbrella-beach"></i> Libur
                                    </option>
                                    <option value="registration" {{ old('category') == 'registration' ? 'selected' : '' }}>
                                        <i class="fas fa-clipboard-list"></i> Pendaftaran
                                    </option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="color" class="form-label">Warna <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="color" 
                                           class="form-control form-control-color @error('color') is-invalid @enderror" 
                                           id="color" 
                                           name="color" 
                                           value="{{ old('color', '#3498db') }}"
                                           required>
                                    <input type="text" 
                                           class="form-control" 
                                           id="color-hex" 
                                           value="{{ old('color', '#3498db') }}"
                                           readonly>
                                </div>
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Pilih warna untuk ditampilkan di kalender</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">Urutan</label>
                            <input type="number" 
                                   class="form-control @error('order') is-invalid @enderror" 
                                   id="order" 
                                   name="order" 
                                   value="{{ old('order', 0) }}"
                                   min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Angka lebih kecil akan ditampilkan lebih awal</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Event Aktif
                                </label>
                            </div>
                            <small class="text-muted">Event aktif akan ditampilkan di website</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <a href="{{ route('admin.academic-calendar.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Panduan</h5>
                </div>
                <div class="card-body">
                    <h6><i class="fas fa-calendar-check text-primary me-2"></i>Kategori Event:</h6>
                    <ul class="small mb-3">
                        <li><strong>Akademik:</strong> Kuliah, orientasi, wisuda, dll</li>
                        <li><strong>Ujian:</strong> UTS, UAS, ujian susulan</li>
                        <li><strong>Libur:</strong> Libur semester, hari libur nasional</li>
                        <li><strong>Pendaftaran:</strong> Daftar ulang, KRS, dll</li>
                    </ul>

                    <h6><i class="fas fa-palette text-success me-2"></i>Tips Warna:</h6>
                    <ul class="small mb-3">
                        <li>Biru: Event akademik umum</li>
                        <li>Merah: Ujian dan deadline</li>
                        <li>Hijau: Libur dan event positif</li>
                        <li>Oranye: Pendaftaran dan administrasi</li>
                    </ul>

                    <h6><i class="fas fa-clock text-warning me-2"></i>Tanggal:</h6>
                    <p class="small mb-0">
                        Untuk event multi-hari (seperti UTS yang 1 minggu), isi tanggal mulai dan selesai.
                        Untuk event 1 hari, kosongkan tanggal selesai.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorInput = document.getElementById('color');
    const colorHex = document.getElementById('color-hex');

    colorInput.addEventListener('input', function() {
        colorHex.value = this.value;
    });
});
</script>
@endpush
@endsection
