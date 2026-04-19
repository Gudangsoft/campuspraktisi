@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Jajaran Pimpinan</h1>
        <a href="{{ route('admin.pimpinan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Pimpinan
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold text-primary">Daftar Pimpinan & Yayasan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="50">Order</th>
                            <th width="80">Foto</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Kategori</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pimpinan as $item)
                        <tr>
                            <td class="text-center">{{ $item->order }}</td>
                            <td class="text-center">
                                @if($item->foto)
                                    <img src="{{ asset('storage/'.$item->foto) }}" alt="{{ $item->nama }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded-circle">
                                @else
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 50px; height: 50px;">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jabatan }}</td>
                            <td>
                                <span class="badge bg-{{ $item->kategori == 'pimpinan' ? 'primary' : 'info' }}">
                                    {{ ucfirst($item->kategori) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.pimpinan.edit', $item->id) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.pimpinan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data pimpinan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
