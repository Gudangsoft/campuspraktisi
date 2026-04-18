@extends('admin.layout')

@section('title', 'Testimoni Alumni')
@section('page-title', 'Manajemen Testimoni Alumni')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Testimoni Alumni</li>
@endsection

@section('content')

@if(setting('testimonials_section_enabled', '1') == '0')
<div class="alert alert-warning alert-dismissible fade show">
    <i class="fas fa-eye-slash me-2"></i>
    <strong>Perhatian!</strong> Section "Testimoni Alumni" saat ini <strong>TIDAK DITAMPILKAN</strong> di website. 
    Aktifkan di pengaturan di bawah untuk menampilkannya.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@else
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-eye me-2"></i>
    <strong>Aktif!</strong> Section "Testimoni Alumni" saat ini <strong>DITAMPILKAN</strong> di website.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Section Settings -->
<div class="content-card mb-3">
    <div class="content-card-header">
        <h5><i class="fas fa-cog me-2"></i>Pengaturan Section Testimoni</h5>
        <small class="text-muted">Atur visibilitas, judul dan subtitle section di halaman utama</small>
    </div>
    
    <form action="{{ route('admin.testimonials.update-settings') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" 
                           type="checkbox" 
                           role="switch" 
                           id="testimonials_section_enabled" 
                           name="testimonials_section_enabled"
                           {{ setting('testimonials_section_enabled', '1') == '1' ? 'checked' : '' }}
                           style="width: 3rem; height: 1.5rem;">
                    <label class="form-check-label fw-bold ms-2" for="testimonials_section_enabled">
                        <i class="fas fa-toggle-on text-success me-1"></i>
                        Tampilkan Section "Testimoni Alumni" di Website
                    </label>
                </div>
                <small class="text-muted ms-5 ps-2">
                    <i class="fas fa-info-circle me-1"></i>
                    Matikan untuk menyembunyikan section ini dari halaman utama
                </small>
                <hr class="my-3">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold">
                    <i class="fas fa-heading text-primary me-1"></i>Judul Section
                </label>
                <input type="text" 
                       class="form-control" 
                       name="testimonials_title" 
                       value="{{ setting('testimonials_title', 'Testimoni Alumni') }}"
                       placeholder="Contoh: Testimoni Alumni"
                       required>
                <small class="text-muted">Judul besar yang ditampilkan di bagian atas section</small>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold">
                    <i class="fas fa-align-left text-primary me-1"></i>Subtitle Section
                </label>
                <input type="text" 
                       class="form-control" 
                       name="testimonials_subtitle" 
                       value="{{ setting('testimonials_subtitle', 'Apa Kata Mereka Tentang Kami') }}"
                       placeholder="Contoh: Apa Kata Mereka Tentang Kami">
                <small class="text-muted">Deskripsi singkat di bawah judul</small>
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan Pengaturan
                </button>
            </div>
        </div>
    </form>
</div>

<div class="content-card">
    <div class="content-card-header">
        <h5><i class="fas fa-quote-left me-2"></i>Daftar Testimoni</h5>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Testimoni
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($testimonials->count() > 0)
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Tips:</strong> Seret dan lepas card untuk mengubah urutan tampilan.
        </div>

        <div id="sortable-testimonials" class="row g-4">
            @foreach($testimonials as $testimonial)
            <div class="col-md-6 col-lg-3" data-id="{{ $testimonial->id }}">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="drag-handle text-center mb-3" style="cursor: move; color: #999;">
                            <i class="fas fa-grip-vertical fa-2x"></i>
                        </div>
                        
                        <div class="text-center mb-3">
                            @if($testimonial->photo)
                                <img src="{{ asset('storage/' . $testimonial->photo) }}" 
                                     alt="{{ $testimonial->name }}"
                                     class="rounded-circle"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center"
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-user fa-2x text-white"></i>
                                </div>
                            @endif
                        </div>
                        
                        <h5 class="card-title text-center mb-1">{{ $testimonial->name }}</h5>
                        
                        @if($testimonial->graduation_year)
                            <p class="text-center text-muted small mb-2">
                                <i class="fas fa-graduation-cap me-1"></i>Lulusan {{ $testimonial->graduation_year }}
                            </p>
                        @endif
                        
                        @if($testimonial->current_position)
                            <p class="text-center text-primary small mb-2">
                                <i class="fas fa-briefcase me-1"></i>{{ $testimonial->current_position }}
                                @if($testimonial->company)
                                    <br>di {{ $testimonial->company }}
                                @endif
                            </p>
                        @endif
                        
                        <div class="text-center mb-3">
                            {!! $testimonial->getStarRatingHtml() !!}
                        </div>
                        
                        <p class="text-muted small mb-3" style="font-style: italic;">
                            "{{ Str::limit($testimonial->testimonial, 100) }}"
                        </p>
                        
                        <div class="text-center mb-3">
                            @if($testimonial->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Non-aktif</span>
                            @endif
                        </div>
                        
                        <div class="btn-group btn-group-sm w-100">
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" 
                               class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus testimoni ini?')"
                                  class="d-inline w-50">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-quote-left text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">Belum ada testimoni. Klik tombol "Tambah Testimoni" untuk menambahkan.</p>
        </div>
    @endif
</div>

@push('styles')
<style>
    .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }
    
    .form-check-input:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
    }
    
    .form-check-input {
        cursor: pointer;
    }
    
    .form-check-label {
        cursor: pointer;
        user-select: none;
    }

    .sortable-ghost {
        opacity: 0.4;
    }

    .sortable-chosen {
        cursor: grabbing;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('sortable-testimonials');
    if (container) {
        new Sortable(container, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function(evt) {
                const orders = {};
                document.querySelectorAll('#sortable-testimonials > div').forEach((el, index) => {
                    orders[el.dataset.id] = index;
                });

                fetch('{{ route("admin.testimonials.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ orders: orders })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success alert-dismissible fade show';
                        alertDiv.innerHTML = `
                            <i class="fas fa-check-circle me-2"></i>${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                        
                        const contentCard = document.querySelector('.content-card');
                        contentCard.insertBefore(alertDiv, contentCard.children[1]);

                        setTimeout(() => {
                            alertDiv.remove();
                        }, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal mengupdate urutan.');
                });
            }
        });
    }
});
</script>
@endpush
@endsection
