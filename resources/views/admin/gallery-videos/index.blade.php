@extends('admin.layout')

@section('title', 'Gallery Videos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Gallery Videos</h1>
    <a href="{{ route('admin.gallery-videos.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add Video
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="80">Thumbnail</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>YouTube ID</th>
                        <th>Date</th>
                        <th width="100">Order</th>
                        <th width="100">Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($videos as $video)
                    <tr>
                        <td>
                            @if($video->thumbnail)
                            <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->title }}" class="img-thumbnail" style="max-height: 50px;">
                            @elseif($video->embed_id)
                            <img src="https://img.youtube.com/vi/{{ $video->embed_id }}/default.jpg" alt="{{ $video->title }}" class="img-thumbnail" style="max-height: 50px;">
                            @else
                            <span class="text-muted">No thumb</span>
                            @endif
                        </td>
                        <td>{{ $video->title }}</td>
                        <td>
                            @if($video->category)
                            <span class="badge bg-info">{{ $video->category }}</span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($video->embed_id)
                            <code>{{ $video->embed_id }}</code>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $video->video_date ? $video->video_date->format('d M Y') : '-' }}</td>
                        <td>{{ $video->order ?? '-' }}</td>
                        <td>
                            @if($video->is_active)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.gallery-videos.edit', $video->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.gallery-videos.destroy', $video->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this video?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-video fa-3x mb-3"></i>
                            <p>No videos yet. Click "Add Video" to add one.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
