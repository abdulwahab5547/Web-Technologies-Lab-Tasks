<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 sticky top-0 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Left: Logo + desktop nav links --}}
            <div class="flex items-center gap-6 lg:gap-8 h-full">

                {{-- Brand logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0">
                    <div class="w-9 h-9 bg-brand-500 rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <span class="font-bold text-gray-900 text-[17px] tracking-tight">{{ config('app.name', 'ShopUp') }}</span>
                </a>

                {{-- Desktop navigation --}}
                <div class="hidden sm:flex items-stretch h-full gap-1">
                    <x-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*') && !request()->routeIs('cart.*')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        Shop
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('orders.*') || request()->routeIs('account.*')">
                            My Account
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            {{-- Right: Cart + Auth --}}
            <div class="flex items-center gap-1 sm:gap-2">

                {{-- Cart with badge --}}
                @php
                    $cartCount = \App\Models\CartItem::when(
                        auth()->check(),
                        fn($q) => $q->where('user_id', auth()->id()),
                        fn($q) => $q->where('session_id', session()->getId())
                    )->sum('quantity');
                @endphp

                <a href="{{ route('cart.index') }}"
                   class="relative flex items-center justify-center w-10 h-10 rounded-xl text-gray-500 hover:text-brand-500 hover:bg-brand-50 transition-all duration-150 {{ request()->routeIs('cart.*') ? 'text-brand-500 bg-brand-50' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    @if ($cartCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 min-w-[1.1rem] h-[1.1rem] bg-brand-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center leading-none px-1">
                            {{ $cartCount > 99 ? '99+' : $cartCount }}
                        </span>
                    @endif
                </a>

                {{-- Authenticated: User dropdown --}}
                @auth
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="hidden sm:inline-flex items-center gap-2 h-9 px-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-1">
                                <div class="w-6 h-6 rounded-lg bg-brand-500 text-white flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="max-w-[6rem] truncate">{{ Auth::user()->name }}</span>
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-0.5">Signed in as</p>
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="py-1">
                                <x-dropdown-link :href="route('dashboard')">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        My Account
                                    </span>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('orders.index')">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        My Orders
                                    </span>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('profile.edit')">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Profile Settings
                                    </span>
                                </x-dropdown-link>
                            </div>
                            @if (Auth::user()->is_admin)
                                <div class="py-1 border-t border-gray-100">
                                    <x-dropdown-link :href="route('admin.dashboard')">
                                        <span class="flex items-center gap-2 text-brand-600 font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            Admin Panel
                                        </span>
                                    </x-dropdown-link>
                                </div>
                            @endif
                            <div class="py-1 border-t border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        <span class="flex items-center gap-2 text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Sign Out
                                        </span>
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    {{-- Guest: Login + Register buttons --}}
                    <div class="hidden sm:flex items-center gap-2">
                        <a href="{{ route('login') }}"
                           class="h-9 px-4 inline-flex items-center text-sm font-medium text-gray-600 hover:text-brand-500 transition-colors duration-150">
                            Sign in
                        </a>
                        <a href="{{ route('register') }}"
                           class="h-9 px-4 inline-flex items-center bg-brand-500 text-white text-sm font-semibold rounded-xl hover:bg-brand-600 transition-all duration-150 shadow-sm">
                            Register
                        </a>
                    </div>
                @endauth

                {{-- Hamburger (mobile) --}}
                <button @click="open = !open"
                        class="sm:hidden flex items-center justify-center w-10 h-10 rounded-xl text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-all duration-150 focus:outline-none">
                    <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-gray-100 bg-white">
        <div class="px-4 py-2 space-y-0.5">
            <x-responsive-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*')">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Shop
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    My Account
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    My Orders
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profile
                </x-responsive-nav-link>
            @endauth
        </div>

        @auth
            <div class="border-t border-gray-100 px-4 py-3">
                <div class="flex items-center gap-3 mb-3 px-3">
                    <div class="w-9 h-9 rounded-xl bg-brand-500 text-white flex items-center justify-center font-bold shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                @if (Auth::user()->is_admin)
                    <x-responsive-nav-link :href="route('admin.dashboard')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                        Admin Panel
                    </x-responsive-nav-link>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Sign Out
                    </x-responsive-nav-link>
                </form>
            </div>
        @else
            <div class="border-t border-gray-100 px-4 py-3 flex gap-3">
                <a href="{{ route('login') }}"
                   class="flex-1 text-center py-2.5 text-sm font-medium text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors">
                    Sign in
                </a>
                <a href="{{ route('register') }}"
                   class="flex-1 text-center py-2.5 text-sm font-semibold text-white bg-brand-500 rounded-xl hover:bg-brand-600 transition-colors">
                    Register
                </a>
            </div>
        @endauth
    </div>
</nav>
