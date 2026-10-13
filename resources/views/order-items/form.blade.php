
@extends('layouts.app')
@section('title', $orderItem->exists ? 'Edit Order Item' : 'Add Order Item')
@section('heading', $orderItem->exists ? 'Edit Order Item' : 'Add Order Item')

@section('content')
<div class="panel">
    <p class="muted">
        Order: <strong>{{ $order->order_number ?: 'New order' }}</strong>
    </p>

    <form method="POST" action="{{ $orderItem->exists ? route('order-items.update', $orderItem) : route('order-items.store') }}">
        @csrf
        @if ($orderItem->exists) @method('PUT') @endif

        <input type="hidden" name="order_id" value="{{ old('order_id', $order->id) }}">

        <div class="mb-3">
            <label class="form-label">Product *</label>
            <select name="product_id" class="form-select" required>
                <option value="">Choose product</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}"
                        @selected(old('product_id', $orderItem->product_id) == $product->id)>
                        {{ $product->name }} — ₱{{ number_format($product->price, 2) }}
                        (Stock: {{ $product->stock_quantity }})
                    </option>
                @endforeach
            </select>
            @error('product_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Quantity *</label>
            <input type="number" name="quantity" min="1" max="10000"
                   value="{{ old('quantity', $orderItem->quantity ?? 1) }}"
                   class="form-control" required>
            @error('quantity') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary">Save Order Item</button>
        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-light">Cancel</a>
    </form>
</div>
@endsection