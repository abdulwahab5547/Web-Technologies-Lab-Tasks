<div class="group bg-white border border-gray-200 rounded-2xl overflow-hidden hover:border-brand-200 hover:shadow-xl hover:shadow-brand-100/40 transition-all duration-200 flex flex-col">

    {{-- Product Image --}}
    <a href="{{ route('shop.show', $product) }}" class="block relative overflow-hidden bg-gray-50 aspect-square">
        @if ($product->image_path)
            <img src="{{ $product->image_url }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif

        {{-- Out of stock overlay --}}
        @if ($product->stock_quantity === 0)
            <div class="absolute inset-0 bg-white bg-opacity-70 flex items-center justify-center">
                <span class="bg-gray-900 text-white text-xs font-bold px-3 py-1.5 rounded-full">Out of Stock</span>
            </div>
        @endif

        {{-- Low stock badge --}}
        @if ($product->isLowStock())
            <div class="absolute top-2 left-2">
                <span class="bg-amber-400 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                    Only {{ $product->stock_quantity }} left
                </span>
            </div>
        @endif
    </a>

    {{-- Product Info --}}
    <div class="p-4 flex flex-col flex-1">
        <p class="text-xs font-medium text-brand-500 mb-1 truncate">{{ $product->category->name }}</p>
        <a href="{{ route('shop.show', $product) }}"
           class="text-sm font-semibold text-gray-900 hover:text-brand-600 transition-colors leading-snug line-clamp-2 mb-3 flex-1">
            {{ $product->name }}
        </a>

        <div class="flex items-center justify-between gap-2 mt-auto">
            <span class="text-lg font-extrabold text-gray-900">${{ number_format($product->price, 2) }}</span>

            @if ($product->stock_quantity > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 bg-brand-500 hover:bg-brand-600 active:scale-95 text-white text-xs font-semibold px-3 py-2 rounded-xl transition-all duration-150">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add
                    </button>
                </form>
            @else
                <span class="text-xs text-gray-400 font-medium">Unavailable</span>
            @endif
        </div>
    </div>
</div>
