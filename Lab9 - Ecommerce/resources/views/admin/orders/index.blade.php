<x-admin-layout title="Orders">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Orders</h1>
            <p class="text-sm text-gray-500 mt-0.5">{{ $orders->total() }} total orders</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-4 mb-5">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap gap-3 items-center">
            <div class="relative flex-1 min-w-[200px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                </div>
                <input type="text" name="search" placeholder="Search by customer name or email…"
                       value="{{ request('search') }}"
                       class="w-full pl-9 border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm">
            </div>
            <select name="status" onchange="this.form.submit()"
                    class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm">
                <option value="">All Statuses</option>
                @foreach (['pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'] as $val => $label)
                    <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit"
                    class="px-4 py-2 bg-brand-500 text-white text-sm font-semibold rounded-xl hover:bg-brand-600 transition-colors">
                Search
            </button>
            @if (request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.orders.index') }}"
                   class="px-4 py-2 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">
                    Clear
                </a>
            @endif
        </form>
    </div>

    {{-- Status tab counts --}}
    <div class="flex gap-2 overflow-x-auto pb-1 mb-5">
        @php
            $tabStatuses = [null => 'All', 'pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'];
            $current = request('status');
        @endphp
        @foreach ($tabStatuses as $val => $label)
            <a href="{{ route('admin.orders.index', $val ? ['status' => $val] + request()->except('status', 'page') : request()->except('status', 'page')) }}"
               class="shrink-0 px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all duration-150
                      {{ ($current === $val || ($val === null && !$current))
                          ? 'bg-brand-500 text-white shadow-sm'
                          : 'bg-white border border-gray-200 text-gray-600 hover:border-brand-300 hover:text-brand-600' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
        @if ($orders->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-900 mb-1">No orders found</p>
                <p class="text-xs text-gray-500">Try adjusting your filters.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="px-5 py-3.5 text-left">Order</th>
                            <th class="px-5 py-3.5 text-left">Customer</th>
                            <th class="px-5 py-3.5 text-center">Items</th>
                            <th class="px-5 py-3.5 text-right">Total</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5 text-center">Date</th>
                            <th class="px-5 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3.5">
                                    <p class="font-bold text-gray-900">#{{ $order->id }}</p>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 bg-brand-100 rounded-full flex items-center justify-center text-brand-700 text-xs font-bold shrink-0">
                                            {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-gray-900 truncate max-w-[120px]">{{ $order->user->name }}</p>
                                            <p class="text-[11px] text-gray-400 truncate max-w-[120px]">{{ $order->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <span class="text-xs font-semibold text-gray-700">{{ $order->items->count() }}</span>
                                </td>
                                <td class="px-5 py-3.5 text-right font-bold text-gray-900">
                                    ${{ number_format($order->total, 2) }}
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <x-status-badge :status="$order->status" />
                                </td>
                                <td class="px-5 py-3.5 text-center text-xs text-gray-500">
                                    {{ $order->created_at->format('M j, Y') }}
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                       class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-500 hover:text-brand-700 transition-colors">
                                        View
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($orders->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </div>

</x-admin-layout>
