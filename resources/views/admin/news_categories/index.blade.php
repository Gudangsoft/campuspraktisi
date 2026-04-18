@extends('admin.layout')

@section('title','News Categories')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>News Categories</h4>
    <a href="{{ route('admin.news-categories.create') }}" class="btn btn-primary">Create Category</a>
</div>

<table class="table table-striped">
    <thead><tr><th>Name</th><th>Slug</th><th>Active</th><th></th></tr></thead>
    <tbody>
    @foreach($categories as $c)
        <tr>
            <td>{{ $c->name }}</td>
            <td>{{ $c->slug }}</td>
            <td>{{ $c->is_active ? 'Yes' : 'No' }}</td>
            <td>
                <a href="{{ route('admin.news-categories.edit',$c->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                <form method="POST" action="{{ route('admin.news-categories.destroy',$c->id) }}" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button></form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@endsection
