@extends('admin.layout')

@section('title','Edit Setting')
@section('page-title', 'Edit Setting')

@section('styles')
@if($setting->type == 'editor')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Settings</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="content-card">
            <div class="content-card-header">
                <h5><i class="fas fa-edit me-2"></i>Edit: {{ $setting->key }}</h5>
            </div>

            <form method="POST" action="{{ route('admin.settings.update', $setting->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Key</label>
                <input type="text" class="form-control" value="{{ $setting->key }}" disabled>
                <small class="text-muted">System key, tidak dapat diubah</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Group</label>
                <input type="text" class="form-control" value="{{ ucfirst($setting->group) }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Type</label>
                <input type="text" class="form-control" value="{{ ucfirst($setting->type) }}" disabled>
            </div>

            <div class="mb-4">
                <label class="form-label">Value</label>
                
                @if($setting->type == 'image')
                    @if($setting->value)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$setting->value) }}" 
                                 class="img-thumbnail" 
                                 style="max-width: 200px; max-height: 200px;" 
                                 alt="Current {{ $setting->key }}">
                            <p class="mt-2 mb-0"><small class="text-muted">Current image</small></p>
                        </div>
                    @endif
                    <input type="file" name="value" class="form-control @error('value') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Upload {{ str_replace('_', ' ', $setting->key) }}. Max 2MB. Format: JPG, PNG, GIF</small>
                    @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                @elseif($setting->type == 'textarea')
                    <textarea name="value" class="form-control @error('value') is-invalid @enderror" rows="5">{{ old('value',$setting->value) }}</textarea>
                    @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                @elseif($setting->type == 'editor')
                    <textarea name="value" id="summernote" class="form-control">{{ old('value', $setting->value) }}</textarea>
                    <small class="text-muted">Gunakan editor untuk format teks yang lebih kaya</small>
                    @error('value')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                @elseif($setting->key == 'whatsapp_float_enabled')
                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               role="switch" 
                               name="value" 
                               id="whatsapp_float_enabled"
                               value="1"
                               {{ old('value', $setting->value) == '1' ? 'checked' : '' }}
                               style="width: 3rem; height: 1.5rem;">
                        <label class="form-check-label fw-bold ms-2" for="whatsapp_float_enabled">
                            <i class="fab fa-whatsapp text-success me-1"></i>
                            Tampilkan Tombol WhatsApp Floating
                        </label>
                    </div>
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-info-circle me-1"></i>
                        Tombol hijau melayang di pojok kanan bawah website untuk chat langsung via WhatsApp
                    </small>
                @elseif($setting->key == 'whatsapp_number')
                    <div class="input-group">
                        <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                        <input type="text" 
                               name="value" 
                               class="form-control @error('value') is-invalid @enderror" 
                               value="{{ old('value', $setting->value) }}"
                               placeholder="628123456789"
                               pattern="[0-9]+"
                               maxlength="15">
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Format: Kode negara + nomor (contoh: <strong>628123456789</strong>). Tanpa spasi, tanda +, atau tanda hubung.
                    </small>
                    @error('value')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                @elseif(in_array($setting->key, ['facebook_url', 'twitter_url', 'instagram_url', 'threads_url', 'youtube_url', 'linkedin_url', 'tiktok_url']))
                    @php
                        $socialIcons = [
                            'facebook_url' => 'fab fa-facebook-f',
                            'twitter_url' => 'fab fa-twitter',
                            'instagram_url' => 'fab fa-instagram',
                            'threads_url' => 'fab fa-threads',
                            'youtube_url' => 'fab fa-youtube',
                            'linkedin_url' => 'fab fa-linkedin-in',
                            'tiktok_url' => 'fab fa-tiktok',
                        ];
                    @endphp
                    <div class="input-group">
                        <span class="input-group-text"><i class="{{ $socialIcons[$setting->key] ?? 'fas fa-link' }}"></i></span>
                        <input type="url" 
                               name="value" 
                               class="form-control @error('value') is-invalid @enderror" 
                               value="{{ old('value', $setting->value) }}"
                               placeholder="https://...">
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        URL lengkap akun media sosial Anda (contoh: https://threads.net/@username)
                    </small>
                    @error('value')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                @elseif($setting->key == 'whatsapp_message')
                    <textarea name="value" class="form-control @error('value') is-invalid @enderror" rows="4">{{ old('value', $setting->value) }}</textarea>
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Pesan otomatis saat tombol WhatsApp diklik. Gunakan <strong>{site_name}</strong> untuk nama website.
                    </small>
                    @error('value')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                @else
                    <input type="text" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value',$setting->value) }}">
                    @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                @endif
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update Setting
                </button>
                <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
            </div>

            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="content-card">
            <h6 class="mb-3"><i class="fas fa-info-circle me-2"></i>Informasi</h6>
            @if($setting->type == 'image')
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Ukuran maksimal: 2MB</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Format: JPG, PNG, GIF</li>
                    @if(str_contains($setting->key, 'logo'))
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Rekomendasi: 200x50px (landscape)</li>
                    @endif
                    @if(str_contains($setting->key, 'favicon'))
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Rekomendasi: 32x32px atau 64x64px (square)</li>
                    @endif
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Gambar lama akan otomatis terhapus</li>
                </ul>
            @elseif($setting->key == 'google_maps_embed')
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Cara mendapatkan Google Maps Embed:</h6>
                    <ol class="mb-0">
                        <li>Buka <a href="https://www.google.com/maps" target="_blank">Google Maps</a></li>
                        <li>Cari lokasi kampus Anda</li>
                        <li>Klik tombol <strong>"Share"</strong> atau <strong>"Bagikan"</strong></li>
                        <li>Pilih tab <strong>"Embed a map"</strong> atau <strong>"Sematkan peta"</strong></li>
                        <li>Copy <strong>HTML code</strong> yang muncul</li>
                        <li><strong>Paste langsung kode iframe lengkap</strong>, atau</li>
                        <li>Copy hanya <strong>URL dari src="..."</strong></li>
                    </ol>
                    <p class="mt-2 mb-0"><small><strong>Contoh yang diterima:</strong><br>
                    1. <code>&lt;iframe src="https://www.google.com/maps/embed?pb=..."&gt;&lt;/iframe&gt;</code><br>
                    2. <code>https://www.google.com/maps/embed?pb=!1m18!1m12...</code></small></p>
                </div>
            @elseif($setting->key == 'whatsapp_float_enabled')
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Tentang Tombol WhatsApp Floating:</h6>
                    <ul class="mb-0">
                        <li><strong>Aktif:</strong> Tombol hijau bulat dengan logo WhatsApp akan muncul di pojok kanan bawah setiap halaman</li>
                        <li><strong>Fungsi:</strong> Pengunjung dapat langsung chat ke nomor WhatsApp yang sudah diatur</li>
                        <li><strong>Posisi:</strong> Floating (melayang) di kanan bawah, tidak mengganggu konten</li>
                        <li><strong>Responsive:</strong> Otomatis menyesuaikan ukuran di berbagai perangkat</li>
                    </ul>
                    <p class="mt-2 mb-0"><small><i class="fas fa-lightbulb me-1"></i><strong>Tips:</strong> Pastikan nomor WhatsApp sudah diisi dan aktif sebelum mengaktifkan tombol ini.</small></p>
                </div>
            @elseif($setting->key == 'whatsapp_number')
                <div class="alert alert-success">
                    <h6><i class="fab fa-whatsapp me-2"></i>Format Nomor WhatsApp:</h6>
                    <ul class="mb-2">
                        <li>Awali dengan kode negara (contoh: <strong>62</strong> untuk Indonesia)</li>
                        <li>Hilangkan angka <strong>0</strong> di depan nomor lokal</li>
                        <li>Hanya angka, tanpa spasi, tanda hubung, atau karakter lain</li>
                    </ul>
                    <p class="mb-2"><strong>Contoh Format yang Benar:</strong></p>
                    <ul class="mb-2">
                        <li><code>628123456789</code> ✓</li>
                        <li><code>6281234567890</code> ✓</li>
                    </ul>
                    <p class="mb-2"><strong>Format yang Salah:</strong></p>
                    <ul class="mb-0">
                        <li><code>08123456789</code> ✗ (tanpa kode negara)</li>
                        <li><code>+62 812 3456 789</code> ✗ (ada spasi)</li>
                        <li><code>62-812-3456-789</code> ✗ (ada tanda hubung)</li>
                    </ul>
                    <hr class="my-2">
                    <p class="mb-0"><small><i class="fas fa-info-circle me-1"></i><strong>Info:</strong> Nomor ini akan digunakan untuk tombol WhatsApp floating di website. Pengunjung bisa langsung chat WhatsApp dengan 1 klik.</small></p>
                </div>
            @elseif($setting->key == 'whatsapp_message')
                <div class="alert alert-info">
                    <h6><i class="fas fa-comment-dots me-2"></i>Pesan WhatsApp:</h6>
                    <p class="mb-2">Pesan ini akan otomatis muncul di kolom chat WhatsApp saat pengunjung mengklik tombol WhatsApp di website.</p>
                    
                    <p class="mb-2"><strong>Placeholder yang Bisa Digunakan:</strong></p>
                    <ul class="mb-3">
                        <li><code>{site_name}</code> - Akan diganti dengan nama website</li>
                    </ul>
                    
                    <p class="mb-2"><strong>Contoh Pesan:</strong></p>
                    <div class="bg-light p-2 rounded mb-2">
                        <code>Halo, saya ingin bertanya tentang {site_name}</code>
                    </div>
                    <div class="bg-light p-2 rounded mb-2">
                        <code>Hai Admin {site_name}, saya tertarik untuk mendaftar. Bisa info lebih lanjut?</code>
                    </div>
                    <div class="bg-light p-2 rounded mb-3">
                        <code>Assalamualaikum, saya ingin konsultasi tentang program di {site_name}</code>
                    </div>
                    
                    <p class="mb-0"><small><i class="fas fa-lightbulb me-1 text-warning"></i><strong>Tips:</strong> Buat pesan yang ramah dan jelas agar pengunjung merasa nyaman untuk bertanya.</small></p>
                </div>
            @else
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Perubahan langsung aktif di website</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Bisa dikosongkan jika tidak dibutuhkan</li>
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if($setting->type == 'editor')
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
$(document).ready(function() {
    $('#summernote').summernote({
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
});
</script>
@endif
@endsection
