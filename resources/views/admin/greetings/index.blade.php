@extends('admin.layout')

@section('title', 'Kelola Sambutan')
@section('page-title', 'Manajemen Sambutan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Sambutan</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Kelola Sambutan</h1>
        <a href="{{ route('admin.greetings.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Sambutan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($greetings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Nama Section</th>
                                <th>Judul</th>
                                <th>Nama Orang</th>
                                <th>Jabatan</th>
                                <th style="width: 80px;">Urutan</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($greetings as $greeting)
                            <tr>
                                <td>{{ $loop->iteration + ($greetings->currentPage() - 1) * $greetings->perPage() }}</td>
                                <td><strong>{{ $greeting->section_name }}</strong></td>
                                <td>{{ Str::limit($greeting->title, 50) }}</td>
                                <td>{{ $greeting->person_name ?? '-' }}</td>
                                <td>{{ $greeting->person_title ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $greeting->order }}</span>
                                </td>
                                <td>
                                    @if($greeting->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.greetings.edit', $greeting) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.greetings.destroy', $greeting) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus sambutan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $greetings->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada sambutan.</p>
                    <a href="{{ route('admin.greetings.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Sambutan Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
