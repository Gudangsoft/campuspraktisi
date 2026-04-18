@php
    $academicYears = \App\Models\AcademicCalendar::select('academic_year')
        ->distinct()
        ->orderBy('academic_year', 'desc')
        ->pluck('academic_year');
    
    $currentYear = request('year', $academicYears->first());
    $currentSemester = request('semester', '');
    $currentCategory = request('category', '');
    
    $query = \App\Models\AcademicCalendar::active()
        ->where('academic_year', $currentYear);
    
    if ($currentSemester) {
        $query->semester($currentSemester);
    }
    
    if ($currentCategory) {
        $query->category($currentCategory);
    }
    
    $events = $query->orderBy('start_date', 'asc')->get();
    
    $categories = [
        'academic' => ['name' => 'Akademik', 'icon' => 'fa-graduation-cap', 'color' => 'primary'],
        'exam' => ['name' => 'Ujian', 'icon' => 'fa-file-pen', 'color' => 'danger'],
        'holiday' => ['name' => 'Libur', 'icon' => 'fa-umbrella-beach', 'color' => 'success'],
        'registration' => ['name' => 'Pendaftaran', 'icon' => 'fa-clipboard-list', 'color' => 'warning']
    ];
@endphp

<section class="academic-calendar-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Kalender Akademik</h2>
            <p class="section-subtitle text-muted">Jadwal kegiatan akademik kampus</p>
        </div>

        <!-- Filter Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ request()->url() }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-calendar-alt me-2"></i>Tahun Akademik
                        </label>
                        <select name="year" class="form-select" onchange="this.form.submit()">
                            @foreach($academicYears as $year)
                                <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-book me-2"></i>Semester
                        </label>
                        <select name="semester" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Semester</option>
                            <option value="Ganjil" {{ $currentSemester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="Genap" {{ $currentSemester == 'Genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-filter me-2"></i>Kategori
                        </label>
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $key => $cat)
                                <option value="{{ $key }}" {{ $currentCategory == $key ? 'selected' : '' }}>
                                    {{ $cat['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1">
                        @if($currentSemester || $currentCategory)
                            <a href="{{ request()->url() }}?year={{ $currentYear }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if($events->count() > 0)
            <!-- Category Legend -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @foreach($categories as $key => $cat)
                            <div class="category-legend">
                                <span class="badge bg-{{ $cat['color'] }}">
                                    <i class="fas {{ $cat['icon'] }} me-1"></i>
                                    {{ $cat['name'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Timeline View -->
            <div class="calendar-timeline">
                @foreach($events as $event)
                    <div class="timeline-item {{ $event->isOngoing() ? 'ongoing' : '' }} {{ $event->isUpcoming() ? 'upcoming' : '' }}" 
                         data-category="{{ $event->category }}">
                        <div class="timeline-marker" style="background-color: {{ $event->color }}">
                            <i class="fas {{ $event->getCategoryIcon() }}"></i>
                        </div>
                        <div class="timeline-content card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="card-title mb-1">{{ $event->title }}</h5>
                                        <div class="badges mb-2">
                                            <span class="badge bg-info me-1">{{ $event->academic_year }}</span>
                                            <span class="badge bg-secondary me-1">{{ $event->semester }}</span>
                                            <span class="badge {{ $event->getCategoryBadgeClass() }}">
                                                {{ $categories[$event->category]['name'] ?? ucfirst($event->category) }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($event->isOngoing())
                                        <span class="badge bg-success">
                                            <i class="fas fa-circle-dot me-1"></i>Sedang Berlangsung
                                        </span>
                                    @elseif($event->isUpcoming())
                                        <span class="badge bg-info">
                                            <i class="fas fa-clock me-1"></i>Akan Datang
                                        </span>
                                    @endif
                                </div>

                                <div class="date-info mb-2">
                                    <i class="far fa-calendar text-primary me-2"></i>
                                    <strong>{{ $event->start_date->translatedFormat('d F Y') }}</strong>
                                    @if($event->end_date)
                                        <span class="mx-2">—</span>
                                        <strong>{{ $event->end_date->translatedFormat('d F Y') }}</strong>
                                        <span class="text-muted ms-2">({{ $event->getDurationDays() }} hari)</span>
                                    @endif
                                </div>

                                @if($event->description)
                                    <p class="card-text text-muted mb-0">{{ $event->description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-xmark fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Belum Ada Event</h4>
                <p class="text-muted">Tidak ada jadwal untuk filter yang dipilih</p>
            </div>
        @endif
    </div>
</section>

<style>
.academic-calendar-section {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.section-subtitle {
    font-size: 1.1rem;
}

.calendar-timeline {
    position: relative;
    padding-left: 50px;
}

.calendar-timeline::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #3498db, #2ecc71);
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
    opacity: 0.7;
    transition: all 0.3s ease;
}

.timeline-item.ongoing {
    opacity: 1;
    transform: scale(1.02);
}

.timeline-item.upcoming {
    opacity: 0.9;
}

.timeline-item:hover {
    opacity: 1;
    transform: translateX(5px);
}

.timeline-marker {
    position: absolute;
    left: -40px;
    top: 20px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.9);
    z-index: 1;
}

.timeline-content {
    border-left: 3px solid transparent;
    transition: all 0.3s ease;
}

.timeline-item[data-category="academic"] .timeline-content {
    border-left-color: #3498db;
}

.timeline-item[data-category="exam"] .timeline-content {
    border-left-color: #e74c3c;
}

.timeline-item[data-category="holiday"] .timeline-content {
    border-left-color: #2ecc71;
}

.timeline-item[data-category="registration"] .timeline-content {
    border-left-color: #f39c12;
}

.timeline-item.ongoing .timeline-content {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.category-legend .badge {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}

.date-info {
    font-size: 1rem;
}

@media (max-width: 768px) {
    .calendar-timeline {
        padding-left: 40px;
    }

    .calendar-timeline::before {
        left: 15px;
    }

    .timeline-marker {
        left: -33px;
        width: 35px;
        height: 35px;
        font-size: 16px;
    }

    .section-title {
        font-size: 2rem;
    }

    .timeline-item:hover {
        transform: none;
    }
}
</style>
