@extends('frontend.layout')

@section('title', 'Download Center')

@section('content')
<!-- Header -->
<section class="py-5" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="text-white mb-3">
                    <i class="fas fa-download me-3"></i>Download Center
                </h1>
                <p class="text-white-50 lead mb-0">
                    Unduh dokumen, formulir, panduan, dan berbagai file penting lainnya
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="bg-white bg-opacity-10 rounded p-3">
                    <h4 class="text-white mb-0">{{ $downloads->total() }}</h4>
                    <small class="text-white-50">File Tersedia</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search & Filter -->
<section class="py-4 bg-light border-bottom">
    <div class="container">
        <form action="{{ route('downloads.index') }}" method="GET">
            <div class="row g-3 align-items-center">
                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Cari file..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-lg-4">
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        <option value="formulir" {{ request('category') == 'formulir' ? 'selected' : '' }}>
                            Formulir ({{ $categoryCounts['formulir'] ?? 0 }})
                        </option>
                        <option value="panduan" {{ request('category') == 'panduan' ? 'selected' : '' }}>
                            Panduan ({{ $categoryCounts['panduan'] ?? 0 }})
                        </option>
                        <option value="brosur" {{ request('category') == 'brosur' ? 'selected' : '' }}>
                            Brosur ({{ $categoryCounts['brosur'] ?? 0 }})
                        </option>
                        <option value="peraturan" {{ request('category') == 'peraturan' ? 'selected' : '' }}>
                            Peraturan ({{ $categoryCounts['peraturan'] ?? 0 }})
                        </option>
                        <option value="kurikulum" {{ request('category') == 'kurikulum' ? 'selected' : '' }}>
                            Kurikulum ({{ $categoryCounts['kurikulum'] ?? 0 }})
                        </option>
                        <option value="kalender" {{ request('category') == 'kalender' ? 'selected' : '' }}>
                            Kalender Akademik ({{ $categoryCounts['kalender'] ?? 0 }})
                        </option>
                        <option value="umum" {{ request('category') == 'umum' ? 'selected' : '' }}>
                            Umum ({{ $categoryCounts['umum'] ?? 0 }})
                        </option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Downloads List -->
<section class="py-5">
    <div class="container">
        @if($downloads->count() > 0)
            <div class="row g-4">
                @foreach($downloads as $download)
                <div class="col-lg-6">
                    <div class="card h-100 shadow-sm border-0 hover-lift">
                        <div class="card-body">
                            <div class="d-flex">
                                <!-- File Icon -->
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 60px; background-color: rgba(var(--bs-primary-rgb), 0.1);">
                                        @if($download->source_type === 'gdrive')
                                            <i class="fab fa-google-drive fa-2x text-success"></i>
                                        @else
                                            <i class="fas {{ $download->file_icon }} fa-2x"></i>
                                        @endif
                                    </div>
                                </div>

                                <!-- File Info -->
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-2">{{ $download->title }}</h5>
                                    
                                    <div class="mb-2">
                                        <span class="badge bg-primary">
                                            <i class="fas fa-tag me-1"></i>{{ ucfirst($download->category) }}
                                        </span>
                                        @if($download->source_type === 'gdrive')
                                            <span class="badge bg-success">
                                                <i class="fab fa-google-drive me-1"></i>Google Drive
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-file me-1"></i>{{ strtoupper($download->file_type) }}
                                            </span>
                                            <span class="badge bg-info">
                                                <i class="fas fa-hdd me-1"></i>{{ $download->file_size_formatted }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($download->description)
                                    <p class="text-muted small mb-3">{{ Str::limit($download->description, 120) }}</p>
                                    @endif

                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-download me-1"></i>
                                            {{ number_format($download->downloads_count) }} unduhan
                                        </small>
                                        
                                        <div>
                                            @if($download->source_type === 'gdrive')
                                                <a href="{{ route('downloads.download', $download) }}" 
                                                   class="btn btn-sm btn-success" target="_blank">
                                                    <i class="fab fa-google-drive me-1"></i> Buka Google Drive
                                                </a>
                                            @else
                                                <a href="{{ asset('storage/' . $download->file_path) }}" 
                                                   class="btn btn-sm btn-outline-primary me-2" target="_blank">
                                                    <i class="fas fa-eye"></i> Preview
                                                </a>
                                                <a href="{{ route('downloads.download', $download) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-download me-1"></i> Unduh
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-5">
                {{ $downloads->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Tidak ada file ditemukan</h4>
                <p class="text-muted">Coba ubah kata kunci pencarian atau filter kategori</p>
            </div>
        @endif
    </div>
</section>

<style>
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.card-title {
    color: var(--primary-color);
}
</style>
@endsection
