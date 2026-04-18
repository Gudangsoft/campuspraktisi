@extends('admin.layout')

@section('title', 'Why Choose Us')
@section('page-title', 'Why Choose Us')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Why Choose Us</li>
@endsection

@section('content')

@if(setting('why_choose_us_enabled', '1') == '0')
<div class="alert alert-warning alert-dismissible fade show">
    <i class="fas fa-eye-slash me-2"></i>
    <strong>Perhatian!</strong> Section "Why Choose Us" saat ini <strong>TIDAK DITAMPILKAN</strong> di website. 
    Aktifkan di pengaturan di bawah untuk menampilkannya.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@else
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-eye me-2"></i>
    <strong>Aktif!</strong> Section "Why Choose Us" saat ini <strong>DITAMPILKAN</strong> di website.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Section Title & Description Settings -->
<div class="content-card mb-3">
    <div class="content-card-header">
        <h5><i class="fas fa-heading me-2"></i>Pengaturan Section</h5>
        <small class="text-muted">Atur visibilitas, judul dan deskripsi section di halaman utama</small>
    </div>
    
    <form action="{{ route('admin.why-choose-us.update-settings') }}" method="POST" id="settings-form">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" 
                           type="checkbox" 
                           role="switch" 
                           id="why_choose_us_enabled" 
                           name="why_choose_us_enabled"
                           {{ setting('why_choose_us_enabled', '1') == '1' ? 'checked' : '' }}
                           style="width: 3rem; height: 1.5rem;">
                    <label class="form-check-label fw-bold ms-2" for="why_choose_us_enabled">
                        <i class="fas fa-toggle-on text-success me-1"></i>
                        Tampilkan Section "Why Choose Us" di Website
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
                       name="why_choose_us_title" 
                       value="{{ setting('why_choose_us_title', 'Kenapa Memilih Kami?') }}"
                       placeholder="Contoh: Kenapa Memilih Kami?"
                       required>
                <small class="text-muted">Judul besar yang ditampilkan di bagian atas section</small>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">
                    <i class="fas fa-align-left text-primary me-1"></i>Deskripsi Section
                </label>
                <input type="text" 
                       class="form-control" 
                       name="why_choose_us_description" 
                       value="{{ setting('why_choose_us_description', 'Keunggulan yang kami tawarkan untuk kesuksesan Anda') }}"
                       placeholder="Contoh: Keunggulan yang kami tawarkan untuk kesuksesan Anda"
                       required>
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
    <div class="content-card-header d-flex justify-content-between align-items-center">
        <div>
            <h5><i class="fas fa-star me-2"></i>Daftar Why Choose Us Cards</h5>
            <small class="text-muted">Kelola kartu fitur unggulan yang ditampilkan di halaman utama</small>
        </div>
        <a href="{{ route('admin.why-choose-us.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Card
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Tips:</strong> Seret dan lepas kartu untuk mengubah urutan tampilan. Klik "Kelola Fitur" untuk menambahkan poin-poin fitur di setiap card.
    </div>

    @if($items->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-star text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">Belum ada card. Klik tombol "Tambah Card" untuk menambahkan.</p>
        </div>
    @else
        <div id="sortable-cards" class="row g-3">
            @foreach($items as $item)
            <div class="col-md-4" data-id="{{ $item->id }}" data-order="{{ $item->order }}">
                <div class="card shadow-sm h-100" style="border-left: 4px solid {{ $item->icon_color }};">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle me-3" style="background-color: {{ $item->icon_color }};">
                                    <i class="fas {{ $item->icon }} text-white"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-0">{{ $item->title }}</h5>
                                    @if($item->subtitle)
                                        <small class="text-muted">{{ $item->subtitle }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="drag-handle" title="Seret untuk mengubah urutan">
                                <i class="fas fa-grip-vertical text-muted"></i>
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="fas fa-list me-1"></i>
                                {{ $item->features->count() }} fitur
                            </small>
                        </div>

                        @if($item->features->isNotEmpty())
                            <ul class="list-unstyled mb-3" style="font-size: 0.875rem;">
                                @foreach($item->features->take(3) as $feature)
                                <li class="mb-1">
                                    <i class="fas fa-check text-success me-1"></i>
                                    {{ Str::limit($feature->feature_text, 40) }}
                                </li>
                                @endforeach
                                @if($item->features->count() > 3)
                                    <li class="text-muted">
                                        <small>+ {{ $item->features->count() - 3 }} fitur lainnya</small>
                                    </li>
                                @endif
                            </ul>
                        @endif

                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('admin.why-choose-us.features', $item->id) }}" 
                               class="btn btn-sm btn-info text-white flex-fill" title="Kelola fitur">
                                <i class="fas fa-list"></i> Fitur ({{ $item->features->count() }})
                            </a>
                            <a href="{{ route('admin.why-choose-us.edit', $item->id) }}" 
                               class="btn btn-sm btn-warning" title="Edit card">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.why-choose-us.destroy', $item->id) }}" 
                                  method="POST" 
                                  class="d-inline" 
                                  onsubmit="return confirm('Yakin ingin menghapus card ini? Semua fitur di dalamnya juga akan terhapus.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus card">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>

                        <div class="mt-2">
                            @if($item->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<style>
.icon-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.drag-handle {
    cursor: move;
    cursor: grab;
}

.drag-handle:active {
    cursor: grabbing;
}

#sortable-cards .sortable-ghost {
    opacity: 0.4;
}

#sortable-cards .sortable-chosen {
    background-color: #f8f9fa;
}
</style>

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
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sortableEl = document.getElementById('sortable-cards');
    
    if (sortableEl) {
        const sortable = new Sortable(sortableEl, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function(evt) {
                // Get all items in new order
                const items = [];
                document.querySelectorAll('#sortable-cards > div').forEach((el, index) => {
                    items.push({
                        id: parseInt(el.dataset.id),
                        order: index
                    });
                });

                // Send AJAX request to update order
                fetch('{{ route("admin.why-choose-us.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ items: items })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success alert-dismissible fade show';
                        alertDiv.innerHTML = `
                            <i class="fas fa-check-circle me-2"></i>${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                        
                        const contentCard = document.querySelector('.content-card');
                        contentCard.insertBefore(alertDiv, contentCard.children[1]);

                        // Auto dismiss after 3 seconds
                        setTimeout(() => {
                            alertDiv.remove();
                        }, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal mengupdate urutan. Silakan refresh halaman.');
                });
            }
        });
    }
});
</script>
@endpush
@endsection
