<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Page header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Checkout</h1>
            <p class="text-gray-500 mt-1 text-sm">Complete your purchase below</p>
        </div>

        {{-- Progress indicator --}}
        <div class="flex items-center gap-3 mb-10">
            <div class="flex items-center gap-2 text-brand-600 font-semibold text-sm">
                <div class="w-7 h-7 bg-brand-500 text-white rounded-full flex items-center justify-center text-xs font-bold">1</div>
                Cart
            </div>
            <div class="flex-1 h-px bg-brand-300 max-w-[4rem]"></div>
            <div class="flex items-center gap-2 text-brand-600 font-semibold text-sm">
                <div class="w-7 h-7 bg-brand-500 text-white rounded-full flex items-center justify-center text-xs font-bold">2</div>
                Checkout
            </div>
            <div class="flex-1 h-px bg-gray-200 max-w-[4rem]"></div>
            <div class="flex items-center gap-2 text-gray-400 text-sm">
                <div class="w-7 h-7 bg-gray-200 rounded-full flex items-center justify-center text-xs font-medium">3</div>
                Confirmation
            </div>
        </div>

        <form method="POST" action="{{ route('checkout.store') }}">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- ── Left: Shipping Details ──────────────────────────── --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white border border-gray-200 rounded-2xl p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                            <div class="w-8 h-8 bg-brand-50 rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            Shipping Address
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <x-input-label for="full_name" :value="__('Full Name')" />
                                <x-text-input id="full_name" name="full_name" type="text"
                                              class="mt-1.5 w-full"
                                              :value="old('full_name', Auth::user()->name)"
                                              placeholder="John Doe" required />
                                <x-input-error :messages="$errors->get('full_name')" class="mt-1" />
                            </div>

                            <div class="sm:col-span-2">
                                <x-input-label for="address" :value="__('Street Address')" />
                                <x-text-input id="address" name="address" type="text"
                                              class="mt-1.5 w-full"
                                              :value="old('address')"
                                              placeholder="123 Main St, Apt 4B" required />
                                <x-input-error :messages="$errors->get('address')" class="mt-1" />
                            </div>

                            <div>
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input id="city" name="city" type="text"
                                              class="mt-1.5 w-full"
                                              :value="old('city')"
                                              placeholder="New York" required />
                                <x-input-error :messages="$errors->get('city')" class="mt-1" />
                            </div>

                            <div>
                                <x-input-label for="postal_code" :value="__('Postal / ZIP Code')" />
                                <x-text-input id="postal_code" name="postal_code" type="text"
                                              class="mt-1.5 w-full"
                                              :value="old('postal_code')"
                                              placeholder="10001" required />
                                <x-input-error :messages="$errors->get('postal_code')" class="mt-1" />
                            </div>

                            <div>
                                <x-input-label for="country" :value="__('Country')" />
                                <x-text-input id="country" name="country" type="text"
                                              class="mt-1.5 w-full"
                                              :value="old('country')"
                                              placeholder="United States" required />
                                <x-input-error :messages="$errors->get('country')" class="mt-1" />
                            </div>

                            <div>
                                <x-input-label for="phone" value="Phone (optional)" />
                                <x-text-input id="phone" name="phone" type="tel"
                                              class="mt-1.5 w-full"
                                              :value="old('phone')"
                                              placeholder="+1 555 000 0000" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                            </div>
                        </div>
                    </div>

                    {{-- Payment notice (placeholder) --}}
                    <div class="bg-white border border-gray-200 rounded-2xl p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <div class="w-8 h-8 bg-brand-50 rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            Payment Method
                        </h2>
                        <div class="flex items-center gap-3 bg-brand-50 border border-brand-200 rounded-xl p-4">
                            <input type="radio" checked readonly class="text-brand-500">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Cash on Delivery</p>
                                <p class="text-xs text-gray-500">Pay when your order arrives</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Right: Order Summary ────────────────────────────── --}}
                <div class="lg:col-span-1">
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-5">Your Order</h2>

                        {{-- Items list --}}
                        <div class="space-y-3 mb-5">
                            @foreach ($items as $item)
                                <div class="flex items-center gap-3">
                                    <div class="relative shrink-0">
                                        @if ($item->product->image_path)
                                            <img src="{{ $item->product->image_url }}"
                                                 alt="{{ $item->product->name }}"
                                                 class="w-12 h-12 object-cover rounded-xl border border-gray-200">
                                        @else
                                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-gray-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <span class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-gray-700 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $item->quantity }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-gray-800 truncate">{{ $item->product->name }}</p>
                                    </div>
                                    <span class="text-xs font-bold text-gray-900 shrink-0">
                                        ${{ number_format($item->product->price * $item->quantity, 2) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-200 pt-4 space-y-3 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-semibold text-gray-900">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                @if ($shipping == 0)
                                    <span class="font-semibold text-green-600">Free</span>
                                @else
                                    <span class="font-semibold text-gray-900">${{ number_format($shipping, 2) }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="border-t border-gray-200 mt-3 pt-4 mb-6">
                            <div class="flex justify-between font-bold text-base text-gray-900">
                                <span>Total</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <x-primary-button class="w-full justify-center py-3.5 text-sm">
                            <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Place Order
                        </x-primary-button>

                        <p class="text-[11px] text-center text-gray-400 mt-3 leading-snug">
                            By placing your order, you agree to our terms. Your cart will be cleared on confirmation.
                        </p>
                    </div>
                </div>

            </div>
        </form>
    </div>

</x-app-layout>
