
@extends('layouts.app')
@section('title', 'Orders')
@section('heading', 'Orders')

@section('content')
<div class="panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="h5 fw-bold">Customer Orders</h2>
            <p class="muted mb-0">Track purchases and fulfillment.</p>
        </div>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">+ Create Order</a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-6">
            <input name="search" value="{{ request('search') }}" class="form-control"
                   placeholder="Search order number...">
        </div>
        <div class="col-auto"><button class="btn btn-outline-primary">Search</button></div>
        <div class="col-auto"><a href="{{ route('orders.index') }}" class="btn btn-light">Reset</a></div>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Order</th><th>Customer</th><th>Date</th><th>Status</th><th>Total</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td><a class="fw-semibold text-decoration-none" href="{{ route('orders.show', $order) }}">{{ $order->order_number }}</a></td>
                    <td>{{ $order->customer->full_name }}</td>
                    <td>{{ $order->order_date->format('M d, Y') }}</td>
                    <td><span class="badge text-bg-light">{{ $order->status }}</span></td>
                    <td>₱{{ number_format($order->total_amount, 2) }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a class="btn btn-sm btn-light" href="{{ route('orders.show', $order) }}">View</a>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('orders.edit', $order) }}">Edit</a>
                            <form method="POST" action="{{ route('orders.destroy', $order) }}"
                                  onsubmit="return confirm('Delete this order and its items?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center muted py-4">No orders found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $orders->links() }}
</div>
@endsection