@extends('admin.layout')

@section('title', 'Backup Database')
@section('page-title', 'Backup Database')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Backup Database</li>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="content-card">
            <div class="content-card-header">
                <div>
                    <h5><i class="fas fa-database me-2"></i>Database Backup Manager</h5>
                    <small class="text-muted">Kelola backup database untuk keamanan data</small>
                </div>
                <form action="{{ route('admin.backup.create') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Buat backup database sekarang?')">
                        <i class="fas fa-plus-circle me-1"></i> Buat Backup Baru
                    </button>
                </form>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Informasi:</strong>
                <ul class="mb-0 mt-2">
                    <li>Backup akan disimpan dalam format <strong>.sql</strong></li>
                    <li>File backup disimpan di: <code>storage/app/backups/</code></li>
                    <li>Gunakan backup secara berkala untuk keamanan data</li>
                    <li>Download dan simpan backup di lokasi aman (eksternal)</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="content-card-header">
        <h5><i class="fas fa-history me-2"></i>Riwayat Backup</h5>
    </div>

    @if($backups->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Nama File</th>
                        <th width="150">Ukuran</th>
                        <th width="200">Tanggal</th>
                        <th width="200" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($backups as $index => $backup)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <i class="fas fa-file-archive text-primary me-2"></i>
                            <strong>{{ $backup['name'] }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $backup['size'] }}</span>
                        </td>
                        <td>
                            <i class="fas fa-clock text-muted me-1"></i>
                            {{ $backup['date'] }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.backup.download', $backup['name']) }}" 
                               class="btn btn-sm btn-success" title="Download">
                                <i class="fas fa-download"></i> Download
                            </a>
                            
                            <form action="{{ route('admin.backup.destroy', $backup['name']) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Hapus backup ini?')" title="Hapus">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-database fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada backup database</h5>
            <p class="text-muted">Klik tombol "Buat Backup Baru" untuk membuat backup pertama</p>
        </div>
    @endif
</div>

<div class="content-card mt-3">
    <div class="content-card-header">
        <h5><i class="fas fa-shield-alt me-2"></i>Tips Keamanan Backup</h5>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h6 class="text-primary"><i class="fas fa-check-circle me-2"></i>Yang Harus Dilakukan:</h6>
            <ul>
                <li>Buat backup secara rutin (harian/mingguan)</li>
                <li>Download dan simpan backup di lokasi terpisah</li>
                <li>Gunakan cloud storage untuk backup eksternal</li>
                <li>Test restore backup secara berkala</li>
                <li>Enkripsi file backup untuk keamanan ekstra</li>
            </ul>
        </div>
        <div class="col-md-6">
            <h6 class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Yang Harus Dihindari:</h6>
            <ul>
                <li>Jangan hanya menyimpan backup di server yang sama</li>
                <li>Jangan membagikan file backup ke sembarang orang</li>
                <li>Jangan gunakan nama file yang mudah ditebak</li>
                <li>Jangan menghapus semua backup sekaligus</li>
                <li>Jangan lupa password database saat restore</li>
            </ul>
        </div>
    </div>
</div>
@endsection
