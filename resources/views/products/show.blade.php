
@extends('layouts.app')
@section('title', 'Product Details')
@section('heading', 'Product Details')

@section('content')
<div class="panel">
    <div class="row g-4">
        <div class="col-md-4">
            @if ($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                     class="img-fluid rounded-4 w-100" style="max-height:350px;object-fit:cover">
            @else
                <div class="rounded-4 d-flex align-items-center justify-content-center"
                     style="background:#f2edff;min-height:240px;color:#7652d6">
                    <i class="bi bi-bag display-1"></i>
                </div>
            @endif
        </div>

        <div class="col-md-8">
            <span class="badge text-bg-light">{{ $product->sku }}</span>
            <h2 class="h3 fw-bold mt-3">{{ $product->name }}</h2>
            <div class="display-6 fw-bold" style="color:#7652d6">
                ₱{{ number_format($product->price, 2) }}
            </div>
            <p class="muted mt-3">{{ $product->description ?: 'No description provided.' }}</p>
            <hr>
            <p><strong>Category:</strong> {{ $product->category->name }}</p>
            <p><strong>Size:</strong> {{ $product->size ?: 'Not specified' }}</p>
            <p><strong>Color:</strong> {{ $product->color ?: 'Not specified' }}</p>
            <p><strong>Stock:</strong> {{ $product->stock_quantity }}</p>
            <p><strong>Status:</strong> {{ $product->is_active ? 'Active' : 'Inactive' }}</p>
            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">Edit Product</a>
            <a href="{{ route('products.index') }}" class="btn btn-light">Back</a>
        </div>
    </div>
</div>
@endsection