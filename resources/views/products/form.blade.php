
@extends('layouts.app')
@section('title', $product->exists ? 'Edit Product' : 'Add Product')
@section('heading', $product->exists ? 'Edit Product' : 'Add Product')

@section('content')
<div class="panel">
    <form method="POST" action="{{ $product->exists ? route('products.update', $product) : route('products.store') }}">
        @csrf
        @if ($product->exists) @method('PUT') @endif

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Product Name *</label>
                <input name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">SKU *</label>
                <input name="sku" value="{{ old('sku', $product->sku) }}" class="form-control" required>
                @error('sku') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Category *</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Choose category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            @selected(old('category_id', $product->category_id) == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Price (₱) *</label>
                <input type="number" name="price" min="0.01" step="0.01"
                       value="{{ old('price', $product->price) }}" class="form-control" required>
                @error('price') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Size</label>
                <select name="size" class="form-select">
                    <option value="">Select size</option>
                    @foreach (['XS','S','M','L','XL','XXL','Free Size'] as $size)
                        <option value="{{ $size }}" @selected(old('size', $product->size) == $size)>{{ $size }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Color</label>
                <input name="color" value="{{ old('color', $product->color) }}" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Stock Quantity *</label>
                <input type="number" name="stock_quantity" min="0"
                       value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" class="form-control" required>
                @error('stock_quantity') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label">Image URL (optional)</label>
                <input type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}"
                       class="form-control" placeholder="https://example.com/image.jpg">
            </div>

            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-control">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="col-12 form-check form-switch ms-2">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                       @checked(old('is_active', $product->exists ? $product->is_active : true))>
                <label class="form-check-label">Available for sale</label>
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-primary">Save Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>
</div>
@endsection