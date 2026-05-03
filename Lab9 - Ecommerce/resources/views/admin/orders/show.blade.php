<x-admin-layout title="Order #{{ $order->id }}">

    {{-- Header --}}
    <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.orders.index') }}"
               class="w-9 h-9 flex items-center justify-center border border-gray-200 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Order #{{ $order->id }}</h1>
                <p class="text-sm text-gray-500 mt-0.5">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
            </div>
        </div>

        {{-- Status update form --}}
        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST"
              class="flex items-center gap-2">
            @csrf
            @method('PATCH')
            <select name="status"
                    class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm py-2 pr-8">
                @foreach (['pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'] as $val => $label)
                    <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit"
                    class="inline-flex items-center gap-1.5 bg-brand-500 text-white font-semibold text-sm px-4 py-2 rounded-xl hover:bg-brand-600 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Update
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Order items + totals --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-bold text-gray-900">Items</h2>
                    <x-status-badge :status="$order->status" />
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach ($order->items as $item)
                        <div class="px-5 py-4 flex items-center gap-4">
                            @if ($item->product->image_path)
                                <img src="{{ $item->product->image_url }}"
                                     alt="{{ $item->product->name }}"
                                     class="w-12 h-12 object-cover rounded-xl border border-gray-200 shrink-0">
                            @else
                                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center shrink-0 text-gray-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('admin.products.edit', $item->product) }}"
                                   class="text-sm font-semibold text-gray-900 hover:text-brand-600 transition-colors">
                                    {{ $item->product->name }}
                                </a>
                                <p class="text-xs text-gray-500 mt-0.5">Qty: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}</p>
                            </div>
                            <span class="text-sm font-bold text-gray-900 shrink-0">${{ number_format($item->line_total, 2) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="px-5 py-4 bg-gray-50 border-t border-gray-200 space-y-2">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span>
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
                        <span>Total</span><span>${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Customer + Shipping --}}
        <div class="space-y-5">

            {{-- Customer info --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-5">
                <h3 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Customer
                </h3>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 bg-brand-100 rounded-full flex items-center justify-center text-brand-700 font-bold text-sm shrink-0">
                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $order->user->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $order->user->email }}</p>
                    </div>
                </div>
                <p class="text-xs text-gray-400">
                    Member since {{ $order->user->created_at->format('M Y') }} ·
                    {{ $order->user->orders()->count() }} {{ Str::plural('order', $order->user->orders()->count()) }}
                </p>
            </div>

            {{-- Shipping address --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-5">
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

            {{-- Order timeline --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-5">
                <h3 class="text-sm font-bold text-gray-900 mb-3">Order Timeline</h3>
                <div class="space-y-2 text-xs text-gray-500">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-brand-400 rounded-full shrink-0"></span>
                        <span>Created {{ $order->created_at->format('M j, Y \a\t g:i A') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-brand-400 rounded-full shrink-0"></span>
                        <span>Last updated {{ $order->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
