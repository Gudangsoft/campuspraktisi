@extends('admin.layout')

@section('title','Berita')
@section('page-title', 'Manajemen Berita')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Berita</li>
@endsection

@section('content')
<div class="content-card">
    <div class="content-card-header">
        <h5><i class="fas fa-newspaper me-2"></i>Daftar Berita</h5>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Buat Berita Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form id="bulkDeleteForm" method="POST" action="{{ route('admin.news.bulk-delete') }}">
        @csrf
        @method('DELETE')
        
        <div class="mb-3" id="bulkActionsBar" style="display:none;">
            <button type="button" class="btn btn-danger" id="deleteSelectedBtn">
                <i class="fas fa-trash me-1"></i> Hapus <span id="selectedCount">0</span> Berita Terpilih
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="40">
                            <input type="checkbox" id="checkAll" class="form-check-input">
                        </th>
                        <th width="60">Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th width="100">Status</th>
                        <th>Published</th>
                        <th width="80">Views</th>
                        <th width="150" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
            @forelse($news as $n)
                <tr>
                    <td>
                        <input type="checkbox" name="ids[]" value="{{ $n->id }}" class="form-check-input news-checkbox">
                    </td>
                    <td>
                        @if($n->image)
                            <img src="{{ asset('storage/'.$n->image) }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ Str::limit($n->title, 50) }}</strong>
                        <br><small class="text-muted">{{ $n->created_at->format('d M Y H:i') }}</small>
                    </td>
                    <td><span class="badge bg-info">{{ $n->category->name }}</span></td>
                    <td>{{ $n->user->name }}</td>
                    <td>
                        @if($n->status == 'published')
                            <span class="badge bg-success">Published</span>
                        @else
                            <span class="badge bg-warning">Draft</span>
                        @endif
                    </td>
                    <td>{{ $n->published_at?->format('d M Y') ?: '-' }}</td>
                    <td><span class="badge bg-secondary">{{ number_format($n->views) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('news.show', $n->slug) }}" class="btn btn-sm btn-outline-info" target="_blank" title="Lihat">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.news.edit',$n->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.news.destroy',$n->id) }}" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">
                        <i class="fas fa-newspaper fa-2x mb-2"></i>
                        <p>Belum ada berita. <a href="{{ route('admin.news.create') }}">Buat berita pertama</a></p>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    </form>

    @if($news->hasPages())
        <div class="mt-3">
            {{ $news->links() }}
        </div>
    @endif
</div>

<script>
(function() {
    'use strict';
    
    // Wait for DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBulkDelete);
    } else {
        initBulkDelete();
    }
    
    function initBulkDelete() {
        const checkAll = document.getElementById('checkAll');
        const deleteBtn = document.getElementById('deleteSelectedBtn');
        const selectedCount = document.getElementById('selectedCount');
        const bulkDeleteForm = document.getElementById('bulkDeleteForm');
        const bulkActionsBar = document.getElementById('bulkActionsBar');
        
        if (!checkAll) {
            console.error('checkAll element not found');
            return;
        }

        // Check all functionality
        checkAll.addEventListener('change', function() {
            const newsCheckboxes = document.querySelectorAll('.news-checkbox');
            newsCheckboxes.forEach(function(checkbox) {
                checkbox.checked = checkAll.checked;
            });
            updateDeleteButton();
        });

        // Delegate event for individual checkboxes
        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('news-checkbox')) {
                updateDeleteButton();
                
                // Update check all state
                const newsCheckboxes = document.querySelectorAll('.news-checkbox');
                const checkedCheckboxes = document.querySelectorAll('.news-checkbox:checked');
                checkAll.checked = newsCheckboxes.length === checkedCheckboxes.length && newsCheckboxes.length > 0;
                checkAll.indeterminate = checkedCheckboxes.length > 0 && checkedCheckboxes.length < newsCheckboxes.length;
            }
        });

        // Update delete button visibility and count
        function updateDeleteButton() {
            const checkedCount = document.querySelectorAll('.news-checkbox:checked').length;
            
            if (selectedCount) {
                selectedCount.textContent = checkedCount;
            }
            
            if (bulkActionsBar) {
                bulkActionsBar.style.display = checkedCount > 0 ? 'block' : 'none';
            }
        }

        // Bulk delete confirmation
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const checkedCount = document.querySelectorAll('.news-checkbox:checked').length;
                
                if (checkedCount === 0) {
                    alert('Pilih minimal 1 berita untuk dihapus');
                    return;
                }
                
                if (confirm('Yakin ingin menghapus ' + checkedCount + ' berita yang dipilih?')) {
                    if (bulkDeleteForm) {
                        bulkDeleteForm.submit();
                    }
                }
            });
        }

        // Initialize
        updateDeleteButton();
    }
})();
</script>
@endsection
