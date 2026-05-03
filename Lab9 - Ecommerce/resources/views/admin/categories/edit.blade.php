<x-admin-layout title="Edit Category">

    <div class="max-w-lg">

        {{-- Header --}}
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('admin.categories.index') }}"
               class="w-9 h-9 flex items-center justify-center border border-gray-200 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Edit Category</h1>
                <p class="text-sm text-gray-500 mt-0.5">{{ $category->name }}</p>
            </div>
        </div>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data"
              class="bg-white border border-gray-200 rounded-2xl p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <x-input-label for="name" value="Category Name" />
                <x-text-input id="name" name="name" type="text" class="mt-1.5 w-full"
                              :value="old('name', $category->name)" required />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="description" value="Description (optional)" />
                <textarea id="description" name="description" rows="3"
                          class="mt-1.5 w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm shadow-sm resize-none">{{ old('description', $category->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-1" />
            </div>

            <div x-data="{ preview: null }">
                <x-input-label value="Image (optional)" />
                @if ($category->image_path)
                    <div class="mt-1.5 mb-2 flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-xl">
                        <img src="{{ $category->image_url }}"
                             alt="{{ $category->name }}"
                             class="w-12 h-12 object-cover rounded-lg border border-gray-200 shrink-0">
                        <div>
                            <p class="text-xs font-semibold text-gray-700">Current Image</p>
                            <p class="text-[11px] text-gray-400">Upload to replace</p>
                        </div>
                    </div>
                @endif
                <label for="cat_image"
                       class="relative block w-full border-2 border-dashed border-gray-300 rounded-xl p-5 text-center cursor-pointer hover:border-brand-400 transition-colors"
                       x-bind:class="preview ? 'border-brand-300 bg-brand-50/30' : ''">
                    <input type="file" id="cat_image" name="image" accept="image/jpeg,image/png,image/webp"
                           class="sr-only"
                           @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                    <template x-if="!preview">
                        <div>
                            <svg class="w-7 h-7 text-gray-300 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-xs font-medium text-gray-500">Upload new image</p>
                        </div>
                    </template>
                    <template x-if="preview">
                        <div>
                            <img :src="preview" class="w-16 h-16 object-cover rounded-lg mx-auto mb-1.5 border border-brand-200">
                            <p class="text-xs text-brand-600 font-semibold">New image selected</p>
                        </div>
                    </template>
                </label>
                <x-input-error :messages="$errors->get('image')" class="mt-1" />
            </div>

            <div class="flex gap-3 pt-1">
                <a href="{{ route('admin.categories.index') }}"
                   class="flex-1 flex items-center justify-center py-3 border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors text-sm">
                    Cancel
                </a>
                <x-primary-button class="flex-1 justify-center py-3 text-sm">
                    <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </x-primary-button>
            </div>
        </form>
    </div>

</x-admin-layout>
