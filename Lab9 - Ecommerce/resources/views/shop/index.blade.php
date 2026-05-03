<x-app-layout>

    {{-- Page Header --}}
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-extrabold text-gray-900">
                @if ($activeCategory)
                    {{ $activeCategory->name }}
                @else
                    All Products
                @endif
            </h1>
            @if ($activeCategory && $activeCategory->description)
                <p class="mt-1 text-gray-500 text-sm">{{ $activeCategory->description }}</p>
            @endif

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-gray-500 mt-2">
                <a href="{{ route('home') }}" class="hover:text-brand-500 transition-colors">Home</a>
                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('shop.index') }}" class="hover:text-brand-500 transition-colors {{ !$activeCategory ? 'text-gray-900 font-medium' : '' }}">Shop</a>
                @if ($activeCategory)
                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-gray-900 font-medium">{{ $activeCategory->name }}</span>
                @endif
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex gap-8">

            {{-- ── Sidebar (desktop) ──────────────────────────────────── --}}
            <aside class="hidden lg:block w-56 shrink-0 space-y-6">

                {{-- Categories --}}
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Categories</h3>
                    <ul class="space-y-0.5">
                        <li>
                            <a href="{{ route('shop.index', array_filter(['search' => request('search'), 'sort' => request('sort')])) }}"
                               class="flex items-center justify-between px-3 py-2 rounded-xl text-sm transition-all duration-150
                                      {{ !request('category') ? 'bg-brand-50 text-brand-700 font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                All Products
                                <span class="text-xs {{ !request('category') ? 'text-brand-400' : 'text-gray-400' }}">{{ $products->total() }}</span>
                            </a>
                        </li>
                        @foreach ($categories as $cat)
                            <li>
                                <a href="{{ route('shop.index', array_filter(['category' => $cat->slug, 'search' => request('search'), 'sort' => request('sort')])) }}"
                                   class="flex items-center justify-between px-3 py-2 rounded-xl text-sm transition-all duration-150
                                          {{ request('category') === $cat->slug ? 'bg-brand-50 text-brand-700 font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                    {{ $cat->name }}
                                    <span class="text-xs {{ request('category') === $cat->slug ? 'text-brand-400' : 'text-gray-400' }}">{{ $cat->products_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Price Range --}}
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Price Range</h3>
                    <form method="GET" action="{{ route('shop.index') }}" class="space-y-2">
                        @if (request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                        @if (request('sort'))     <input type="hidden" name="sort"     value="{{ request('sort') }}"> @endif
                        @if (request('search'))   <input type="hidden" name="search"   value="{{ request('search') }}"> @endif
                        <div class="flex items-center gap-2">
                            <input type="number" name="min_price" placeholder="Min" min="0"
                                   value="{{ request('min_price') }}"
                                   class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg text-sm py-1.5 shadow-sm">
                            <span class="text-gray-400 text-xs">–</span>
                            <input type="number" name="max_price" placeholder="Max" min="0"
                                   value="{{ request('max_price') }}"
                                   class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg text-sm py-1.5 shadow-sm">
                        </div>
                        <button type="submit"
                                class="w-full text-xs font-semibold text-brand-600 border border-brand-300 rounded-xl py-1.5 hover:bg-brand-50 transition-colors">
                            Apply
                        </button>
                    </form>
                </div>

                {{-- Clear filters --}}
                @if (request()->hasAny(['category', 'search', 'min_price', 'max_price', 'sort']))
                    <a href="{{ route('shop.index') }}"
                       class="flex items-center gap-1.5 text-xs text-red-500 hover:text-red-700 font-medium transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Clear all filters
                    </a>
                @endif
            </aside>

            {{-- ── Product Grid ────────────────────────────────────────── --}}
            <div class="flex-1 min-w-0">

                {{-- Toolbar: search + sort + count --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-6">
                    {{-- Search bar --}}
                    <form method="GET" action="{{ route('shop.index') }}" class="flex gap-2 w-full sm:w-auto">
                        @if (request('category'))   <input type="hidden" name="category"  value="{{ request('category') }}"> @endif
                        @if (request('sort'))       <input type="hidden" name="sort"      value="{{ request('sort') }}"> @endif
                        @if (request('min_price'))  <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                        @if (request('max_price'))  <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif
                        <div class="relative flex-1 sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                                </svg>
                            </div>
                            <input type="text" name="search" placeholder="Search products…"
                                   value="{{ request('search') }}"
                                   class="w-full pl-9 border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm shadow-sm">
                        </div>
                        <button type="submit"
                                class="px-4 py-2 bg-brand-500 text-white text-sm font-semibold rounded-xl hover:bg-brand-600 transition-colors shadow-sm">
                            Search
                        </button>
                    </form>

                    <div class="flex items-center gap-3 shrink-0">
                        <p class="text-sm text-gray-500 hidden sm:block">
                            {{ $products->total() }} {{ Str::plural('product', $products->total()) }}
                        </p>
                        <form method="GET" action="{{ route('shop.index') }}">
                            @if (request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                            @if (request('search'))   <input type="hidden" name="search"   value="{{ request('search') }}"> @endif
                            @if (request('min_price'))<input type="hidden" name="min_price"value="{{ request('min_price') }}"> @endif
                            @if (request('max_price'))<input type="hidden" name="max_price"value="{{ request('max_price') }}"> @endif
                            <select name="sort" onchange="this.form.submit()"
                                    class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm shadow-sm py-2 pr-8">
                                <option value="newest"     {{ request('sort','newest') === 'newest'     ? 'selected' : '' }}>Newest</option>
                                <option value="price_asc"  {{ request('sort') === 'price_asc'           ? 'selected' : '' }}>Price: Low–High</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc'          ? 'selected' : '' }}>Price: High–Low</option>
                                <option value="name_asc"   {{ request('sort') === 'name_asc'            ? 'selected' : '' }}>Name: A–Z</option>
                            </select>
                        </form>
                    </div>
                </div>

                {{-- Active filter chips --}}
                @if (request()->hasAny(['category', 'search', 'min_price', 'max_price']))
                    <div class="flex flex-wrap gap-2 mb-5">
                        @if (request('category') && $activeCategory)
                            <span class="inline-flex items-center gap-1.5 bg-brand-50 text-brand-700 border border-brand-200 text-xs font-medium px-3 py-1 rounded-full">
                                {{ $activeCategory->name }}
                                <a href="{{ route('shop.index', array_filter(['search' => request('search'), 'sort' => request('sort')])) }}" class="hover:text-brand-900">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                </a>
                            </span>
                        @endif
                        @if (request('search'))
                            <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-700 text-xs font-medium px-3 py-1 rounded-full">
                                "{{ request('search') }}"
                                <a href="{{ route('shop.index', array_filter(['category' => request('category'), 'sort' => request('sort')])) }}" class="hover:text-gray-900">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                </a>
                            </span>
                        @endif
                    </div>
                @endif

                {{-- Product grid --}}
                @if ($products->isEmpty())
                    <div class="flex flex-col items-center justify-center py-24 text-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">No products found</h3>
                        <p class="text-sm text-gray-500 mb-4">Try adjusting your search or filter criteria.</p>
                        <a href="{{ route('shop.index') }}" class="text-sm font-semibold text-brand-500 hover:text-brand-700">
                            Clear all filters →
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-5">
                        @foreach ($products as $product)
                            @include('shop._product-card', ['product' => $product])
                        @endforeach
                    </div>
                    <div class="mt-10">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
