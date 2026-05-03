<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $items = CartItem::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Add some products before checking out.');
        }

        // Validate stock before showing the checkout form
        $stockErrors = $this->checkStock($items);
        if (! empty($stockErrors)) {
            return redirect()->route('cart.index')
                ->with('error', implode(' ', $stockErrors));
        }

        [$subtotal, $shipping, $total] = $this->calculateTotals($items);

        return view('shop.checkout', compact('items', 'subtotal', 'shipping', 'total'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name'   => ['required', 'string', 'max:255'],
            'address'     => ['required', 'string', 'max:500'],
            'city'        => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:20'],
            'country'     => ['required', 'string', 'max:100'],
            'phone'       => ['nullable', 'string', 'max:30'],
        ]);

        $items = CartItem::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        // Re-check stock at submission time (race-condition guard)
        $stockErrors = $this->checkStock($items);
        if (! empty($stockErrors)) {
            return redirect()->route('cart.index')
                ->with('error', implode(' ', $stockErrors));
        }

        [$subtotal, $shipping, $total] = $this->calculateTotals($items);

        $order = null;

        DB::transaction(function () use ($validated, $items, $subtotal, $shipping, $total, &$order) {
            $order = Order::create([
                'user_id'          => Auth::id(),
                'status'           => 'pending',
                'subtotal'         => $subtotal,
                'shipping'         => $shipping,
                'total'            => $total,
                'shipping_address' => $validated,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'unit_price' => $item->product->price,
                ]);

                // Decrement stock — safe because we re-validated above
                $item->product->decrement('stock_quantity', $item->quantity);
            }

            // Clear the user's cart
            CartItem::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('orders.confirmation', $order)
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Check all items against current stock.
     *
     * @return string[] List of error messages, empty if all OK.
     */
    private function checkStock(iterable $items): array
    {
        $errors = [];

        foreach ($items as $item) {
            if (! $item->product->is_active) {
                $errors[] = "\"{$item->product->name}\" is no longer available.";
            } elseif ($item->quantity > $item->product->stock_quantity) {
                $errors[] = "Only {$item->product->stock_quantity} unit(s) of \"{$item->product->name}\" left in stock.";
            }
        }

        return $errors;
    }

    /**
     * Return [subtotal, shipping, total].
     * Free shipping on orders >= $50.
     */
    private function calculateTotals(iterable $items): array
    {
        $subtotal = collect($items)->sum(fn ($i) => $i->product->price * $i->quantity);
        $shipping = $subtotal >= 50 ? 0 : 9.99;
        $total    = $subtotal + $shipping;

        return [$subtotal, $shipping, $total];
    }
}
