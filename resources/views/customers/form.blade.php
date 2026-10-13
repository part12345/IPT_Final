
@extends('layouts.app')
@section('title', $customer->exists ? 'Edit Customer' : 'Add Customer')
@section('heading', $customer->exists ? 'Edit Customer' : 'Add Customer')

@section('content')
<div class="panel">
    <form method="POST" action="{{ $customer->exists ? route('customers.update', $customer) : route('customers.store') }}">
        @csrf
        @if ($customer->exists) @method('PUT') @endif

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">First Name *</label>
                <input name="first_name" value="{{ old('first_name', $customer->first_name) }}" class="form-control" required>
                @error('first_name') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Last Name *</label>
                <input name="last_name" value="{{ old('last_name', $customer->last_name) }}" class="form-control" required>
                @error('last_name') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Email Address *</label>
                <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="form-control" required>
                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone Number</label>
                <input name="phone" value="{{ old('phone', $customer->phone) }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Street Address</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address', $customer->address) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">City</label>
                <input name="city" value="{{ old('city', $customer->city) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Postal Code</label>
                <input name="postal_code" value="{{ old('postal_code', $customer->postal_code) }}" class="form-control">
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-primary">Save Customer</button>
            <a href="{{ route('customers.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>
</div>
@endsection