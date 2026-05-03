<?php

namespace App\Providers;

use App\Models\CartItem;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Merge the guest session cart into the newly authenticated user's cart.
        // This fires immediately after every successful login, before the redirect.
        Event::listen(Login::class, function (Login $event) {
            $sessionId = session()->getId();
            $userId    = $event->user->id;

            $guestItems = CartItem::where('session_id', $sessionId)->get();

            foreach ($guestItems as $guestItem) {
                $existing = CartItem::where('user_id', $userId)
                    ->where('product_id', $guestItem->product_id)
                    ->first();

                if ($existing) {
                    // Combine quantities — don't silently discard guest selections
                    $existing->increment('quantity', $guestItem->quantity);
                    $guestItem->delete();
                } else {
                    $guestItem->update([
                        'user_id'    => $userId,
                        'session_id' => null,
                    ]);
                }
            }
        });
    }
}
