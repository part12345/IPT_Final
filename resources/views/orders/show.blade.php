
@extends('layouts.app')
@section('title', 'Order Details')
@section('heading', 'Order Details')

@section('content')
<div class="panel mb-4">
    <div class="d-flex flex-wrap justify-content-between gap-3">
        <div>
            <span class="badge text-bg-light mb-2">{{ $order->status }}</span>
            <h2 class="h4 fw-bold">{{ $order->order_number }}</h2>
            <p class="muted mb-1">Customer: {{ $order->customer->full_name }}</p>
            <p class="muted">Order date: {{ $order->order_date->format('M d, Y') }}</p>
        </div>
        <div class="text-md-end">
            <div class="muted">Order Total</div>
            <div class="display-6 fw-bold" style="color:#7652d6">
                ₱{{ number_format($order->total_amount, 2) }}
            </div>
            <a href="{{ route('orders.edit', $order) }}" class="btn btn-outline-primary mt-2">Edit Order</a>
        </div>
    </div>
    @if ($order->shipping_address)
        <hr>
        <p class="mb-1"><strong>Shipping Address</strong></p>
        <p class="muted">{{ $order->shipping_address }}</p>
    @endif
    @if ($order->notes)
        <p><strong>Notes:</strong> {{ $order->notes }}</p>
    @endif
</div>

<div class="panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h2 class="h5 fw-bold mb-1">Order Items</h2>
            <p class="muted mb-0">Quantities and subtotals are calculated from the selected products.</p>
        </div>
        <a href="{{ route('order-items.create', ['order_id' => $order->id]) }}" class="btn btn-primary">
            + Add Item
        </a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Product</th><th>Unit Price</th><th>Quantity</th><th>Subtotal</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse ($order->items as $item)
                <tr>
                    <td>
                        <a href="{{ route('products.show', $item->product) }}">
                            {{ $item->product->name }}
                        </a>
                    </td>
                    <td>₱{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₱{{ number_format($item->subtotal, 2) }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('order-items.edit', $item) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('order-items.destroy', $item) }}"
                                  onsubmit="return confirm('Remove this item and return stock?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Remove</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center muted py-4">No items added yet.</td></tr>
            @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Grand Total</th>
                    <th colspan="2">₱{{ number_format($order->total_amount, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-light">Back to Orders</a>
</div>
@endsection