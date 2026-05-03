<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8">
            <a href="{{ route('home') }}" class="hover:text-brand-500 transition-colors">Home</a>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('shop.index') }}" class="hover:text-brand-500 transition-colors">Shop</a>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-brand-500 transition-colors">{{ $product->category->name }}</a>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 font-medium truncate max-w-xs">{{ $product->name }}</span>
        </nav>

        {{-- ── Product detail: two-column layout ────────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 xl:gap-16">

            {{-- Left: Product image --}}
            <div>
                <div class="relative rounded-3xl overflow-hidden bg-gray-50 border border-gray-200 aspect-square shadow-sm">
                    @if ($product->image_path)
                        <img src="{{ $product->image_url }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-200">
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-400 text-sm mt-2">No image</p>
                        </div>
                    @endif
                    @if ($product->stock_quantity === 0)
                        <div class="absolute top-4 right-4">
                            <span class="bg-gray-900 text-white text-xs font-bold px-3 py-1.5 rounded-full">Out of Stock</span>
                        </div>
                    @elseif ($product->isLowStock())
                        <div class="absolute top-4 right-4">
                            <span class="bg-amber-400 text-white text-xs font-bold px-3 py-1.5 rounded-full">
                                Only {{ $product->stock_quantity }} left!
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right: Product details --}}
            <div class="flex flex-col">

                {{-- Category badge --}}
                <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 bg-brand-50 border border-brand-200 px-3 py-1 rounded-full w-fit hover:bg-brand-100 transition-colors mb-4">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    {{ $product->category->name }}
                </a>

                {{-- Name --}}
                <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                    {{ $product->name }}
                </h1>

                {{-- Price --}}
                <div class="flex items-baseline gap-3 mb-5">
                    <span class="text-4xl font-extrabold text-gray-900">${{ number_format($product->price, 2) }}</span>
                </div>

                {{-- Stock status --}}
                <div class="flex items-center gap-2 mb-6">
                    @if ($product->stock_quantity > 0)
                        <div class="flex items-center gap-1.5 text-green-600 text-sm font-medium">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            @if ($product->isLowStock())
                                Only {{ $product->stock_quantity }} in stock — order soon!
                            @else
                                In Stock ({{ $product->stock_quantity }} available)
                            @endif
                        </div>
                    @else
                        <div class="flex items-center gap-1.5 text-red-500 text-sm font-medium">
                            <span class="w-2 h-2 bg-red-400 rounded-full"></span>
                            Out of Stock
                        </div>
                    @endif
                </div>

                {{-- Short description --}}
                @if ($product->description)
                    <p class="text-gray-600 leading-relaxed mb-6 line-clamp-3">{{ $product->description }}</p>
                @endif

                {{-- Divider --}}
                <div class="border-t border-gray-100 mb-6"></div>

                {{-- Add to cart form (Alpine quantity control) --}}
                @if ($product->stock_quantity > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST"
                          x-data="{ qty: 1, max: {{ $product->stock_quantity }} }">
                        @csrf
                        <input type="hidden" name="quantity" :value="qty">

                        <div class="flex flex-wrap items-center gap-4 mb-4">
                            {{-- Quantity selector --}}
                            <div class="flex items-center gap-0 border border-gray-300 rounded-xl overflow-hidden shadow-sm">
                                <button type="button"
                                        @click="qty = Math.max(1, qty - 1)"
                                        class="w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition-colors text-lg font-bold">−</button>
                                <span x-text="qty" class="w-10 text-center text-sm font-bold text-gray-900 select-none"></span>
                                <button type="button"
                                        @click="qty = Math.min(max, qty + 1)"
                                        class="w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition-colors text-lg font-bold">+</button>
                            </div>

                            {{-- Add to cart button --}}
                            <button type="submit"
                                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-brand-500 hover:bg-brand-600 active:scale-[0.98] text-white font-bold px-8 py-3 rounded-xl transition-all duration-150 shadow-lg shadow-brand-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Add to Cart
                            </button>
                        </div>
                    </form>
                @else
                    <div class="inline-flex items-center gap-2 bg-gray-100 text-gray-500 font-semibold px-8 py-3 rounded-xl cursor-not-allowed w-fit mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        Out of Stock
                    </div>
                @endif

                {{-- Trust badges --}}
                <div class="grid grid-cols-3 gap-3 mt-4">
                    @foreach ([
                        ['icon' => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8', 'text' => 'Free shipping $50+'],
                        ['icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', 'text' => '30-day returns'],
                        ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'text' => 'Secure checkout'],
                    ] as $badge)
                        <div class="flex flex-col items-center gap-1.5 bg-gray-50 rounded-xl p-3 text-center">
                            <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $badge['icon'] }}"/>
                            </svg>
                            <span class="text-[10px] font-medium text-gray-600 leading-tight">{{ $badge['text'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── Full description ─────────────────────────────────────────── --}}
        @if ($product->description)
            <div class="mt-14 border-t border-gray-200 pt-10">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Product Description</h2>
                <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
        @endif

        {{-- ── Related products ─────────────────────────────────────────── --}}
        @if ($related->isNotEmpty())
            <div class="mt-16 border-t border-gray-200 pt-10">
                <div class="flex items-end justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">You might also like</h2>
                    <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}"
                       class="text-sm font-semibold text-brand-500 hover:text-brand-700 transition-colors">
                        View all in {{ $product->category->name }} →
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
                    @foreach ($related as $relProduct)
                        @include('shop._product-card', ['product' => $relProduct])
                    @endforeach
                </div>
            </div>
        @endif

    </div>

</x-app-layout>
