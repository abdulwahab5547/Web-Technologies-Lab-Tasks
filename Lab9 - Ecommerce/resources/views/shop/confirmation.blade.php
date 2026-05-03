<x-app-layout>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        {{-- Success banner --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-5">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Order Confirmed!</h1>
            <p class="text-gray-500 text-lg">Thank you for your purchase. We'll process your order right away.</p>
            <div class="mt-4 inline-flex items-center gap-2 bg-brand-50 border border-brand-200 text-brand-700 px-4 py-2 rounded-full text-sm font-semibold">
                Order #{{ $order->id }}
                <x-status-badge :status="$order->status" />
            </div>
        </div>

        {{-- Order card --}}
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm mb-6">
            {{-- Order header --}}
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium">Order placed</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 font-medium">Total amount</p>
                    <p class="text-lg font-extrabold text-gray-900">${{ number_format($order->total, 2) }}</p>
                </div>
            </div>

            {{-- Order items --}}
            <div class="divide-y divide-gray-100">
                @foreach ($order->items as $item)
                    <div class="px-6 py-4 flex items-center gap-4">
                        @if ($item->product->image_path)
                            <img src="{{ $item->product->image_url }}"
                                 alt="{{ $item->product->name }}"
                                 class="w-14 h-14 object-cover rounded-xl border border-gray-200 shrink-0">
                        @else
                            <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center shrink-0 text-gray-300">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900">{{ $item->product->name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Qty: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}</p>
                        </div>
                        <span class="text-sm font-bold text-gray-900 shrink-0">
                            ${{ number_format($item->line_total, 2) }}
                        </span>
                    </div>
                @endforeach
            </div>

            {{-- Totals --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 space-y-2">
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Subtotal</span>
                    <span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Shipping</span>
                    @if ($order->shipping == 0)
                        <span class="text-green-600 font-medium">Free</span>
                    @else
                        <span>${{ number_format($order->shipping, 2) }}</span>
                    @endif
                </div>
                <div class="flex justify-between text-base font-bold text-gray-900 pt-2 border-t border-gray-200">
                    <span>Total</span>
                    <span>${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Shipping address --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-5 mb-8">
            <h3 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Shipping Address
            </h3>
            <address class="text-sm text-gray-600 not-italic leading-relaxed">
                {{ $order->shipping_address['full_name'] }}<br>
                {{ $order->shipping_address['address'] }}<br>
                {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['postal_code'] }}<br>
                {{ $order->shipping_address['country'] }}
                @if (!empty($order->shipping_address['phone']))
                    <br>{{ $order->shipping_address['phone'] }}
                @endif
            </address>
        </div>

        {{-- CTAs --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('orders.show', $order) }}"
               class="flex-1 flex items-center justify-center gap-2 border border-brand-300 text-brand-600 font-semibold py-3 rounded-xl hover:bg-brand-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                View Order Details
            </a>
            <a href="{{ route('shop.index') }}"
               class="flex-1 flex items-center justify-center gap-2 bg-brand-500 text-white font-semibold py-3 rounded-xl hover:bg-brand-600 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Continue Shopping
            </a>
        </div>

    </div>

</x-app-layout>
