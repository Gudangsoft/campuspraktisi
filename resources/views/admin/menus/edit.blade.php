@extends('admin.layout')

@section('title','Edit Menu')
@section('page-title', 'Edit Menu')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.menus.index') }}">Menus</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="content-card">
            <div class="content-card-header">
                <h5><i class="fas fa-edit me-2"></i>Edit Menu: {{ $menu->title }}</h5>
            </div>

            <form method="POST" action="{{ route('admin.menus.update', $menu->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" required value="{{ old('title',$menu->title) }}" placeholder="Masukkan judul menu">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">URL</label>
                <input type="text" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url',$menu->url) }}" placeholder="contoh: /tentang-kami">
                <small class="text-muted">Kosongkan jika menu ini parent/tidak memiliki link</small>
                @error('url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Menu Group <span class="text-danger">*</span></label>
                <select name="menu_group" class="form-select @error('menu_group') is-invalid @enderror" required>
                    <option value="topbar" {{ old('menu_group', $menu->menu_group) == 'topbar' ? 'selected' : '' }}>Top Bar (Staf, Mahasiswa, Alumni, dll)</option>
                    <option value="main" {{ old('menu_group', $menu->menu_group) == 'main' ? 'selected' : '' }}>Main Navigation (Tentang, Penerimaan, Pendidikan, dll)</option>
                </select>
                <small class="text-muted">Pilih lokasi menu di website</small>
                @error('menu_group')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Parent Menu</label>
                    <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                        <option value="">- Root Menu (Tanpa Parent) -</option>
                        @php
                            function renderMenuOptionsEdit($menus, $currentMenuId, $level = 0, $selected = null) {
                                foreach($menus as $menu) {
                                    // Skip current menu and its children to prevent circular reference
                                    if($menu->id == $currentMenuId) continue;
                                    
                                    $indent = str_repeat('— ', $level);
                                    $isSelected = old('parent_id', $selected) == $menu->id ? 'selected' : '';
                                    echo '<option value="'.$menu->id.'" '.$isSelected.'>'.$indent.$menu->title.'</option>';
                                    
                                    // Render children recursively
                                    if($menu->allChildren && $menu->allChildren->count() > 0) {
                                        renderMenuOptionsEdit($menu->allChildren, $currentMenuId, $level + 1, $selected);
                                    }
                                }
                            }
                            renderMenuOptionsEdit($parents, $menu->id, 0, $menu->parent_id);
                        @endphp
                    </select>
                    <small class="text-muted">Pilih parent untuk membuat sub-menu</small>
                    @error('parent_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Order (Urutan)</label>
                    <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $menu->order) }}" min="0">
                    <small class="text-muted">Semakin kecil, semakin awal tampil</small>
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Target Link</label>
                <select name="target" class="form-select @error('target') is-invalid @enderror">
                    <option value="_self" {{ old('target', $menu->target) == '_self' ? 'selected' : '' }}>Same Window (_self)</option>
                    <option value="_blank" {{ old('target', $menu->target) == '_blank' ? 'selected' : '' }}>New Window (_blank)</option>
                </select>
                @error('target')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $menu->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">
                    <strong>Active</strong> <small class="text-muted">- Menu akan tampil di website</small>
                </label>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update Menu
                </button>
                <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
            </div>

            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="content-card">
            <h6 class="mb-3"><i class="fas fa-info-circle me-2"></i>Struktur Menu</h6>
            <p class="small mb-2"><strong>Top Bar:</strong></p>
            <ul class="small">
                <li>Staf</li>
                <li>Mahasiswa</li>
                <li>Alumni</li>
                <li>Mitra</li>
                <li>Pengunjung</li>
                <li>Pers</li>
                <li>My Campus</li>
                <li>Admission</li>
            </ul>
            <p class="small mb-2 mt-3"><strong>Main Navigation:</strong></p>
            <ul class="small">
                <li>Tentang</li>
                <li>Penerimaan</li>
                <li>Pendidikan</li>
                <li>Penelitian</li>
                <li>Pengabdian</li>
                <li>Penghargaan</li>
                <li>Multikampus</li>
            </ul>
        </div>
    </div>
</div>
@endsection
