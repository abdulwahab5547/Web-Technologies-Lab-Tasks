<x-app-layout>

    {{-- ── Hero ─────────────────────────────────────────────────────────── --}}
    <section class="relative bg-gray-950 overflow-hidden">
        {{-- Gradient backdrop --}}
        <div class="absolute inset-0 bg-gradient-to-br from-brand-600 via-brand-700 to-gray-950"></div>
        {{-- Decorative blobs --}}
        <div class="absolute -top-40 -right-32 w-[32rem] h-[32rem] bg-brand-400 rounded-full opacity-20 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-400 rounded-full opacity-10 blur-3xl pointer-events-none"></div>
        {{-- Dot grid --}}
        <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle, #fff 1px, transparent 1px);background-size:32px 32px"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-36">
            <div class="max-w-2xl">
                {{-- Pill badge --}}
                <div class="inline-flex items-center gap-2 bg-white bg-opacity-10 border border-white border-opacity-20 rounded-full px-4 py-1.5 mb-8">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    <span class="text-white text-sm font-medium">Free shipping on orders over $50</span>
                </div>

                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-white leading-[1.1] tracking-tight">
                    Shop the<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 via-brand-200 to-white">
                        Best Products
                    </span>
                </h1>
                <p class="mt-6 text-xl text-blue-100 max-w-lg leading-relaxed">
                    Thousands of high-quality items at unbeatable prices. Fast delivery, easy returns — always.
                </p>
                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="{{ route('shop.index') }}"
                       class="inline-flex items-center gap-2 bg-white text-brand-600 font-bold px-8 py-3.5 rounded-2xl hover:bg-brand-50 active:scale-[0.98] transition-all duration-150 shadow-xl shadow-brand-900/30">
                        Shop Now
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="#categories"
                       class="inline-flex items-center gap-2 text-white border border-white border-opacity-30 font-semibold px-8 py-3.5 rounded-2xl hover:bg-white hover:bg-opacity-10 active:scale-[0.98] transition-all duration-150">
                        Browse Categories
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Feature strip ───────────────────────────────────────────────── --}}
    <section class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['icon' => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4', 'title' => 'Free Shipping',  'desc' => 'On orders over $50'],
                    ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Secure Payment', 'desc' => '100% encrypted'],
                    ['icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', 'title' => 'Easy Returns',   'desc' => '30-day policy'],
                    ['icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z', 'title' => '24/7 Support',   'desc' => 'Always here'],
                ] as $f)
                    <div class="flex items-center gap-3">
                        <div class="shrink-0 w-10 h-10 bg-brand-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $f['icon'] }}"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">{{ $f['title'] }}</p>
                            <p class="text-gray-500 text-xs">{{ $f['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Categories ──────────────────────────────────────────────────── --}}
    <section id="categories" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-brand-500 text-sm font-semibold uppercase tracking-wider mb-1">Browse</p>
                <h2 class="text-3xl font-extrabold text-gray-900">Shop by Category</h2>
            </div>
            <a href="{{ route('shop.index') }}"
               class="hidden sm:inline-flex items-center gap-1.5 text-sm font-semibold text-brand-500 hover:text-brand-700 transition-colors">
                View all
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if ($categories->isEmpty())
            <div class="text-center py-12 text-gray-400">No categories yet. Check back soon!</div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                       class="group relative bg-white border border-gray-200 rounded-2xl p-6 text-center hover:border-brand-300 hover:shadow-lg hover:shadow-brand-100/50 transition-all duration-200">
                        @if ($category->image_path)
                            <img src="{{ $category->image_url }}"
                                 alt="{{ $category->name }}"
                                 class="w-16 h-16 object-cover rounded-xl mx-auto mb-3 group-hover:scale-110 transition-transform duration-200">
                        @else
                            <div class="w-16 h-16 bg-brand-50 rounded-xl mx-auto mb-3 flex items-center justify-center group-hover:bg-brand-100 transition-colors duration-200">
                                <svg class="w-8 h-8 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                        @endif
                        <h3 class="font-semibold text-gray-900 group-hover:text-brand-600 transition-colors duration-150 text-sm">
                            {{ $category->name }}
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $category->products_count }} products</p>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    {{-- ── Featured Products ───────────────────────────────────────────── --}}
    <section class="bg-gray-50 border-t border-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <p class="text-brand-500 text-sm font-semibold uppercase tracking-wider mb-1">New Arrivals</p>
                    <h2 class="text-3xl font-extrabold text-gray-900">Latest Products</h2>
                </div>
                <a href="{{ route('shop.index') }}"
                   class="hidden sm:inline-flex items-center gap-1.5 text-sm font-semibold text-brand-500 hover:text-brand-700 transition-colors">
                    View all
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            @if ($featuredProducts->isEmpty())
                <div class="text-center py-12 text-gray-400">No products yet. Come back soon!</div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 lg:gap-6">
                    @foreach ($featuredProducts as $product)
                        @include('shop._product-card', ['product' => $product])
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ── CTA Banner ──────────────────────────────────────────────────── --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="relative bg-gradient-to-r from-brand-600 to-brand-800 rounded-3xl overflow-hidden px-8 py-12 lg:px-14 lg:py-16 text-center">
            <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle, #fff 1px, transparent 1px);background-size:28px 28px"></div>
            <div class="relative">
                <h2 class="text-3xl lg:text-4xl font-extrabold text-white mb-3">Ready to start shopping?</h2>
                <p class="text-blue-100 text-lg mb-8 max-w-lg mx-auto">
                    Join thousands of happy customers and find your perfect products today.
                </p>
                <a href="{{ route('shop.index') }}"
                   class="inline-flex items-center gap-2 bg-white text-brand-600 font-bold px-8 py-3.5 rounded-2xl hover:bg-brand-50 transition-all duration-150 shadow-xl">
                    Start Shopping
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

</x-app-layout>
