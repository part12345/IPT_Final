
@extends('layouts.app')
@section('title', 'Order Item Details')
@section('heading', 'Order Item Details')

@section('content')
<div class="panel">
    <h2 class="h5 fw-bold">{{ $orderItem->product->name }}</h2>
    <p>Order: <a href="{{ route('orders.show', $orderItem->order) }}">{{ $orderItem->order->order_number }}</a></p>
    <p>SKU: {{ $orderItem->product->sku }}</p>
    <p>Quantity: {{ $orderItem->quantity }}</p>
    <p>Unit Price: ₱{{ number_format($orderItem->unit_price, 2) }}</p>
    <p>Subtotal: ₱{{ number_format($orderItem->subtotal, 2) }}</p>
    <a href="{{ route('order-items.edit', $orderItem) }}" class="btn btn-primary">Edit Item</a>
    <a href="{{ route('orders.show', $orderItem->order) }}" class="btn btn-light">Back to Order</a>
</div>
@endsection