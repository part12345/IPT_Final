
@extends('layouts.app')
@section('title', 'Products')
@section('heading', 'Products')

@section('content')
<div class="panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="h5 fw-bold">Product Inventory</h2>
            <p class="muted mb-0">Manage prices, sizes, colors, and stock.</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add Product</a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-6">
            <input class="form-control" name="search" value="{{ request('search') }}"
                   placeholder="Search name or SKU...">
        </div>
        <div class="col-auto"><button class="btn btn-outline-primary">Search</button></div>
        <div class="col-auto"><a class="btn btn-light" href="{{ route('products.index') }}">Reset</a></div>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>
                        <a class="fw-semibold text-decoration-none" href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                        <div class="small muted">{{ $product->sku }} · {{ $product->size ?: 'One size' }} · {{ $product->color ?: 'No color' }}</div>
                    </td>
                    <td>{{ $product->category->name }}</td>
                    <td>₱{{ number_format($product->price, 2) }}</td>
                    <td>
                        <span class="badge {{ $product->stock_quantity <= 5 ? 'text-bg-warning' : 'text-bg-light' }}">
                            {{ $product->stock_quantity }}
                        </span>
                    </td>
                    <td>{{ $product->is_active ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a class="btn btn-sm btn-light" href="{{ route('products.show', $product) }}">View</a>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('products.edit', $product) }}">Edit</a>
                            <form method="POST" action="{{ route('products.destroy', $product) }}"
                                  onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center muted py-4">No products found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $products->links() }}
</div>
@endsection