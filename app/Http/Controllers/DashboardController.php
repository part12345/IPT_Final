<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('dashboard', [
            'categoryCount' => Category::count(),
            'productCount' => Product::count(),
            'customerCount' => Customer::count(),
            'orderCount' => Order::count(),
            'recentOrders' => Order::with('customer')
                ->latest()
                ->take(5)
                ->get(),
            'lowStock' => Product::where('stock_quantity', '<=', 5)
                ->with('category')
                ->orderBy('stock_quantity')
                ->take(5)
                ->get(),
        ]);
    }
}