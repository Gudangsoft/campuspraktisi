@extends('admin.layout')

@section('title', 'Gallery Photos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Gallery Photos</h1>
    <a href="{{ route('admin.gallery-photos.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add Photo
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
                        <th width="80">Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th width="100">Order</th>
                        <th width="100">Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($photos as $photo)
                    <tr>
                        <td>
                            @if($photo->image)
                            <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}" class="img-thumbnail" style="max-height: 50px;">
                            @else
                            <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td>{{ $photo->title }}</td>
                        <td>
                            @if($photo->category)
                            <span class="badge bg-info">{{ $photo->category }}</span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $photo->photo_date ? $photo->photo_date->format('d M Y') : '-' }}</td>
                        <td>{{ $photo->order ?? '-' }}</td>
                        <td>
                            @if($photo->is_active)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.gallery-photos.edit', $photo->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.gallery-photos.destroy', $photo->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this photo?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-image fa-3x mb-3"></i>
                            <p>No photos yet. Click "Add Photo" to upload one.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
