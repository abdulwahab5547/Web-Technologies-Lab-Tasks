<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('id', 'like', $term)
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', $term)
                                                     ->orWhere('email', 'like', $term));
            });
        }

        $orders = $query->paginate(20)->withQueryString();

        $statusCounts = Order::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    public function show(Order $order): View
    {
        $order->load('items.product.category', 'user');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:pending,processing,shipped,delivered,cancelled'],
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Guard against illegal status transitions
        if (! $this->isValidTransition($oldStatus, $newStatus)) {
            return back()->with('error',
                "Cannot move order from \"{$oldStatus}\" to \"{$newStatus}\".");
        }

        // If cancelling an order that isn't already cancelled, restore stock
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->items()->with('product')->get() as $item) {
                $item->product->increment('stock_quantity', $item->quantity);
            }
        }

        $order->update(['status' => $newStatus]);

        return back()->with('success', "Order #{$order->id} status updated to \"{$newStatus}\".");
    }

    /**
     * Simple forward-only state machine for order statuses.
     * Cancelled is a terminal state; delivered cannot be undone.
     */
    private function isValidTransition(string $from, string $to): bool
    {
        // Allow staying in the same status (idempotent)
        if ($from === $to) {
            return true;
        }

        // Delivered and cancelled are terminal — no further transitions
        if (in_array($from, ['delivered', 'cancelled'])) {
            return false;
        }

        $allowed = [
            'pending'    => ['processing', 'cancelled'],
            'processing' => ['shipped', 'cancelled'],
            'shipped'    => ['delivered', 'cancelled'],
        ];

        return in_array($to, $allowed[$from] ?? []);
    }
}
