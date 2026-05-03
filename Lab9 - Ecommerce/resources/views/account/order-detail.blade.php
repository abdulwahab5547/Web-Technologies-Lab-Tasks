<x-app-layout>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Back + Header --}}
        <div class="mb-7">
            <a href="{{ route('orders.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-brand-600 font-medium transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Orders
            </a>
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Order #{{ $order->id }}</h1>
                    <p class="text-gray-500 mt-1 text-sm">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                </div>
                <x-status-badge :status="$order->status" />
            </div>
        </div>

        {{-- Order progress tracker --}}
        @php
            $steps = [
                ['key' => 'pending',    'label' => 'Order Placed',  'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['key' => 'processing', 'label' => 'Processing',    'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
                ['key' => 'shipped',    'label' => 'Shipped',       'icon' => 'M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0'],
                ['key' => 'delivered',  'label' => 'Delivered',     'icon' => 'M5 13l4 4L19 7'],
            ];
            $statusOrder = ['pending' => 0, 'processing' => 1, 'shipped' => 2, 'delivered' => 3];
            $currentIdx  = $statusOrder[$order->status] ?? -1;
        @endphp

        @if ($order->status !== 'cancelled')
            <div class="bg-white border border-gray-200 rounded-2xl p-6 mb-6">
                <div class="flex items-center justify-between relative">
                    {{-- Connector lines --}}
                    <div class="absolute left-0 right-0 top-5 h-0.5 bg-gray-200 z-0" style="margin: 0 2.5rem;"></div>
                    <div class="absolute left-0 top-5 h-0.5 bg-brand-400 z-0 transition-all duration-500"
                         style="margin-left: 2.5rem; width: calc({{ ($currentIdx / 3) * 100 }}% - 0rem);"></div>

                    @foreach ($steps as $i => $step)
                        @php $done = $i <= $currentIdx; @endphp
                        <div class="flex flex-col items-center gap-2 z-10 relative">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all duration-300
                                        {{ $done ? 'bg-brand-500 border-brand-500 text-white' : 'bg-white border-gray-300 text-gray-400' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/>
                                </svg>
                            </div>
                            <span class="text-[10px] font-semibold text-center leading-tight
                                         {{ $done ? 'text-brand-600' : 'text-gray-400' }}">
                                {{ $step['label'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="bg-red-50 border border-red-200 rounded-2xl px-5 py-4 mb-6 flex items-center gap-3">
                <div class="w-9 h-9 bg-red-100 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-red-700">This order was cancelled.</p>
            </div>
        @endif

        {{-- Order items --}}
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden mb-5">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-900">Items Ordered</h2>
            </div>
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
                            <a href="{{ route('shop.show', $item->product) }}"
                               class="text-sm font-semibold text-gray-900 hover:text-brand-600 transition-colors">
                                {{ $item->product->name }}
                            </a>
                            <p class="text-xs text-gray-500 mt-0.5">Qty: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}</p>
                        </div>
                        <span class="text-sm font-bold text-gray-900 shrink-0">${{ number_format($item->line_total, 2) }}</span>
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
        <div class="bg-white border border-gray-200 rounded-2xl p-5 mb-6">
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

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('orders.index') }}"
               class="flex-1 flex items-center justify-center gap-2 border border-gray-200 text-gray-700 font-semibold py-3 rounded-xl hover:bg-gray-50 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                All Orders
            </a>
            <a href="{{ route('shop.index') }}"
               class="flex-1 flex items-center justify-center gap-2 bg-brand-500 text-white font-semibold py-3 rounded-xl hover:bg-brand-600 transition-colors shadow-sm text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Continue Shopping
            </a>
        </div>

    </div>

</x-app-layout>
