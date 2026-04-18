@extends('admin.layout')

@section('title', 'Keunggulan Kami')
@section('page-title', 'Keunggulan Kami')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Keunggulan Kami</li>
@endsection

@section('content')
<div class="content-card">
    <div class="content-card-header">
        <h5><i class="fas fa-star me-2"></i>Daftar Keunggulan</h5>
        <a href="{{ route('admin.advantages.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Keunggulan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Section Settings -->
    <div class="card mb-3">
        <div class="card-body">
            <h6 class="card-title"><i class="fas fa-cog me-2"></i>Pengaturan Section</h6>
            <form action="{{ route('admin.advantages.update-settings') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="advantages_section_enabled" 
                                   name="advantages_section_enabled" value="1"
                                   {{ setting('advantages_section_enabled', '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="advantages_section_enabled">
                                <strong>Tampilkan Section Keunggulan</strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Judul Section</label>
                        <input type="text" class="form-control" name="advantages_title" 
                               value="{{ setting('advantages_title', 'Keunggulan Kami') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Subjudul Section</label>
                        <input type="text" class="form-control" name="advantages_subtitle" 
                               value="{{ setting('advantages_subtitle', 'Politeknik Praktisi Bandung menawarkan berbagai keunggulan yang membedakan kami dari institusi pendidikan lainnya.') }}">
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Pengaturan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($advantages->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-star text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">Belum ada data keunggulan. Klik tombol "Tambah Keunggulan" untuk menambahkan.</p>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Tips:</strong> Seret dan lepas card untuk mengubah urutan tampilan.
        </div>

        <div id="sortable-advantages" class="row">
            @foreach($advantages as $advantage)
            <div class="col-md-4 mb-3 advantage-item" data-id="{{ $advantage->id }}" data-order="{{ $advantage->order }}">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="drag-handle" title="Seret untuk mengubah urutan">
                                <i class="fas fa-grip-vertical text-muted"></i>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" 
                                       {{ $advantage->is_active ? 'checked' : '' }} disabled>
                            </div>
                        </div>
                        <div class="text-center mb-3">
                            <div class="icon-circle mx-auto mb-3" style="background-color: {{ $advantage->icon_color }}; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                <i class="fas {{ $advantage->icon }} text-white" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="card-title">{{ $advantage->title }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($advantage->description, 100) }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.advantages.edit', $advantage->id) }}" class="btn btn-sm btn-warning flex-fill">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.advantages.destroy', $advantage->id) }}" method="POST" class="flex-fill">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<style>
.drag-handle {
    cursor: grab;
    padding: 0.5rem;
}

.drag-handle:active {
    cursor: grabbing;
}

.advantage-item.sortable-ghost {
    opacity: 0.4;
}

.advantage-item.sortable-chosen {
    transform: scale(1.05);
}
</style>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sortableEl = document.getElementById('sortable-advantages');
    
    if (sortableEl) {
        new Sortable(sortableEl, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function(evt) {
                const items = [];
                document.querySelectorAll('.advantage-item').forEach((el, index) => {
                    items.push({
                        id: parseInt(el.dataset.id),
                        order: index
                    });
                });

                fetch('{{ route("admin.advantages.reorder") }}', {
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
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success alert-dismissible fade show';
                        alertDiv.innerHTML = `
                            <i class="fas fa-check-circle me-2"></i>${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                        document.querySelector('.content-card').insertBefore(alertDiv, document.querySelector('.content-card').children[1]);
                        setTimeout(() => alertDiv.remove(), 3000);
                    }
                });
            }
        });
    }
});
</script>
@endsection
@endsection
