@extends('admin.layout')

@section('title', 'Add Video')

@section('content')
<div class="mb-4">
    <h1 class="h3 mb-0">Add Video</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.gallery-videos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                       id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="youtube_url" class="form-label">YouTube URL <span class="text-danger">*</span></label>
                <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" 
                       id="youtube_url" name="youtube_url" value="{{ old('youtube_url') }}" 
                       placeholder="https://www.youtube.com/watch?v=VIDEO_ID" required>
                <small class="text-muted">Full YouTube video URL</small>
                @error('youtube_url')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                <!-- YouTube Preview -->
                <div id="youtube-preview" class="mt-3" style="display: none;">
                    <label class="form-label">Preview:</label>
                    <div class="ratio ratio-16x9" style="max-width: 500px;">
                        <iframe id="youtube-iframe" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class="mt-2">
                        <img id="youtube-thumbnail" class="img-thumbnail" style="max-width: 300px; display: none;">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="thumbnail" class="form-label">Custom Thumbnail (optional)</label>
                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" 
                       id="thumbnail" name="thumbnail" accept="image/*" onchange="previewCustomThumbnail(event)">
                <small class="text-muted">Optional. Will use YouTube thumbnail if not provided. Max: 2MB</small>
                @error('thumbnail')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                <!-- Custom Thumbnail Preview -->
                <div id="custom-thumbnail-preview" class="mt-2" style="display: none;">
                    <img id="custom-thumbnail-img" class="img-thumbnail" style="max-width: 300px;">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">Category</label>
                    <input type="text" class="form-control @error('category') is-invalid @enderror" 
                           id="category" name="category" value="{{ old('category') }}" 
                           placeholder="e.g., Campus Tour, Lectures, Events">
                    @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="video_date" class="form-label">Video Date</label>
                    <input type="date" class="form-control @error('video_date') is-invalid @enderror" 
                           id="video_date" name="video_date" value="{{ old('video_date') }}">
                    @error('video_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="order" class="form-label">Order</label>
                    <input type="number" class="form-control @error('order') is-invalid @enderror" 
                           id="order" name="order" value="{{ old('order', 0) }}">
                    <small class="text-muted">Display order (lower numbers appear first)</small>
                    @error('order')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="is_active" 
                               name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.gallery-videos.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save Video
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Extract YouTube Video ID from URL
    function getYouTubeID(url) {
        const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        const match = url.match(regExp);
        return (match && match[7].length == 11) ? match[7] : null;
    }

    // Preview YouTube Video
    document.getElementById('youtube_url').addEventListener('blur', function() {
        const url = this.value;
        const videoId = getYouTubeID(url);
        
        if (videoId) {
            document.getElementById('youtube-preview').style.display = 'block';
            document.getElementById('youtube-iframe').src = `https://www.youtube.com/embed/${videoId}`;
            document.getElementById('youtube-thumbnail').src = `https://img.youtube.com/vi/${videoId}/maxresdefault.jpg`;
            document.getElementById('youtube-thumbnail').style.display = 'block';
        } else {
            document.getElementById('youtube-preview').style.display = 'none';
        }
    });

    // Preview Custom Thumbnail
    function previewCustomThumbnail(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('custom-thumbnail-preview').style.display = 'block';
                document.getElementById('custom-thumbnail-img').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
