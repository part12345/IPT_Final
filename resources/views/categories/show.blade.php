
@extends('layouts.app')
@section('title', 'Category Details')
@section('heading', 'Category Details')

@section('content')
<div class="panel">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <span class="badge text-bg-light mb-2">Category #{{ $category->id }}</span>
            <h2 class="h4 fw-bold">{{ $category->name }}</h2>
            <p class="muted">{{ $category->description ?: 'No description provided.' }}</p>
        </div>
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">Edit</a>
    </div>

    <hr>
    <h3 class="h5">Products in this category</h3>
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Product</th><th>SKU</th><th>Price</th><th>Stock</th></tr></thead>
            <tbody>
            @forelse ($category->products as $product)
                <tr>
                    <td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
                    <td>{{ $product->sku }}</td>
                    <td>₱{{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock_quantity }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="muted">No products in this category.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <a href="{{ route('categories.index') }}" class="btn btn-light">Back</a>
</div>
@endsection