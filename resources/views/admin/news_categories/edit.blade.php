@extends('admin.layout')

@section('title','Edit News Category')

@section('content')
<h4>Edit News Category</h4>

<form method="POST" action="{{ route('admin.news-categories.update', $category->id) }}">
@csrf
@method('PUT')

<div class="mb-3">
    <label>Name*</label>
    <input type="text" name="name" class="form-control" required value="{{ old('name',$category->name) }}">
</div>

<div class="mb-3">
    <label>Slug (optional)</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug',$category->slug) }}">
    <small class="text-muted">Leave empty to auto-generate</small>
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description',$category->description) }}</textarea>
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $category->is_active?'checked':'' }}>
    <label class="form-check-label" for="is_active">Active</label>
</div>

<button type="submit" class="btn btn-primary">Update</button>
<a href="{{ route('admin.news-categories.index') }}" class="btn btn-secondary">Cancel</a>

</form>
@endsection
