
@extends('layouts.app')
@section('title', 'Categories')
@section('heading', 'Categories')

@section('content')
<div class="panel">
    <div class="d-flex flex-wrap justify-content-between gap-3 mb-4">
        <div>
            <h2 class="h5 fw-bold mb-1">Clothing Categories</h2>
            <p class="muted mb-0">Organize your store's products.</p>
        </div>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Add Category
        </a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-6">
            <input name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="Search categories...">
        </div>
        <div class="col-auto"><button class="btn btn-outline-primary">Search</button></div>
        <div class="col-auto"><a href="{{ route('categories.index') }}" class="btn btn-light">Reset</a></div>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Name</th><th>Products</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>
                        <a href="{{ route('categories.show', $category) }}" class="fw-semibold text-decoration-none">
                            {{ $category->name }}
                        </a>
                        <div class="small muted">{{ Str::limit($category->description, 60) }}</div>
                    </td>
                    <td>{{ $category->products_count }}</td>
                    <td>
                        <span class="badge {{ $category->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-light">View</a>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                  onsubmit="return confirm('Delete this category?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-4 muted">No categories found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $categories->links() }}
</div>
@endsection