
@extends('layouts.app')
@section('title', $order->exists ? 'Edit Order' : 'Create Order')
@section('heading', $order->exists ? 'Edit Order' : 'Create Order')

@section('content')
<div class="panel">
    <form method="POST" action="{{ $order->exists ? route('orders.update', $order) : route('orders.store') }}">
        @csrf
        @if ($order->exists) @method('PUT') @endif

        @if ($order->exists)
            <div class="mb-3">
                <label class="form-label">Order Number</label>
                <input class="form-control" value="{{ $order->order_number }}" disabled>
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Customer *</label>
            <select name="customer_id" class="form-select" required>
                <option value="">Choose customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}"
                        @selected(old('customer_id', $order->customer_id) == $customer->id)>
                        {{ $customer->full_name }} — {{ $customer->email }}
                    </option>
                @endforeach
            </select>
            @error('customer_id') <div class="text-danger small">{{ $message }}</div> @enderror
            <div class="form-text">
                Need a customer first? <a href="{{ route('customers.create') }}">Add customer</a>.
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Order Date *</label>
                <input type="date" name="order_date"
                       value="{{ old('order_date', $order->order_date?->format('Y-m-d')) }}"
                       class="form-control" required>
                @error('order_date') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Status *</label>
                <select name="status" class="form-select" required>
                    @foreach (['Pending','Processing','Shipped','Delivered','Cancelled'] as $status)
                        <option value="{{ $status }}"
                            @selected(old('status', $order->status ?: 'Pending') == $status)>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-12">
                <label class="form-label">Shipping Address</label>
                <textarea name="shipping_address" rows="3" class="form-control">{{ old('shipping_address', $order->shipping_address) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Notes</label>
                <textarea name="notes" rows="2" class="form-control">{{ old('notes', $order->notes) }}</textarea>
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-primary">{{ $order->exists ? 'Update Order' : 'Create Order' }}</button>
            <a href="{{ route('orders.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>
</div>
@endsection