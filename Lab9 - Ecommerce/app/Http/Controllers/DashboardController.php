<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();

        $totalOrders = Order::where('user_id', $userId)->count();

        $totalSpent = Order::where('user_id', $userId)
            ->whereNotIn('status', ['cancelled'])
            ->sum('total');

        $recentOrders = Order::where('user_id', $userId)
            ->with('items')
            ->latest()
            ->take(5)
            ->get();

        $pendingOrders = Order::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        return view('account.dashboard', compact(
            'totalOrders',
            'totalSpent',
            'recentOrders',
            'pendingOrders'
        ));
    }
}
