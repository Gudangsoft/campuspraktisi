@extends('admin.layout')

@section('title', 'Download Center')
@section('page-title', 'Download Center')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Download Center</li>
@endsection

@section('content')
<div class="content-card">
    <div class="content-card-header d-flex justify-content-between align-items-center">
        <div>
            <h5><i class="fas fa-download me-2"></i>Daftar File Download</h5>
            <small class="text-muted">Kelola file yang dapat diunduh pengunjung</small>
        </div>
        <a href="{{ route('admin.downloads.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah File
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th width="50">#</th>
                    <th>File</th>
                    <th width="150">Kategori</th>
                    <th width="100">Ukuran</th>
                    <th width="100" class="text-center">Download</th>
                    <th width="80" class="text-center">Status</th>
                    <th width="150" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($downloads as $download)
                <tr>
                    <td>{{ $loop->iteration + ($downloads->currentPage() - 1) * $downloads->perPage() }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($download->source_type === 'gdrive')
                                <i class="fab fa-google-drive fa-2x me-3 text-success"></i>
                            @else
                                <i class="fas {{ $download->file_icon }} fa-2x me-3"></i>
                            @endif
                            <div>
                                <strong>{{ $download->title }}</strong>
                                <br><small class="text-muted">{{ Str::limit($download->description, 60) }}</small>
                                <br>
                                @if($download->source_type === 'gdrive')
                                    <small class="badge bg-success"><i class="fab fa-google-drive"></i> Google Drive</small>
                                @else
                                    <small class="badge bg-secondary">{{ strtoupper($download->file_type) }}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-info">{{ ucfirst($download->category) }}</span></td>
                    <td>
                        @if($download->source_type === 'gdrive')
                            <small class="text-muted">-</small>
                        @else
                            {{ $download->file_size_formatted }}
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success">{{ number_format($download->downloads_count) }}x</span>
                    </td>
                    <td class="text-center">
                        @if($download->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($download->source_type === 'gdrive')
                            <a href="{{ $download->gdrive_url }}" 
                               class="btn btn-sm btn-info" target="_blank" title="Buka Google Drive">
                                <i class="fab fa-google-drive"></i>
                            </a>
                        @else
                            <a href="{{ asset('storage/' . $download->file_path) }}" 
                               class="btn btn-sm btn-info" target="_blank" title="Preview">
                                <i class="fas fa-eye"></i>
                            </a>
                        @endif
                        <a href="{{ route('admin.downloads.edit', $download) }}" 
                           class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.downloads.destroy', $download) }}" 
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus file ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada file. <a href="{{ route('admin.downloads.create') }}">Tambah file pertama</a></p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($downloads->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $downloads->links() }}
        </div>
    @endif
</div>

<div class="content-card mt-3">
    <h6><i class="fas fa-info-circle me-2"></i>Informasi</h6>
    <ul class="mb-0">
        <li>Maksimal ukuran file: <strong>10 MB</strong></li>
        <li>Format file yang didukung: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR, JPG, PNG</li>
        <li>File akan tersimpan di folder <code>storage/app/public/downloads</code></li>
        <li>Jumlah download otomatis terupdate setiap file diunduh</li>
    </ul>
</div>
@endsection
