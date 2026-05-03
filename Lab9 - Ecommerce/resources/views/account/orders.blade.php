<x-app-layout>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">Order History</h1>
                <p class="text-gray-500 mt-1 text-sm">Track and manage all your orders</p>
            </div>
            <a href="{{ route('shop.index') }}"
               class="hidden sm:inline-flex items-center gap-2 border border-gray-200 text-gray-700 font-semibold px-5 py-2.5 rounded-xl hover:bg-gray-50 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Continue Shopping
            </a>
        </div>

        {{-- Status filter tabs --}}
        <div class="flex gap-2 overflow-x-auto pb-1 mb-6 scrollbar-hide">
            @php
                $statuses = [null => 'All', 'pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'];
                $current  = request('status');
            @endphp
            @foreach ($statuses as $value => $label)
                <a href="{{ route('orders.index', $value ? ['status' => $value] : []) }}"
                   class="shrink-0 px-4 py-2 rounded-full text-sm font-semibold transition-all duration-150
                          {{ ($current === $value || ($value === null && !$current))
                              ? 'bg-brand-500 text-white shadow-sm shadow-brand-500/30'
                              : 'bg-white border border-gray-200 text-gray-600 hover:border-brand-300 hover:text-brand-600' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if ($orders->isEmpty())
            <div class="flex flex-col items-center justify-center py-24 text-center bg-white border border-gray-200 rounded-2xl">
                <div class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center mb-5">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">No orders found</h2>
                <p class="text-sm text-gray-500 mb-6 max-w-xs">
                    @if ($current)
                        You don't have any {{ $current }} orders.
                    @else
                        You haven't placed any orders yet.
                    @endif
                </p>
                <a href="{{ route('shop.index') }}"
                   class="inline-flex items-center gap-2 bg-brand-500 text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-brand-600 transition-colors text-sm shadow-sm">
                    Start Shopping
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <a href="{{ route('orders.show', $order) }}"
                       class="block bg-white border border-gray-200 rounded-2xl overflow-hidden hover:border-brand-200 hover:shadow-sm transition-all duration-150 group">

                        {{-- Order header --}}
                        <div class="px-5 py-4 flex flex-wrap items-center gap-3 sm:gap-0 sm:justify-between border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-brand-50 rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">Order #{{ $order->id }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->format('F j, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <x-status-badge :status="$order->status" />
                                <svg class="w-4 h-4 text-gray-300 group-hover:text-brand-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Order body --}}
                        <div class="px-5 py-4 flex flex-wrap items-center gap-4 justify-between">
                            {{-- Product thumbnails --}}
                            <div class="flex items-center gap-2">
                                @foreach ($order->items->take(4) as $item)
                                    @if ($item->product->image_path)
                                        <img src="{{ $item->product->image_url }}"
                                             alt="{{ $item->product->name }}"
                                             class="w-10 h-10 object-cover rounded-lg border border-gray-200 shrink-0">
                                    @else
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center shrink-0 text-gray-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                @endforeach
                                @if ($order->items->count() > 4)
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-xs font-bold text-gray-500 shrink-0">
                                        +{{ $order->items->count() - 4 }}
                                    </div>
                                @endif
                                <span class="text-sm text-gray-500 ml-1">
                                    {{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}
                                </span>
                            </div>

                            <div class="text-right">
                                <p class="text-base font-extrabold text-gray-900">${{ number_format($order->total, 2) }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">Total</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($orders->hasPages())
                <div class="mt-8">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </div>

</x-app-layout>
