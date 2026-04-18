@extends('admin.layout')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Kalender Akademik</h1>
        <a href="{{ route('admin.academic-calendar.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Event
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.academic-calendar.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tahun Akademik</label>
                    <select name="academic_year" class="form-select">
                        <option value="">Semua Tahun</option>
                        @foreach($academicYears as $year)
                            <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Semester</label>
                    <select name="semester" class="form-select">
                        <option value="">Semua</option>
                        <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kategori</label>
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        <option value="academic" {{ request('category') == 'academic' ? 'selected' : '' }}>Akademik</option>
                        <option value="exam" {{ request('category') == 'exam' ? 'selected' : '' }}>Ujian</option>
                        <option value="holiday" {{ request('category') == 'holiday' ? 'selected' : '' }}>Libur</option>
                        <option value="registration" {{ request('category') == 'registration' ? 'selected' : '' }}>Pendaftaran</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                        <option value="current" {{ request('status') == 'current' ? 'selected' : '' }}>Sedang Berjalan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Events List -->
    <div class="card">
        <div class="card-body">
            @if($events->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="sortable-table">
                        <thead>
                            <tr>
                                <th style="width: 30px;"><i class="fas fa-grip-vertical text-muted"></i></th>
                                <th style="width: 50px;">Warna</th>
                                <th>Event</th>
                                <th>Tahun/Semester</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th style="width: 80px;">Status</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr data-id="{{ $event->id }}">
                                    <td class="handle" style="cursor: move;">
                                        <i class="fas fa-grip-vertical text-muted"></i>
                                    </td>
                                    <td>
                                        <div style="width: 30px; height: 30px; background-color: {{ $event->color }}; border-radius: 4px;"></div>
                                    </td>
                                    <td>
                                        <strong>{{ $event->title }}</strong>
                                        @if($event->description)
                                            <br><small class="text-muted">{{ Str::limit($event->description, 60) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $event->academic_year }}</span>
                                        <span class="badge bg-secondary">{{ $event->semester }}</span>
                                    </td>
                                    <td>
                                        <small>
                                            <i class="far fa-calendar me-1"></i>
                                            {{ $event->start_date->format('d M Y') }}
                                            @if($event->end_date)
                                                - {{ $event->end_date->format('d M Y') }}
                                                <br><span class="text-muted">({{ $event->getDurationDays() }} hari)</span>
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $event->getCategoryBadgeClass() }}">
                                            <i class="fas {{ $event->getCategoryIcon() }} me-1"></i>
                                            {{ ucfirst($event->category) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($event->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Non-aktif</span>
                                        @endif
                                        <br>
                                        @if($event->isOngoing())
                                            <small class="text-success">Berlangsung</small>
                                        @elseif($event->isUpcoming())
                                            <small class="text-info">Mendatang</small>
                                        @else
                                            <small class="text-muted">Lewat</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.academic-calendar.edit', $event) }}" 
                                               class="btn btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.academic-calendar.destroy', $event) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Yakin ingin menghapus event ini?')"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Hapus">
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
                    {{ $events->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-xmark fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada event kalender akademik</p>
                    <a href="{{ route('admin.academic-calendar.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Event
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.querySelector('#sortable-table tbody');
    if (tbody) {
        new Sortable(tbody, {
            handle: '.handle',
            animation: 150,
            onEnd: function(evt) {
                const orders = {};
                document.querySelectorAll('#sortable-table tbody tr').forEach((row, index) => {
                    orders[row.dataset.id] = index;
                });

                fetch('{{ route("admin.academic-calendar.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ orders: orders })
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          console.log('Order updated');
                      }
                  });
            }
        });
    }
});
</script>
@endpush
@endsection
