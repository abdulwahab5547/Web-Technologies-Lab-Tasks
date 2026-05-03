<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Page title --}}
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Shopping Cart</h1>
            @if ($items->isNotEmpty())
                <p class="text-gray-500 mt-1 text-sm">{{ $items->count() }} {{ Str::plural('item', $items->count()) }} in your cart</p>
            @endif
        </div>

        @if ($items->isEmpty())
            {{-- Empty cart state --}}
            <div class="flex flex-col items-center justify-center py-24 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-3xl flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h2>
                <p class="text-gray-500 mb-8 max-w-sm">Looks like you haven't added anything to your cart yet. Browse our products and find something you love!</p>
                <a href="{{ route('shop.index') }}"
                   class="inline-flex items-center gap-2 bg-brand-500 text-white font-semibold px-8 py-3 rounded-xl hover:bg-brand-600 transition-all duration-150 shadow-sm">
                    Start Shopping
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- ── Cart items ────────────────────────────────────────── --}}
                <div class="lg:col-span-2 space-y-3">

                    {{-- Header row (desktop) --}}
                    <div class="hidden md:grid grid-cols-12 text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 pb-2">
                        <div class="col-span-6">Product</div>
                        <div class="col-span-2 text-center">Price</div>
                        <div class="col-span-2 text-center">Qty</div>
                        <div class="col-span-2 text-right">Total</div>
                    </div>

                    @foreach ($items as $item)
                        <div class="bg-white border border-gray-200 rounded-2xl p-4 grid grid-cols-12 gap-4 items-center hover:border-brand-200 transition-colors">

                            {{-- Image + name --}}
                            <div class="col-span-12 md:col-span-6 flex items-center gap-4">
                                <a href="{{ route('shop.show', $item->product) }}" class="shrink-0">
                                    @if ($item->product->image_path)
                                        <img src="{{ $item->product->image_url }}"
                                             alt="{{ $item->product->name }}"
                                             class="w-16 h-16 object-cover rounded-xl border border-gray-200">
                                    @else
                                        <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center text-gray-300">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </a>
                                <div class="min-w-0">
                                    <p class="text-xs text-brand-500 font-medium mb-0.5">{{ $item->product->category->name }}</p>
                                    <a href="{{ route('shop.show', $item->product) }}"
                                       class="text-sm font-semibold text-gray-900 hover:text-brand-600 transition-colors leading-snug line-clamp-2">
                                        {{ $item->product->name }}
                                    </a>
                                    {{-- Mobile price --}}
                                    <p class="text-sm font-bold text-gray-900 mt-1 md:hidden">${{ number_format($item->product->price, 2) }}</p>
                                </div>
                            </div>

                            {{-- Unit price (desktop) --}}
                            <div class="hidden md:flex md:col-span-2 justify-center">
                                <span class="text-sm font-semibold text-gray-700">${{ number_format($item->product->price, 2) }}</span>
                            </div>

                            {{-- Quantity control --}}
                            <div class="col-span-6 md:col-span-2 flex items-center justify-start md:justify-center">
                                <form action="{{ route('cart.update', $item) }}" method="POST"
                                      x-data="{ qty: {{ $item->quantity }} }" @change.debounce="$el.requestSubmit()">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center gap-0 border border-gray-300 rounded-xl overflow-hidden">
                                        <button type="button"
                                                @click="qty = Math.max(1, qty - 1); $nextTick(() => $el.closest('form').requestSubmit())"
                                                class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors text-base font-bold">−</button>
                                        <input type="number" name="quantity" :value="qty"
                                               min="1" max="{{ $item->product->stock_quantity }}"
                                               class="w-10 text-center text-sm font-bold text-gray-900 border-0 focus:ring-0 p-0 bg-transparent"
                                               x-model="qty">
                                        <button type="button"
                                                @click="qty = Math.min({{ $item->product->stock_quantity }}, qty + 1); $nextTick(() => $el.closest('form').requestSubmit())"
                                                class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors text-base font-bold">+</button>
                                    </div>
                                </form>
                            </div>

                            {{-- Line total + remove --}}
                            <div class="col-span-6 md:col-span-2 flex items-center justify-end gap-3">
                                <span class="text-sm font-bold text-gray-900">
                                    ${{ number_format($item->product->price * $item->quantity, 2) }}
                                </span>
                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all duration-150">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    {{-- Continue shopping link --}}
                    <div class="pt-2">
                        <a href="{{ route('shop.index') }}"
                           class="inline-flex items-center gap-1.5 text-sm text-brand-500 font-semibold hover:text-brand-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Continue Shopping
                        </a>
                    </div>
                </div>

                {{-- ── Order summary ─────────────────────────────────────── --}}
                <div class="lg:col-span-1">
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-5">Order Summary</h2>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-semibold text-gray-900">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                @if ($shipping == 0)
                                    <span class="font-semibold text-green-600">Free</span>
                                @else
                                    <span class="font-semibold text-gray-900">${{ number_format($shipping, 2) }}</span>
                                @endif
                            </div>
                            @if ($shipping > 0)
                                <div class="text-xs text-gray-400 bg-gray-50 rounded-xl p-2.5">
                                    <span class="text-brand-500 font-semibold">Add ${{ number_format(50 - $subtotal, 2) }} more</span> to get free shipping!
                                </div>
                            @endif
                        </div>

                        <div class="border-t border-gray-200 mt-4 pt-4">
                            <div class="flex justify-between text-base font-bold text-gray-900 mb-5">
                                <span>Total</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>

                            @auth
                                <a href="{{ route('checkout.index') }}"
                                   class="w-full flex items-center justify-center gap-2 bg-brand-500 hover:bg-brand-600 active:scale-[0.99] text-white font-bold py-3.5 rounded-xl transition-all duration-150 shadow-lg shadow-brand-500/30">
                                    Proceed to Checkout
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                   class="w-full flex items-center justify-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-bold py-3.5 rounded-xl transition-all duration-150 shadow-lg shadow-brand-500/30">
                                    Sign in to Checkout
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                </a>
                                <p class="text-xs text-center text-gray-400 mt-3">You'll be redirected back after signing in</p>
                            @endauth
                        </div>

                        {{-- Security badges --}}
                        <div class="flex items-center justify-center gap-1.5 mt-5 text-xs text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Secure & encrypted checkout
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

</x-app-layout>
