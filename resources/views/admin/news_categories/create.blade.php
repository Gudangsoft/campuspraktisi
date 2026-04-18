@extends('admin.layout')

@section('title','Create News Category')

@section('content')
<h4>Create News Category</h4>

<form method="POST" action="{{ route('admin.news-categories.store') }}">
@csrf

<div class="mb-3">
    <label>Name*</label>
    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
</div>

<div class="mb-3">
    <label>Slug (optional)</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
    <small class="text-muted">Leave empty to auto-generate</small>
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
    <label class="form-check-label" for="is_active">Active</label>
</div>

<button type="submit" class="btn btn-primary">Create</button>
<a href="{{ route('admin.news-categories.index') }}" class="btn btn-secondary">Cancel</a>

</form>
@endsection
