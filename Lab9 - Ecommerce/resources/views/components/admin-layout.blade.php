@props(['title' => 'Dashboard'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — Admin · {{ config('app.name', 'ShopUp') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">

        {{-- Mobile sidebar overlay --}}
        <div x-show="sidebarOpen"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black bg-opacity-60 z-20 lg:hidden"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display:none">
        </div>

        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed lg:static inset-y-0 left-0 w-64 bg-gray-950 flex flex-col z-30 transform transition-transform duration-300 ease-in-out shrink-0">

            {{-- Logo --}}
            <div class="h-16 flex items-center px-5 border-b border-gray-800 shrink-0">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-brand-500 rounded-lg flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-bold text-sm leading-tight">{{ config('app.name', 'ShopUp') }}</p>
                        <p class="text-gray-500 text-xs">Admin Panel</p>
                    </div>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
                @php
                $navItems = [
                    [
                        'route'  => 'admin.dashboard',
                        'match'  => 'admin.dashboard',
                        'label'  => 'Dashboard',
                        'icon'   => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                    ],
                    [
                        'route'  => 'admin.products.index',
                        'match'  => 'admin.products.*',
                        'label'  => 'Products',
                        'icon'   => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                    ],
                    [
                        'route'  => 'admin.categories.index',
                        'match'  => 'admin.categories.*',
                        'label'  => 'Categories',
                        'icon'   => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
                    ],
                    [
                        'route'  => 'admin.orders.index',
                        'match'  => 'admin.orders.*',
                        'label'  => 'Orders',
                        'icon'   => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                    ],
                ];
                @endphp

                @foreach ($navItems as $item)
                    @php $isActive = request()->routeIs($item['match']); @endphp
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 group
                              {{ $isActive ? 'bg-brand-500 text-white shadow-lg shadow-brand-500/25' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $item['icon'] }}"/>
                        </svg>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            {{-- Sidebar footer --}}
            <div class="shrink-0 px-3 pb-4 space-y-0.5 border-t border-gray-800 pt-4">
                <a href="{{ route('home') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-400 hover:text-white hover:bg-gray-800 transition-all duration-150">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Store
                </a>
            </div>
        </aside>

        {{-- Main content area --}}
        <div class="flex-1 flex flex-col overflow-hidden min-w-0">

            {{-- Top header --}}
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 shrink-0 z-10">
                <div class="flex items-center gap-3">
                    {{-- Mobile sidebar toggle --}}
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden flex items-center justify-center w-9 h-9 rounded-xl text-gray-500 hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h1 class="text-base font-semibold text-gray-900">{{ $title }}</h1>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-semibold text-gray-900 leading-tight">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                    <div class="w-9 h-9 rounded-xl bg-brand-500 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            {{-- Flash messages inside content area --}}
            @if (session('success') || session('error'))
                <div class="px-4 sm:px-6 pt-4 shrink-0">
                    @if (session('success'))
                        <div x-data="{ show: true }" x-show="show"
                             x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0"
                             class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm">
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="flex-1">{{ session('success') }}</span>
                            <button @click="show = false" class="text-green-500 hover:text-green-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div x-data="{ show: true }" x-show="show"
                             x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0"
                             class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
                            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span class="flex-1">{{ session('error') }}</span>
                            <button @click="show = false" class="text-red-500 hover:text-red-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto p-4 sm:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
