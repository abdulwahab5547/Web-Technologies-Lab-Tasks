<x-admin-layout title="Add Product">

    <div class="max-w-2xl">

        {{-- Header --}}
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('admin.products.index') }}"
               class="w-9 h-9 flex items-center justify-center border border-gray-200 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Add New Product</h1>
                <p class="text-sm text-gray-500 mt-0.5">Fill in the details below to add a new product</p>
            </div>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
              class="space-y-5">
            @csrf

            {{-- Name --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-5">
                <h2 class="text-sm font-bold text-gray-900 mb-4">Basic Information</h2>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="name" value="Product Name" />
                        <x-text-input id="name" name="name" type="text" class="mt-1.5 w-full"
                                      :value="old('name')" placeholder="e.g. Wireless Headphones" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="category_id" value="Category" />
                        <select id="category_id" name="category_id" required
                                class="mt-1.5 w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm shadow-sm">
                            <option value="">Select a category…</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Description (optional)" />
                        <textarea id="description" name="description" rows="4"
                                  placeholder="Describe the product…"
                                  class="mt-1.5 w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm shadow-sm resize-none">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>
                </div>
            </div>

            {{-- Pricing & Stock --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-5">
                <h2 class="text-sm font-bold text-gray-900 mb-4">Pricing & Inventory</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="price" value="Price ($)" />
                        <x-text-input id="price" name="price" type="number" step="0.01" min="0"
                                      class="mt-1.5 w-full" :value="old('price')" placeholder="0.00" required />
                        <x-input-error :messages="$errors->get('price')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="stock_quantity" value="Stock Quantity" />
                        <x-text-input id="stock_quantity" name="stock_quantity" type="number" min="0"
                                      class="mt-1.5 w-full" :value="old('stock_quantity', 0)" required />
                        <x-input-error :messages="$errors->get('stock_quantity')" class="mt-1" />
                    </div>
                </div>
            </div>

            {{-- Image --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-5">
                <h2 class="text-sm font-bold text-gray-900 mb-4">Product Image</h2>
                <div x-data="{ preview: null }">
                    <label for="image"
                           class="relative block w-full border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center cursor-pointer hover:border-brand-400 transition-colors group"
                           x-bind:class="preview ? 'border-brand-300 bg-brand-50/30' : ''">
                        <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp"
                               class="sr-only"
                               @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                        <template x-if="!preview">
                            <div>
                                <svg class="w-10 h-10 text-gray-300 mx-auto mb-3 group-hover:text-brand-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm font-semibold text-gray-600">Click to upload image</p>
                                <p class="text-xs text-gray-400 mt-1">PNG, JPG, WebP — max 2MB</p>
                            </div>
                        </template>
                        <template x-if="preview">
                            <div>
                                <img :src="preview" class="w-32 h-32 object-cover rounded-xl mx-auto mb-2 border border-brand-200">
                                <p class="text-xs text-brand-600 font-semibold">Click to change image</p>
                            </div>
                        </template>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            {{-- Active toggle --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-5 flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-gray-900">Active / Visible</p>
                    <p class="text-xs text-gray-500 mt-0.5">Inactive products are hidden from the shop</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                           {{ old('is_active', true) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-brand-500 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-500"></div>
                </label>
            </div>

            {{-- Submit --}}
            <div class="flex gap-3">
                <a href="{{ route('admin.products.index') }}"
                   class="flex-1 flex items-center justify-center py-3 border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors text-sm">
                    Cancel
                </a>
                <x-primary-button class="flex-1 justify-center py-3 text-sm">
                    <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Product
                </x-primary-button>
            </div>
        </form>
    </div>

</x-admin-layout>
