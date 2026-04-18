@extends('admin.layout')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Event Kalender</h1>
        <a href="{{ route('admin.academic-calendar.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.academic-calendar.update', $academicCalendar) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="academic_year" class="form-label">Tahun Akademik <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('academic_year') is-invalid @enderror" 
                                       id="academic_year" 
                                       name="academic_year" 
                                       value="{{ old('academic_year', $academicCalendar->academic_year) }}"
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
                                    <option value="Ganjil" {{ old('semester', $academicCalendar->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ old('semester', $academicCalendar->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
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
                                   value="{{ old('title', $academicCalendar->title) }}"
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
                                      placeholder="Deskripsi detail tentang event ini...">{{ old('description', $academicCalendar->description) }}</textarea>
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
                                       value="{{ old('start_date', $academicCalendar->start_date->format('Y-m-d')) }}"
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
                                       value="{{ old('end_date', $academicCalendar->end_date?->format('Y-m-d')) }}">
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
                                    <option value="academic" {{ old('category', $academicCalendar->category) == 'academic' ? 'selected' : '' }}>
                                        Akademik
                                    </option>
                                    <option value="exam" {{ old('category', $academicCalendar->category) == 'exam' ? 'selected' : '' }}>
                                        Ujian
                                    </option>
                                    <option value="holiday" {{ old('category', $academicCalendar->category) == 'holiday' ? 'selected' : '' }}>
                                        Libur
                                    </option>
                                    <option value="registration" {{ old('category', $academicCalendar->category) == 'registration' ? 'selected' : '' }}>
                                        Pendaftaran
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
                                           value="{{ old('color', $academicCalendar->color) }}"
                                           required>
                                    <input type="text" 
                                           class="form-control" 
                                           id="color-hex" 
                                           value="{{ old('color', $academicCalendar->color) }}"
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
                                   value="{{ old('order', $academicCalendar->order) }}"
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
                                       {{ old('is_active', $academicCalendar->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Event Aktif
                                </label>
                            </div>
                            <small class="text-muted">Event aktif akan ditampilkan di website</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update
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
            <div class="card bg-light">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Info Event</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Status Event:</small>
                        @if($academicCalendar->isOngoing())
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-circle-dot me-1"></i>Sedang Berlangsung
                            </span>
                        @elseif($academicCalendar->isUpcoming())
                            <span class="badge bg-info fs-6">
                                <i class="fas fa-clock me-1"></i>Akan Datang
                            </span>
                        @else
                            <span class="badge bg-secondary fs-6">
                                <i class="fas fa-check me-1"></i>Sudah Lewat
                            </span>
                        @endif
                    </div>

                    @if($academicCalendar->end_date)
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Durasi:</small>
                            <strong>{{ $academicCalendar->getDurationDays() }} Hari</strong>
                        </div>
                    @endif

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Dibuat:</small>
                        <small>{{ $academicCalendar->created_at->format('d M Y H:i') }}</small>
                    </div>

                    <div>
                        <small class="text-muted d-block mb-1">Terakhir Diupdate:</small>
                        <small>{{ $academicCalendar->updated_at->format('d M Y H:i') }}</small>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-lightbulb me-2"></i>Tips</h5>
                </div>
                <div class="card-body">
                    <p class="small mb-0">
                        <i class="fas fa-check-circle text-success me-1"></i>
                        Pastikan tanggal selesai tidak lebih awal dari tanggal mulai.
                    </p>
                    <hr>
                    <p class="small mb-0">
                        <i class="fas fa-check-circle text-success me-1"></i>
                        Gunakan warna yang konsisten untuk kategori yang sama agar mudah dibaca.
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
