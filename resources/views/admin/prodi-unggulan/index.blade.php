@extends('admin.layout')

@section('title','Program Studi Unggulan')
@section('page-title', 'Manajemen Program Studi Unggulan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Prodi Unggulan</li>
@endsection

@section('content')

<div class="content-card">
    <div class="content-card-header">
        <h5><i class="fas fa-graduation-cap me-2"></i>Daftar Program Studi Unggulan</h5>
        <a href="{{ route('admin.prodi-unggulan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Prodi
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
                    <th width="60">Gambar</th>
                    <th>Nama Prodi</th>
                    <th>Deskripsi</th>
                    <th>Link Tautan</th>
                    <th width="150" class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($prodis as $prodi)
                <tr>
                    <td>
                        @if($prodi->gambar)
                            <img src="{{ asset('storage/'.$prodi->gambar) }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-graduation-cap text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $prodi->nama }}</strong>
                    </td>
                    <td>{{ Str::limit($prodi->deskripsi, 60) ?: '-' }}</td>
                    <td>
                        @if($prodi->link)
                            <a href="{{ $prodi->link }}" target="_blank" class="text-primary"><i class="fas fa-external-link-alt"></i> Link</a>
                        @else
                        -
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.prodi-unggulan.edit', $prodi->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.prodi-unggulan.destroy', $prodi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus prodi unggulan ini?');">
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
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="fas fa-graduation-cap fa-3x mb-3 d-block"></i>
                        Belum ada program studi unggulan
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $prodis->links() }}
    </div>
</div>
@endsection
