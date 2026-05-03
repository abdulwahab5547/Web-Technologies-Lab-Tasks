<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Return the base query scoped to the current visitor (auth or guest).
     */
    private function cartQuery()
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id());
        }

        return CartItem::where('session_id', session()->getId());
    }

    public function index(): View
    {
        $items = $this->cartQuery()->with('product.category')->get();

        $subtotal = $items->sum(fn ($item) => $item->product->price * $item->quantity);
        $shipping = $subtotal > 0 ? ($subtotal >= 50 ? 0 : 9.99) : 0;
        $total    = $subtotal + $shipping;

        return view('shop.cart', compact('items', 'subtotal', 'shipping', 'total'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        abort_if(! $product->is_active, 404);

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $qty = (int) $request->quantity;

        // Guard against adding more than available stock
        if ($product->stock_quantity < $qty) {
            return back()->with('error', "Only {$product->stock_quantity} unit(s) available.");
        }

        if (Auth::check()) {
            $existing = CartItem::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();

            if ($existing) {
                $newQty = $existing->quantity + $qty;

                if ($newQty > $product->stock_quantity) {
                    return back()->with('error', "Cannot add more — only {$product->stock_quantity} unit(s) in stock.");
                }

                $existing->update(['quantity' => $newQty]);
            } else {
                CartItem::create([
                    'user_id'    => Auth::id(),
                    'session_id' => null,
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                ]);
            }
        } else {
            // Guest cart: no unique constraint on (session_id, product_id),
            // so we deduplicate manually.
            $sessionId = session()->getId();

            $existing = CartItem::where('session_id', $sessionId)
                ->where('product_id', $product->id)
                ->first();

            if ($existing) {
                $newQty = $existing->quantity + $qty;

                if ($newQty > $product->stock_quantity) {
                    return back()->with('error', "Cannot add more — only {$product->stock_quantity} unit(s) in stock.");
                }

                $existing->update(['quantity' => $newQty]);
            } else {
                CartItem::create([
                    'user_id'    => null,
                    'session_id' => $sessionId,
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                ]);
            }
        }

        return back()->with('success', "\"{$product->name}\" added to your cart.");
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $this->authorizeCartItem($cartItem);

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $qty = (int) $request->quantity;

        if ($qty > $cartItem->product->stock_quantity) {
            return back()->with('error', "Only {$cartItem->product->stock_quantity} unit(s) available.");
        }

        $cartItem->update(['quantity' => $qty]);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(CartItem $cartItem): RedirectResponse
    {
        $this->authorizeCartItem($cartItem);

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    /**
     * Ensure users can only mutate their own cart items.
     * Guest carts are scoped to the current session.
     */
    private function authorizeCartItem(CartItem $cartItem): void
    {
        if (Auth::check()) {
            abort_if($cartItem->user_id !== Auth::id(), 403);
        } else {
            abort_if($cartItem->session_id !== session()->getId(), 403);
        }
    }
}
