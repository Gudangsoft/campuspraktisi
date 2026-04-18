@extends('admin.layout')

@section('title', 'Edit Slider')

@section('content')
<div class="mb-4">
    <h1 class="h3 mb-0">Edit Slider</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                       id="title" name="title" value="{{ old('title', $slider->title) }}">
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3">{{ old('description', $slider->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                @if($slider->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" 
                         class="img-thumbnail" style="max-height: 200px;">
                    <div class="form-text">Current image</div>
                </div>
                @endif
                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                       id="image" name="image" accept="image/*">
                <small class="text-muted">Leave empty to keep current image. Max: 5MB. Recommended: 1920x800px</small>
                @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="button_text" class="form-label">Button Text</label>
                    <input type="text" class="form-control @error('button_text') is-invalid @enderror" 
                           id="button_text" name="button_text" value="{{ old('button_text', $slider->button_text) }}" 
                           placeholder="e.g., Learn More">
                    @error('button_text')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="button_url" class="form-label">Button URL</label>
                    <input type="text" class="form-control @error('button_url') is-invalid @enderror" 
                           id="button_url" name="button_url" value="{{ old('button_url', $slider->button_url) }}" 
                           placeholder="/about">
                    @error('button_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="order" class="form-label">Order</label>
                    <input type="number" class="form-control @error('order') is-invalid @enderror" 
                           id="order" name="order" value="{{ old('order', $slider->order) }}">
                    <small class="text-muted">Display order (lower numbers appear first)</small>
                    @error('order')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="is_active" 
                               name="is_active" value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Slider
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
