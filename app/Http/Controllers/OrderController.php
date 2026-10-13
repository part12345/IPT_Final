<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('customer')
            ->when($request->search, function ($query, $search) {
                $query->where('order_number', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.form', [
            'order' => new Order([
                'order_date' => now()->toDateString(),
                'status' => 'Pending',
            ]),
            'customers' => Customer::orderBy('first_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateOrder($request);

        $data['order_number'] = 'SH-' . now()->format('ymdHis')
            . '-' . strtoupper(bin2hex(random_bytes(2)));
        $data['total_amount'] = 0;

        $order = Order::create($data);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order created. You can now add its items.');
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'items.product']);

        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.form', [
            'order' => $order,
            'customers' => Customer::orderBy('first_name')->get(),
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $data = $this->validateOrder($request);
        $order->update($data);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order and its items deleted successfully.');
    }

    private function validateOrder(Request $request): array
    {
        return $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'order_date' => ['required', 'date'],
            'status' => [
                'required',
                Rule::in(['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled']),
            ],
            'shipping_address' => ['nullable', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);
    }
}