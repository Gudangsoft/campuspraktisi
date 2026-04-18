@extends('admin.layout')

@section('title','Agenda')
@section('page-title', 'Manajemen Agenda')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Agenda</li>
@endsection

@section('content')

@if(setting('agenda_section_enabled', '1') == '0')
<div class="alert alert-warning alert-dismissible fade show">
    <i class="fas fa-eye-slash me-2"></i>
    <strong>Perhatian!</strong> Section "Agenda" saat ini <strong>TIDAK DITAMPILKAN</strong> di website. 
    Aktifkan di pengaturan di bawah untuk menampilkannya.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@else
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-eye me-2"></i>
    <strong>Aktif!</strong> Section "Agenda" saat ini <strong>DITAMPILKAN</strong> di website.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Section Settings -->
<div class="content-card mb-3">
    <div class="content-card-header">
        <h5><i class="fas fa-cog me-2"></i>Pengaturan Section Agenda</h5>
        <small class="text-muted">Atur visibilitas section di halaman utama</small>
    </div>
    
    <form action="{{ route('admin.agendas.update-settings') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" 
                           type="checkbox" 
                           role="switch" 
                           id="agenda_section_enabled" 
                           name="agenda_section_enabled"
                           {{ setting('agenda_section_enabled', '1') == '1' ? 'checked' : '' }}
                           style="width: 3rem; height: 1.5rem;">
                    <label class="form-check-label fw-bold ms-2" for="agenda_section_enabled">
                        <i class="fas fa-toggle-on text-success me-1"></i>
                        Tampilkan Section "Agenda" di Website
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
        <h5><i class="fas fa-calendar-alt me-2"></i>Daftar Agenda</h5>
        <a href="{{ route('admin.agendas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Buat Agenda Baru
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
                    <th width="60">Image</th>
                    <th>Judul</th>
                    <th>Lokasi</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th width="80">Status</th>
                    <th width="60">Order</th>
                    <th width="150" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($agendas as $agenda)
                <tr>
                    <td>
                        @if($agenda->image)
                            <img src="{{ asset('storage/'.$agenda->image) }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-calendar text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ Str::limit($agenda->title, 50) }}</strong>
                        @if($agenda->description)
                            <br><small class="text-muted">{{ Str::limit($agenda->description, 60) }}</small>
                        @endif
                    </td>
                    <td>{{ $agenda->location ?? '-' }}</td>
                    <td>{{ $agenda->event_date->format('d M Y') }}</td>
                    <td>
                        @if($agenda->start_time)
                            {{ date('H:i', strtotime($agenda->start_time)) }}
                            @if($agenda->end_time)
                                - {{ date('H:i', strtotime($agenda->end_time)) }}
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($agenda->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>{{ $agenda->order }}</td>
                    <td class="text-end">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.agendas.edit', $agenda->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.agendas.destroy', $agenda->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus agenda ini?');">
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
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="fas fa-calendar-times fa-3x mb-3 d-block"></i>
                        Belum ada agenda
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end">
        {{ $agendas->links() }}
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
