{{-- Auto-dismissing toast notifications for success/error/warning flash messages --}}
@if (session('success') || session('error') || session('warning') || session('info'))
    <div
        x-data="{ visible: true }"
        x-show="visible"
        x-init="setTimeout(() => visible = false, 4500)"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="fixed top-4 right-4 z-50 space-y-2 w-full max-w-sm"
    >
        @if (session('success'))
            <div class="flex items-start gap-3 bg-white border border-green-200 rounded-2xl p-4 shadow-xl shadow-green-100/50">
                <div class="shrink-0 w-8 h-8 bg-green-100 rounded-xl flex items-center justify-center mt-0.5">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900">Success</p>
                    <p class="text-sm text-gray-600 mt-0.5 leading-snug">{{ session('success') }}</p>
                </div>
                <button @click="visible = false" class="shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-start gap-3 bg-white border border-red-200 rounded-2xl p-4 shadow-xl shadow-red-100/50">
                <div class="shrink-0 w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center mt-0.5">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900">Error</p>
                    <p class="text-sm text-gray-600 mt-0.5 leading-snug">{{ session('error') }}</p>
                </div>
                <button @click="visible = false" class="shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        @if (session('warning'))
            <div class="flex items-start gap-3 bg-white border border-amber-200 rounded-2xl p-4 shadow-xl shadow-amber-100/50">
                <div class="shrink-0 w-8 h-8 bg-amber-100 rounded-xl flex items-center justify-center mt-0.5">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900">Warning</p>
                    <p class="text-sm text-gray-600 mt-0.5 leading-snug">{{ session('warning') }}</p>
                </div>
            </div>
        @endif

        @if (session('info'))
            <div class="flex items-start gap-3 bg-white border border-brand-200 rounded-2xl p-4 shadow-xl shadow-brand-100/50">
                <div class="shrink-0 w-8 h-8 bg-brand-50 rounded-xl flex items-center justify-center mt-0.5">
                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900">Info</p>
                    <p class="text-sm text-gray-600 mt-0.5 leading-snug">{{ session('info') }}</p>
                </div>
            </div>
        @endif
    </div>
@endif
