<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Page header --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">My Account</h1>
                <p class="text-gray-500 mt-1 text-sm">Welcome back, {{ Auth::user()->name }}!</p>
            </div>
            <a href="{{ route('shop.index') }}"
               class="hidden sm:inline-flex items-center gap-2 bg-brand-500 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-brand-600 transition-colors text-sm shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Continue Shopping
            </a>
        </div>

        {{-- Stats cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
            {{-- Total Orders --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-5 flex items-center gap-4 hover:border-brand-200 transition-colors">
                <div class="w-12 h-12 bg-brand-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-gray-900">{{ $totalOrders }}</p>
                    <p class="text-xs text-gray-500 font-medium mt-0.5">Total Orders</p>
                </div>
            </div>

            {{-- Total Spent --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-5 flex items-center gap-4 hover:border-brand-200 transition-colors">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-gray-900">${{ number_format($totalSpent, 2) }}</p>
                    <p class="text-xs text-gray-500 font-medium mt-0.5">Total Spent</p>
                </div>
            </div>

            {{-- Pending Orders --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-5 flex items-center gap-4 hover:border-brand-200 transition-colors">
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-gray-900">{{ $pendingOrders }}</p>
                    <p class="text-xs text-gray-500 font-medium mt-0.5">Pending Orders</p>
                </div>
            </div>

            {{-- Member Since --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-5 flex items-center gap-4 hover:border-brand-200 transition-colors">
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-gray-900">{{ Auth::user()->created_at->format('M Y') }}</p>
                    <p class="text-xs text-gray-500 font-medium mt-0.5">Member Since</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Recent Orders --}}
            <div class="lg:col-span-2">
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="text-base font-bold text-gray-900">Recent Orders</h2>
                        <a href="{{ route('orders.index') }}"
                           class="text-sm font-semibold text-brand-500 hover:text-brand-700 transition-colors">
                            View all →
                        </a>
                    </div>

                    @if ($recentOrders->isEmpty())
                        <div class="flex flex-col items-center justify-center py-14 px-6 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-900 mb-1">No orders yet</p>
                            <p class="text-xs text-gray-500 mb-4">Start shopping to see your orders here.</p>
                            <a href="{{ route('shop.index') }}"
                               class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-500 hover:text-brand-700 transition-colors">
                                Browse products →
                            </a>
                        </div>
                    @else
                        <div class="divide-y divide-gray-100">
                            @foreach ($recentOrders as $order)
                                <a href="{{ route('orders.show', $order) }}"
                                   class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition-colors group">
                                    <div class="w-10 h-10 bg-brand-50 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <p class="text-sm font-semibold text-gray-900">Order #{{ $order->id }}</p>
                                            <x-status-badge :status="$order->status" />
                                        </div>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            {{ $order->created_at->format('M j, Y') }} · {{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}
                                        </p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <p class="text-sm font-bold text-gray-900">${{ number_format($order->total, 2) }}</p>
                                        <svg class="w-4 h-4 text-gray-300 group-hover:text-brand-400 transition-colors mt-1 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Quick Links + Account Info --}}
            <div class="space-y-5">

                {{-- Account info --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-5">
                    <h2 class="text-base font-bold text-gray-900 mb-4">Account Details</h2>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-brand-500 rounded-full flex items-center justify-center text-white font-bold text-lg shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}"
                       class="w-full flex items-center justify-center gap-2 border border-gray-200 text-gray-700 font-semibold text-sm py-2.5 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Profile
                    </a>
                </div>

                {{-- Quick links --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-5">
                    <h2 class="text-base font-bold text-gray-900 mb-3">Quick Links</h2>
                    <ul class="space-y-1">
                        @foreach ([
                            ['route' => 'orders.index',  'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'label' => 'Order History'],
                            ['route' => 'profile.edit', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'label' => 'Profile Settings'],
                            ['route' => 'shop.index',   'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'label' => 'Browse Shop'],
                            ['route' => 'cart.index',   'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z', 'label' => 'Shopping Cart'],
                        ] as $link)
                            <li>
                                <a href="{{ route($link['route']) }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:bg-brand-50 hover:text-brand-700 transition-colors group">
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-brand-500 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"/>
                                    </svg>
                                    <span class="font-medium">{{ $link['label'] }}</span>
                                    <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-brand-400 ml-auto transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
