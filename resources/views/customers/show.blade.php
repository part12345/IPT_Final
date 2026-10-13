
@extends('layouts.app')
@section('title', 'Customer Details')
@section('heading', 'Customer Details')

@section('content')
<div class="panel mb-4">
    <div class="d-flex flex-wrap justify-content-between gap-3">
        <div>
            <span class="stat-icon mb-3"><i class="bi bi-person"></i></span>
            <h2 class="h4 fw-bold">{{ $customer->full_name }}</h2>
            <p class="muted mb-1">{{ $customer->email }}</p>
            <p class="muted">{{ $customer->phone ?: 'No phone number' }}</p>
        </div>
        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary align-self-start">Edit Customer</a>
    </div>
    <hr>
    <p><strong>Address:</strong> {{ $customer->address ?: 'Not provided' }}</p>
    <p><strong>City:</strong> {{ $customer->city ?: 'Not provided' }}</p>
    <p><strong>Postal Code:</strong> {{ $customer->postal_code ?: 'Not provided' }}</p>
</div>

<div class="panel">
    <h2 class="h5 fw-bold mb-3">Order History</h2>
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Order Number</th><th>Date</th><th>Status</th><th>Total</th></tr></thead>
            <tbody>
            @forelse ($customer->orders as $order)
                <tr>
                    <td><a href="{{ route('orders.show', $order) }}">{{ $order->order_number }}</a></td>
                    <td>{{ $order->order_date->format('M d, Y') }}</td>
                    <td>{{ $order->status }}</td>
                    <td>₱{{ number_format($order->total_amount, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="muted">No orders for this customer.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <a href="{{ route('customers.index') }}" class="btn btn-light">Back</a>
</div>
@endsection