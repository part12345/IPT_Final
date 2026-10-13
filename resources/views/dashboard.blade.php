
@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
<div class="mb-4">
    <h2 class="h5 fw-bold">Welcome to StyleHub 👋</h2>
    <p class="muted mb-0">Manage your clothing inventory, customers, and orders.</p>
</div>

<div class="row g-3 mb-4">
    @foreach ([
        ['Categories', $categoryCount, 'bi-tags', 'categories.index'],
        ['Products', $productCount, 'bi-bag', 'products.index'],
        ['Customers', $customerCount, 'bi-people', 'customers.index'],
        ['Orders', $orderCount, 'bi-receipt', 'orders.index'],
    ] as [$label, $count, $icon, $route])
        <div class="col-6 col-xl-3">
            <a href="{{ route($route) }}" class="text-decoration-none text-reset">
                <div class="stat-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="muted">{{ $label }}</span>
                        <span class="stat-icon"><i class="bi {{ $icon }}"></i></span>
                    </div>
                    <div class="display-6 fw-bold">{{ $count }}</div>
                    <div class="small muted mt-2">Manage {{ strtolower($label) }} →</div>
                </div>
            </a>
        </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="panel h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 fw-bold mb-0">Recent Orders</h2>
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">View all</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr><th>Order</th><th>Customer</th><th>Status</th><th>Total</th></tr>
                    </thead>
                    <tbody>
                    @forelse ($recentOrders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('orders.show', $order) }}">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td>{{ $order->customer->full_name }}</td>
                            <td><span class="badge text-bg-light">{{ $order->status }}</span></td>
                            <td>₱{{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center muted">No orders yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="panel h-100">
            <h2 class="h5 fw-bold mb-3">Low Stock Alert</h2>
            @forelse ($lowStock as $product)
                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                    <div>
                        <a class="fw-semibold text-decoration-none"
                           href="{{ route('products.show', $product) }}">
                            {{ $product->name }}
                        </a>
                        <div class="small muted">{{ $product->category->name }}</div>
                    </div>
                    <span class="badge text-bg-warning">
                        {{ $product->stock_quantity }} left
                    </span>
                </div>
            @empty
                <p class="muted">No low-stock products.</p>
            @endforelse

            <a href="{{ route('products.create') }}" class="btn btn-primary w-100 mt-3">
                <i class="bi bi-plus-lg me-1"></i>Add Product
            </a>
        </div>
    </div>
</div>
@endsection