@extends('admin.layout')

@section('title','Pages')
@section('page-title', 'Page Management')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pages</li>
@endsection

@section('content')
<div class="content-card">
    <div class="content-card-header">
        <h5><i class="fas fa-file-alt me-2"></i>Daftar Halaman</h5>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Halaman
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Template</th>
                    <th width="80">Order</th>
                    <th width="80">Status</th>
                    <th width="150" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($pages as $index => $page)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $page->title }}</strong>
                        @if($page->excerpt)
                            <br><small class="text-muted">{{ Str::limit($page->excerpt, 50) }}</small>
                        @endif
                    </td>
                    <td><code class="text-muted">{{ $page->slug }}</code></td>
                    <td><span class="badge bg-info">{{ ucfirst($page->template) }}</span></td>
                    <td><span class="badge bg-secondary">{{ $page->order }}</span></td>
                    <td>
                        @if($page->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('page.show', $page->slug) }}" class="btn btn-sm btn-outline-info" target="_blank" title="View Page">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.pages.destroy', $page->id) }}" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <p>Belum ada halaman. <a href="{{ route('admin.pages.create') }}">Tambah halaman pertama</a></p>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
