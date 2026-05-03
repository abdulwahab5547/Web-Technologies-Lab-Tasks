<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'total_orders'    => Order::count(),
            'total_revenue'   => Order::whereNotIn('status', ['cancelled'])->sum('total'),
            'total_products'  => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_customers' => User::where('is_admin', false)->count(),
            'low_stock_count' => Product::where('is_active', true)
                                    ->where('stock_quantity', '>', 0)
                                    ->where('stock_quantity', '<=', 5)
                                    ->count(),
            'out_of_stock'    => Product::where('stock_quantity', 0)->count(),
            'pending_orders'  => Order::where('status', 'pending')->count(),
        ];

        $recentOrders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        $lowStockProducts = Product::where('is_active', true)
            ->where('stock_quantity', '<=', 5)
            ->with('category')
            ->orderBy('stock_quantity')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts'));
    }
}
