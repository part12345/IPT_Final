<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderItemController extends Controller
{
    public function index()
    {
        return redirect()->route('orders.index');
    }

    public function create(Request $request)
    {
        $order = Order::findOrFail($request->integer('order_id'));

        return view('order-items.form', [
            'orderItem' => new OrderItem(),
            'order' => $order,
            'products' => Product::where('is_active', true)
                ->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateItem($request);

        DB::transaction(function () use ($data) {
            $product = Product::whereKey($data['product_id'])
                ->lockForUpdate()->firstOrFail();

            if ($product->stock_quantity < $data['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => 'The requested quantity exceeds available stock.',
                ]);
            }

            $subtotal = $product->price * $data['quantity'];

            OrderItem::create([
                'order_id' => $data['order_id'],
                'product_id' => $product->id,
                'quantity' => $data['quantity'],
                'unit_price' => $product->price,
                'subtotal' => $subtotal,
            ]);

            $product->decrement('stock_quantity', $data['quantity']);

            $this->recalculateTotal($data['order_id']);
        });

        return redirect()->route('orders.show', $data['order_id'])
            ->with('success', 'Order item added successfully.');
    }

    public function show(OrderItem $orderItem)
    {
        $orderItem->load(['order', 'product']);

        return view('order-items.show', compact('orderItem'));
    }

    public function edit(OrderItem $orderItem)
    {
        return view('order-items.form', [
            'orderItem' => $orderItem,
            'order' => $orderItem->order,
            'products' => Product::where('is_active', true)
                ->orWhereKey($orderItem->product_id)
                ->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        $data = $this->validateItem($request, $orderItem);

        DB::transaction(function () use ($data, $orderItem) {
            $item = OrderItem::whereKey($orderItem->id)
                ->lockForUpdate()->firstOrFail();

            $oldProduct = Product::whereKey($item->product_id)
                ->lockForUpdate()->firstOrFail();

            // Return the old quantity to stock.
            $oldProduct->increment('stock_quantity', $item->quantity);

            $newProduct = Product::whereKey($data['product_id'])
                ->lockForUpdate()->firstOrFail();

            if ($newProduct->stock_quantity < $data['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => 'The requested quantity exceeds available stock.',
                ]);
            }

            $newProduct->decrement('stock_quantity', $data['quantity']);

            $item->update([
                'product_id' => $newProduct->id,
                'quantity' => $data['quantity'],
                'unit_price' => $newProduct->price,
                'subtotal' => $newProduct->price * $data['quantity'],
            ]);

            $this->recalculateTotal($item->order_id);
        });

        return redirect()->route('orders.show', $orderItem->order_id)
            ->with('success', 'Order item updated successfully.');
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderId = $orderItem->order_id;

        DB::transaction(function () use ($orderItem, $orderId) {
            $item = OrderItem::whereKey($orderItem->id)
                ->lockForUpdate()->firstOrFail();

            Product::whereKey($item->product_id)
                ->increment('stock_quantity', $item->quantity);

            $item->delete();

            $this->recalculateTotal($orderId);
        });

        return redirect()->route('orders.show', $orderId)
            ->with('success', 'Order item removed and stock restored.');
    }

    private function validateItem(
        Request $request,
        ?OrderItem $item = null
    ): array {
        return $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10000'],
        ]);
    }

    private function recalculateTotal(int $orderId): void
    {
        $total = OrderItem::where('order_id', $orderId)->sum('subtotal');

        Order::whereKey($orderId)->update([
            'total_amount' => $total,
        ]);
    }
}