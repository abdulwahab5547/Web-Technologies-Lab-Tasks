<x-admin-layout title="Categories">

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- Category list --}}
        <div class="lg:col-span-3">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-xl font-bold text-gray-900">Categories</h1>
                <span class="text-sm text-gray-500">{{ $categories->count() }} total</span>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
                @if ($categories->isEmpty())
                    <div class="flex flex-col items-center justify-center py-16 text-center">
                        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-900 mb-1">No categories yet</p>
                        <p class="text-xs text-gray-500">Use the form to add your first category.</p>
                    </div>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                <th class="px-5 py-3.5 text-left">Category</th>
                                <th class="px-5 py-3.5 text-center">Products</th>
                                <th class="px-5 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($categories as $category)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                            @if ($category->image_path)
                                                <img src="{{ $category->image_url }}"
                                                     alt="{{ $category->name }}"
                                                     class="w-9 h-9 object-cover rounded-lg border border-gray-200 shrink-0">
                                            @else
                                                <div class="w-9 h-9 bg-brand-50 rounded-lg flex items-center justify-center shrink-0">
                                                    <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $category->name }}</p>
                                                <p class="text-[11px] text-gray-400 font-mono">{{ $category->slug }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                            {{ $category->products_count }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.categories.edit', $category) }}"
                                               class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-brand-500 hover:bg-brand-50 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                                  onsubmit="return confirm('Delete \'{{ addslashes($category->name) }}\'? All products in this category must be moved first.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
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
                @endif
            </div>
        </div>

        {{-- Create form --}}
        <div class="lg:col-span-2">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Add Category</h2>

            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"
                  class="bg-white border border-gray-200 rounded-2xl p-5 space-y-4">
                @csrf

                <div>
                    <x-input-label for="name" value="Category Name" />
                    <x-text-input id="name" name="name" type="text" class="mt-1.5 w-full"
                                  :value="old('name')" placeholder="e.g. Electronics" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="description" value="Description (optional)" />
                    <textarea id="description" name="description" rows="3"
                              placeholder="Brief description…"
                              class="mt-1.5 w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm shadow-sm resize-none">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>

                <div x-data="{ preview: null }">
                    <x-input-label value="Image (optional)" />
                    <label for="cat_image"
                           class="mt-1.5 relative block w-full border-2 border-dashed border-gray-300 rounded-xl p-5 text-center cursor-pointer hover:border-brand-400 transition-colors">
                        <input type="file" id="cat_image" name="image" accept="image/jpeg,image/png,image/webp"
                               class="sr-only"
                               @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                        <template x-if="!preview">
                            <div>
                                <svg class="w-7 h-7 text-gray-300 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-xs font-medium text-gray-500">Upload image</p>
                            </div>
                        </template>
                        <template x-if="preview">
                            <div>
                                <img :src="preview" class="w-16 h-16 object-cover rounded-lg mx-auto mb-1.5 border border-brand-200">
                                <p class="text-xs text-brand-600 font-semibold">Change image</p>
                            </div>
                        </template>
                    </label>
                    <x-input-error :messages="$errors->get('image')" class="mt-1" />
                </div>

                <x-primary-button class="w-full justify-center py-2.5 text-sm">
                    <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Category
                </x-primary-button>
            </form>
        </div>
    </div>

</x-admin-layout>
