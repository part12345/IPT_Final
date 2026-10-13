
@extends('layouts.app')
@section('title', $category->exists ? 'Edit Category' : 'Add Category')
@section('heading', $category->exists ? 'Edit Category' : 'Add Category')

@section('content')
<div class="panel">
    <form method="POST" action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}">
        @csrf
        @if ($category->exists) @method('PUT') @endif

        <div class="mb-3">
            <label class="form-label">Category Name *</label>
            <input name="name" value="{{ old('name', $category->name) }}"
                   class="form-control @error('name') is-invalid @enderror" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="form-check form-switch mb-4">
            <input type="hidden" name="is_active" value="0">
            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                   @checked(old('is_active', $category->exists ? $category->is_active : true))>
            <label class="form-check-label">Active category</label>
        </div>

        <button class="btn btn-primary">Save Category</button>
        <a href="{{ route('categories.index') }}" class="btn btn-light">Cancel</a>
    </form>
</div>
@endsection