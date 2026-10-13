
@extends('layouts.app')
@section('title', 'Customers')
@section('heading', 'Customers')

@section('content')
<div class="panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="h5 fw-bold">Customer Directory</h2>
            <p class="muted mb-0">Manage customer contact details.</p>
        </div>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">+ Add Customer</a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-6">
            <input name="search" value="{{ request('search') }}" class="form-control"
                   placeholder="Search name or email...">
        </div>
        <div class="col-auto"><button class="btn btn-outline-primary">Search</button></div>
        <div class="col-auto"><a href="{{ route('customers.index') }}" class="btn btn-light">Reset</a></div>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Customer</th><th>Email</th><th>Phone</th><th>Orders</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse ($customers as $customer)
                <tr>
                    <td>
                        <a href="{{ route('customers.show', $customer) }}" class="fw-semibold text-decoration-none">
                            {{ $customer->full_name }}
                        </a>
                    </td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone ?: '—' }}</td>
                    <td>{{ $customer->orders_count }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a class="btn btn-sm btn-light" href="{{ route('customers.show', $customer) }}">View</a>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('customers.edit', $customer) }}">Edit</a>
                            <form method="POST" action="{{ route('customers.destroy', $customer) }}"
                                  onsubmit="return confirm('Delete this customer?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center muted py-4">No customers found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $customers->links() }}
</div>
@endsection