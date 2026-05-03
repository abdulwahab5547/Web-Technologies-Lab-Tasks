<x-admin-layout title="Products">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Products</h1>
            <p class="text-sm text-gray-500 mt-0.5">{{ $products->total() }} total products</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center gap-2 bg-brand-500 text-white font-semibold px-4 py-2.5 rounded-xl hover:bg-brand-600 transition-colors text-sm shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Product
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-4 mb-5 flex flex-wrap gap-3 items-center">
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap gap-3 flex-1">
            <div class="relative flex-1 min-w-[200px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                </div>
                <input type="text" name="search" placeholder="Search products…"
                       value="{{ request('search') }}"
                       class="w-full pl-9 border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm">
            </div>
            <select name="category" onchange="this.form.submit()"
                    class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm">
                <option value="">All Categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            <select name="stock" onchange="this.form.submit()"
                    class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm">
                <option value="">All Stock</option>
                <option value="low"      {{ request('stock') === 'low'      ? 'selected' : '' }}>Low Stock (≤5)</option>
                <option value="out"      {{ request('stock') === 'out'       ? 'selected' : '' }}>Out of Stock</option>
                <option value="inactive" {{ request('stock') === 'inactive'  ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit"
                    class="px-4 py-2 bg-brand-500 text-white text-sm font-semibold rounded-xl hover:bg-brand-600 transition-colors">
                Search
            </button>
            @if (request()->hasAny(['search', 'category', 'stock']))
                <a href="{{ route('admin.products.index') }}"
                   class="px-4 py-2 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">
                    Clear
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
        @if ($products->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-900 mb-1">No products found</p>
                <a href="{{ route('admin.products.create') }}" class="text-sm text-brand-500 hover:text-brand-700 font-semibold mt-2">
                    Add your first product →
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="px-5 py-3.5 text-left">Product</th>
                            <th class="px-5 py-3.5 text-left">Category</th>
                            <th class="px-5 py-3.5 text-right">Price</th>
                            <th class="px-5 py-3.5 text-center">Stock</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors">
                                {{-- Product --}}
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        @if ($product->image_path)
                                            <img src="{{ $product->image_url }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-10 h-10 object-cover rounded-xl border border-gray-200 shrink-0">
                                        @else
                                            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center shrink-0 text-gray-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="font-semibold text-gray-900 truncate max-w-[180px]">{{ $product->name }}</p>
                                            <p class="text-[11px] text-gray-400 font-mono">{{ $product->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                {{-- Category --}}
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-50 text-brand-700 border border-brand-100">
                                        {{ $product->category->name }}
                                    </span>
                                </td>
                                {{-- Price --}}
                                <td class="px-5 py-3.5 text-right font-bold text-gray-900">
                                    ${{ number_format($product->price, 2) }}
                                </td>
                                {{-- Stock --}}
                                <td class="px-5 py-3.5 text-center">
                                    @if ($product->stock_quantity === 0)
                                        <span class="text-xs font-bold text-red-600 bg-red-50 px-2.5 py-1 rounded-full">Out of Stock</span>
                                    @elseif ($product->isLowStock())
                                        <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">{{ $product->stock_quantity }} left</span>
                                    @else
                                        <span class="text-xs font-semibold text-gray-700">{{ $product->stock_quantity }}</span>
                                    @endif
                                </td>
                                {{-- Status --}}
                                <td class="px-5 py-3.5 text-center">
                                    @if ($product->is_active)
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-green-700 bg-green-50 px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>Inactive
                                        </span>
                                    @endif
                                </td>
                                {{-- Actions --}}
                                <td class="px-5 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('shop.show', $product) }}" target="_blank"
                                           title="View in shop"
                                           class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-brand-500 hover:bg-brand-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                           title="Edit"
                                           class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-brand-500 hover:bg-brand-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                              onsubmit="return confirm('Delete {{ addslashes($product->name) }}? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    title="Delete"
                                                    class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($products->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </div>

</x-admin-layout>
