@extends('admin.layout')

@section('title','Pengumuman')
@section('page-title', 'Manajemen Pengumuman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pengumuman</li>
@endsection

@section('content')

@if(setting('announcement_section_enabled', '1') == '0')
<div class="alert alert-warning alert-dismissible fade show">
    <i class="fas fa-eye-slash me-2"></i>
    <strong>Perhatian!</strong> Section "Pengumuman" saat ini <strong>TIDAK DITAMPILKAN</strong> di website. 
    Aktifkan di pengaturan di bawah untuk menampilkannya.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@else
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-eye me-2"></i>
    <strong>Aktif!</strong> Section "Pengumuman" saat ini <strong>DITAMPILKAN</strong> di website.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Section Settings -->
<div class="content-card mb-3">
    <div class="content-card-header">
        <h5><i class="fas fa-cog me-2"></i>Pengaturan Section Pengumuman</h5>
        <small class="text-muted">Atur visibilitas section di halaman utama</small>
    </div>
    
    <form action="{{ route('admin.announcements.update-settings') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" 
                           type="checkbox" 
                           role="switch" 
                           id="announcement_section_enabled" 
                           name="announcement_section_enabled"
                           {{ setting('announcement_section_enabled', '1') == '1' ? 'checked' : '' }}
                           style="width: 3rem; height: 1.5rem;">
                    <label class="form-check-label fw-bold ms-2" for="announcement_section_enabled">
                        <i class="fas fa-toggle-on text-success me-1"></i>
                        Tampilkan Section "Pengumuman" di Website
                    </label>
                </div>
                <small class="text-muted ms-5 ps-2">
                    <i class="fas fa-info-circle me-1"></i>
                    Matikan untuk menyembunyikan section ini dari halaman utama
                </small>
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
        <h5><i class="fas fa-bullhorn me-2"></i>Daftar Pengumuman</h5>
        <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Buat Pengumuman Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th width="80">Penting</th>
                    <th width="80">Status</th>
                    <th width="60">Order</th>
                    <th width="150" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($announcements as $announcement)
                <tr>
                    <td>
                        <strong>{{ Str::limit($announcement->title, 50) }}</strong>
                        <br><small class="text-muted">{{ Str::limit(strip_tags($announcement->content), 80) }}</small>
                    </td>
                    <td>
                        @if($announcement->category)
                            <span class="badge bg-info">{{ $announcement->category }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $announcement->published_date->format('d M Y') }}</td>
                    <td>
                        @if($announcement->is_important)
                            <span class="badge bg-danger">Ya</span>
                        @else
                            <span class="badge bg-secondary">Tidak</span>
                        @endif
                    </td>
                    <td>
                        @if($announcement->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>{{ $announcement->order }}</td>
                    <td class="text-end">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-bullhorn fa-3x mb-3 d-block"></i>
                        Belum ada pengumuman
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end">
        {{ $announcements->links() }}
    </div>
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
</style>
@endpush
@endsection
