<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $categories = collect([
                ['name' => 'T-Shirts', 'description' => 'Casual everyday tops'],
                ['name' => 'Jeans', 'description' => 'Denim and casual trousers'],
                ['name' => 'Dresses', 'description' => 'Casual and formal dresses'],
                ['name' => 'Jackets', 'description' => 'Outerwear and jackets'],
                ['name' => 'Hoodies', 'description' => 'Comfortable hoodies and sweatshirts'],
            ])->map(fn ($data) => Category::create($data));

            $products = collect([
                ['name' => 'Classic Cotton Tee', 'category' => 'T-Shirts', 'sku' => 'SH-TS-001', 'price' => 299, 'stock' => 40, 'size' => 'M', 'color' => 'White'],
                ['name' => 'Oversized Graphic Tee', 'category' => 'T-Shirts', 'sku' => 'SH-TS-002', 'price' => 399, 'stock' => 25, 'size' => 'L', 'color' => 'Black'],
                ['name' => 'Slim Fit Denim Jeans', 'category' => 'Jeans', 'sku' => 'SH-JN-001', 'price' => 899, 'stock' => 18, 'size' => 'M', 'color' => 'Blue'],
                ['name' => 'Everyday Midi Dress', 'category' => 'Dresses', 'sku' => 'SH-DR-001', 'price' => 749, 'stock' => 12, 'size' => 'S', 'color' => 'Purple'],
                ['name' => 'Lightweight Bomber Jacket', 'category' => 'Jackets', 'sku' => 'SH-JK-001', 'price' => 1299, 'stock' => 8, 'size' => 'L', 'color' => 'Black'],
                ['name' => 'Essential Pullover Hoodie', 'category' => 'Hoodies', 'sku' => 'SH-HD-001', 'price' => 999, 'stock' => 20, 'size' => 'XL', 'color' => 'Gray'],
            ])->map(function ($data) use ($categories) {
                $category = $categories->firstWhere('name', $data['category']);

                return Product::create([
                    'category_id' => $category->id,
                    'name' => $data['name'],
                    'sku' => $data['sku'],
                    'description' => $data['name'] . ' from the StyleHub collection.',
                    'size' => $data['size'],
                    'color' => $data['color'],
                    'price' => $data['price'],
                    'stock_quantity' => $data['stock'],
                    'is_active' => true,
                ]);
            });

            // Generate additional realistic sample records with factories.
            Category::factory(2)->create();

            Product::factory(8)->create([
                'category_id' => $categories->random()->id,
            ]);

            $customers = Customer::factory(8)->create();

            $customers->each(function ($customer, $index) use ($products) {
                $order = Order::create([
                    'customer_id' => $customer->id,
                    'order_number' => 'SH-SEED-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'order_date' => now()->subDays($index)->toDateString(),
                    'status' => $index % 3 === 0 ? 'Delivered' : 'Processing',
                    'total_amount' => 0,
                    'shipping_address' => $customer->address,
                    'notes' => null,
                ]);

                $chosenProducts = $products->random(1);

                foreach ($chosenProducts as $product) {
                    $quantity = 1;
                    $price = (float) $product->price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $price,
                        'subtotal' => $price * $quantity,
                    ]);

                    $product->decrement('stock_quantity', $quantity);
                }

                $order->update([
                    'total_amount' => $order->items()->sum('subtotal'),
                ]);
            });
        });
    }
}