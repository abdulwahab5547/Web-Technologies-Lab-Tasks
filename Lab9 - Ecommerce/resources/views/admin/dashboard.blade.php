<x-admin-layout title="Dashboard">

    {{-- Stats grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        @foreach ([
            ['label' => 'Total Revenue',    'value' => '$'.number_format($stats['total_revenue'], 2), 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'green'],
            ['label' => 'Total Orders',     'value' => $stats['total_orders'],    'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'color' => 'brand'],
            ['label' => 'Total Customers',  'value' => $stats['total_customers'], 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'purple'],
            ['label' => 'Pending Orders',   'value' => $stats['pending_orders'],  'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'amber'],
        ] as $card)
            @php
                $colors = [
                    'green'  => ['bg' => 'bg-green-50',  'text' => 'text-green-500'],
                    'brand'  => ['bg' => 'bg-brand-50',  'text' => 'text-brand-500'],
                    'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-500'],
                    'amber'  => ['bg' => 'bg-amber-50',  'text' => 'text-amber-500'],
                ];
                $c = $colors[$card['color']];
            @endphp
            <div class="bg-white border border-gray-200 rounded-2xl p-5 flex items-center gap-4">
                <div class="w-12 h-12 {{ $c['bg'] }} rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 {{ $c['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-gray-900">{{ $card['value'] }}</p>
                    <p class="text-xs text-gray-500 font-medium mt-0.5">{{ $card['label'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Secondary stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        @foreach ([
            ['label' => 'Active Products',  'value' => $stats['active_products'],  'sub' => 'of '.$stats['total_products'].' total',  'color' => 'text-brand-600'],
            ['label' => 'Low Stock',        'value' => $stats['low_stock_count'],   'sub' => 'products ≤ 5 units',                      'color' => 'text-amber-600'],
            ['label' => 'Out of Stock',     'value' => $stats['out_of_stock'],      'sub' => 'products at 0 units',                     'color' => 'text-red-600'],
            ['label' => 'All Products',     'value' => $stats['total_products'],    'sub' => 'in catalog',                              'color' => 'text-gray-700'],
        ] as $stat)
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xl font-extrabold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
                <p class="text-xs font-semibold text-gray-700 mt-0.5">{{ $stat['label'] }}</p>
                <p class="text-[11px] text-gray-400 mt-0.5">{{ $stat['sub'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- Recent Orders --}}
        <div class="lg:col-span-3 bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-sm font-bold text-gray-900">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}"
                   class="text-xs font-semibold text-brand-500 hover:text-brand-700 transition-colors">View all →</a>
            </div>
            @if ($recentOrders->isEmpty())
                <div class="flex items-center justify-center py-12 text-sm text-gray-400">No orders yet.</div>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach ($recentOrders as $order)
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="flex items-center gap-3 px-6 py-3.5 hover:bg-gray-50 transition-colors group">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-semibold text-gray-900">Order #{{ $order->id }}</span>
                                    <x-status-badge :status="$order->status" />
                                </div>
                                <p class="text-xs text-gray-500 mt-0.5 truncate">
                                    {{ $order->user->name }} · {{ $order->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-sm font-bold text-gray-900">${{ number_format($order->total, 2) }}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-300 group-hover:text-brand-400 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Low Stock --}}
        <div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-sm font-bold text-gray-900">Low Stock Alert</h2>
                <a href="{{ route('admin.products.index') }}"
                   class="text-xs font-semibold text-brand-500 hover:text-brand-700 transition-colors">Manage →</a>
            </div>
            @if ($lowStockProducts->isEmpty())
                <div class="flex items-center justify-center py-12 text-sm text-gray-400">All products are well stocked.</div>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach ($lowStockProducts as $product)
                        <a href="{{ route('admin.products.edit', $product) }}"
                           class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition-colors group">
                            @if ($product->image_path)
                                <img src="{{ $product->image_url }}"
                                     alt="{{ $product->name }}"
                                     class="w-9 h-9 object-cover rounded-lg border border-gray-200 shrink-0">
                            @else
                                <div class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center shrink-0 text-gray-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-gray-900 truncate">{{ $product->name }}</p>
                                <p class="text-[11px] text-gray-400">{{ $product->category->name }}</p>
                            </div>
                            <span class="text-xs font-bold shrink-0 {{ $product->stock_quantity === 0 ? 'text-red-600' : 'text-amber-600' }}">
                                {{ $product->stock_quantity }} left
                            </span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</x-admin-layout>
