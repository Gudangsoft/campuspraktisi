@extends('admin.layout')

@section('title', 'Footer Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Footer Management</h1>
        <a href="{{ route('admin.footer.sections.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Section
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Footer Sections & Links</h6>
        </div>
        <div class="card-body">
            @if($sections->count() > 0)
                <div class="accordion" id="footerAccordion">
                    @foreach($sections as $section)
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="heading{{ $section->id }}">
                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $section->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse{{ $section->id }}">
                                <div class="d-flex justify-content-between align-items-center w-100 pe-3">
                                    <div>
                                        <strong>{{ $section->title }}</strong>
                                        <span class="badge bg-secondary ms-2">Order: {{ $section->order }}</span>
                                        @if($section->is_active)
                                            <span class="badge bg-success ms-1">Active</span>
                                        @else
                                            <span class="badge bg-secondary ms-1">Inactive</span>
                                        @endif
                                        <small class="text-muted ms-2">({{ $section->links->count() }} links)</small>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse{{ $section->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ $section->id }}" data-bs-parent="#footerAccordion">
                            <div class="accordion-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <a href="{{ route('admin.footer.links.create', $section) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus"></i> Add Link
                                    </a>
                                    <div>
                                        <a href="{{ route('admin.footer.sections.edit', $section) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit Section
                                        </a>
                                        <form action="{{ route('admin.footer.sections.destroy', $section) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this section and all its links?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Delete Section
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                @if($section->links->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Order</th>
                                                    <th>Title</th>
                                                    <th>URL</th>
                                                    <th>New Tab</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($section->links as $link)
                                                <tr>
                                                    <td>{{ $link->order }}</td>
                                                    <td>{{ $link->title }}</td>
                                                    <td><small>{{ $link->url }}</small></td>
                                                    <td>
                                                        @if($link->open_new_tab)
                                                            <span class="badge bg-info">Yes</span>
                                                        @else
                                                            <span class="badge bg-secondary">No</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($link->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.footer.links.edit', $link) }}" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.footer.links.destroy', $link) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        No links in this section yet. <a href="{{ route('admin.footer.links.create', $section) }}">Add one now</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center">
                    <p class="mb-0">No footer sections yet. <a href="{{ route('admin.footer.sections.create') }}">Create your first section</a></p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
