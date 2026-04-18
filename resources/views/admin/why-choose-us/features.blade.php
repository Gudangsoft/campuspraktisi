@extends('admin.layout')

@section('title', 'Kelola Fitur - ' . $whyChooseUs->title)
@section('page-title', 'Kelola Fitur')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.why-choose-us.index') }}">Why Choose Us</a></li>
    <li class="breadcrumb-item active">Kelola Fitur</li>
@endsection

@section('content')
<div class="content-card mb-3">
    <div class="content-card-header">
        <div class="d-flex align-items-center">
            <div class="icon-circle me-3" style="background-color: {{ $whyChooseUs->icon_color }};">
                <i class="fas {{ $whyChooseUs->icon }} text-white"></i>
            </div>
            <div>
                <h5 class="mb-0">{{ $whyChooseUs->title }}</h5>
                @if($whyChooseUs->subtitle)
                    <small class="text-muted">{{ $whyChooseUs->subtitle }}</small>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="content-card-header">
        <h5><i class="fas fa-list me-2"></i>Daftar Fitur</h5>
        <small class="text-muted">Kelola poin-poin fitur yang ditampilkan di card ini</small>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Add Feature Form -->
    <div class="card mb-3">
        <div class="card-body">
            <h6 class="card-title">
                <i class="fas fa-plus-circle me-2"></i>Tambah Fitur Baru
            </h6>
            <form action="{{ route('admin.why-choose-us.features.store', $whyChooseUs->id) }}" method="POST">
                @csrf
                <div class="row g-2">
                    <div class="col-md-8">
                        <input type="text" 
                               class="form-control @error('feature_text') is-invalid @enderror" 
                               name="feature_text" 
                               placeholder="Contoh: Belajar dengan jadwal fleksibel" 
                               required>
                        @error('feature_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <input type="text" 
                               class="form-control @error('icon') is-invalid @enderror" 
                               name="icon" 
                               placeholder="fa-check (opsional)">
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Features List -->
    @if($whyChooseUs->features->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-list text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">Belum ada fitur. Gunakan form di atas untuk menambahkan fitur.</p>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Tips:</strong> Seret dan lepas fitur untuk mengubah urutan tampilan.
        </div>

        <div id="sortable-features">
            @foreach($whyChooseUs->features as $feature)
            <div class="card mb-2 feature-item" data-id="{{ $feature->id }}" data-order="{{ $feature->order }}">
                <div class="card-body py-2">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="drag-handle" title="Seret untuk mengubah urutan">
                                <i class="fas fa-grip-vertical text-muted"></i>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center">
                                @if($feature->icon)
                                    <i class="fas {{ $feature->icon }} text-success me-2"></i>
                                @else
                                    <i class="fas fa-check text-success me-2"></i>
                                @endif
                                <span id="feature-text-{{ $feature->id }}">{{ $feature->feature_text }}</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <form action="{{ route('admin.why-choose-us.features.destroy', [$whyChooseUs->id, $feature->id]) }}" 
                                  method="POST" 
                                  class="d-inline" 
                                  onsubmit="return confirm('Yakin ingin menghapus fitur ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('admin.why-choose-us.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <a href="{{ route('admin.why-choose-us.edit', $whyChooseUs->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Card
        </a>
    </div>
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
    padding: 0.5rem;
}

.drag-handle:active {
    cursor: grabbing;
}

.feature-item.sortable-ghost {
    opacity: 0.4;
}

.feature-item.sortable-chosen {
    background-color: #f8f9fa;
}
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sortable for features
    const sortableEl = document.getElementById('sortable-features');
    
    if (sortableEl) {
        const sortable = new Sortable(sortableEl, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function(evt) {
                // Get all items in new order
                const items = [];
                document.querySelectorAll('.feature-item').forEach((el, index) => {
                    items.push({
                        id: parseInt(el.dataset.id),
                        order: index
                    });
                });

                // Send AJAX request to update order
                fetch('{{ route("admin.why-choose-us.features.reorder", $whyChooseUs->id) }}', {
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
                        
                        const contentCard = document.querySelectorAll('.content-card')[1];
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
