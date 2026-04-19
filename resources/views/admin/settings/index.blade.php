@extends('admin.layout')

@section('title','Setting Web')
@section('page-title', 'Setting Web')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Settings</li>
@endsection

@section('content')
<div class="content-card">
    <div class="content-card-header">
        <h5><i class="fas fa-cog me-2"></i>Pengaturan Website</h5>
        <small class="text-muted">Kelola konfigurasi website termasuk social media (Facebook, Instagram, Twitter, Threads, YouTube, TikTok, LinkedIn, WhatsApp)</small>
    </div>

    @php
        $grouped = $settings->groupBy('group');
    @endphp

    @foreach($grouped as $group => $items)
        @if(in_array($group, ['advantages', 'why_choose_us', 'testimonials', 'partners']))
            @continue
        @endif
        <div class="mb-4">
            <h6 class="text-uppercase text-primary mb-3" style="font-size: 0.85rem; letter-spacing: 1px;">
                <i class="fas fa-folder-open me-2"></i>{{ ucfirst($group) }}
            </h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="200">Setting</th>
                            <th>Value</th>
                            <th width="100" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $s)
                        @php
                            $labels = [
                                'why_choose_us_title' => 'Judul Section "Why Choose Us"',
                                'why_choose_us_description' => 'Deskripsi Section "Why Choose Us"',
                                'yayasan_nama' => 'Nama Yayasan',
                                'yayasan_akta_notaris' => 'Tanggal Akta Notaris',
                                'yayasan_no_reg_ham' => 'No. Registrasi KumHAM'
                            ];
                            $displayName = $labels[$s->key] ?? str_replace('_', ' ', ucfirst($s->key));
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $displayName }}</strong>
                                <br><small class="text-muted">{{ $s->key }}</small>
                            </td>
                            <td>
                                <code class="text-muted">{{ Str::limit($s->value, 80) }}</code>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.settings.edit',$s->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>

<div class="content-card mt-3">
    <h6><i class="fas fa-info-circle me-2"></i>Informasi</h6>
    <ul class="mb-0">
        <li><strong>Social Media:</strong> Icon akan otomatis muncul di topbar & footer jika URL sudah diisi (termasuk <strong>Threads</strong>)</li>
        <li><strong>WhatsApp:</strong> Gunakan format nomor dengan kode negara (contoh: 628123456789)</li>
        <li><strong>Advantages:</strong> Untuk edit section keunggulan, buka menu <a href="{{ route('admin.advantages.index') }}" class="fw-bold">Keunggulan Kami</a></li>
        <li><strong>Why Choose Us:</strong> Untuk edit section mengapa memilih kami, buka menu <a href="{{ route('admin.why-choose-us.index') }}" class="fw-bold">Why Choose Us</a></li>
        <li>Settings ini akan otomatis muncul di seluruh halaman website</li>
        <li>Perubahan langsung aktif tanpa perlu cache clear</li>
    </ul>
</div>
@endsection
