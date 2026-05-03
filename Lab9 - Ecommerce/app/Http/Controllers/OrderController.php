<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::where('user_id', Auth::id())->latest();

        // Optional status filter from the account orders page
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('account.orders', compact('orders'));
    }

    public function show(Order $order): View
    {
        // Customers may only see their own orders
        abort_if($order->user_id !== Auth::id(), 403);

        $order->load('items.product.category');

        return view('account.order-detail', compact('order'));
    }

    public function confirmation(Order $order): View
    {
        // Only the placing customer may see the confirmation page
        abort_if($order->user_id !== Auth::id(), 403);

        $order->load('items.product');

        return view('shop.confirmation', compact('order'));
    }
}
