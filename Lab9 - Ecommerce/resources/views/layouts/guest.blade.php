<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ShopUp') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex">

            {{-- Left branding panel — visible on large screens --}}
            <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gray-900">
                {{-- Background gradient --}}
                <div class="absolute inset-0 bg-gradient-to-br from-brand-600 via-brand-700 to-gray-900"></div>
                {{-- Decorative blobs --}}
                <div class="absolute -top-32 -left-32 w-96 h-96 bg-brand-400 rounded-full opacity-20 blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-80 h-80 bg-brand-300 rounded-full opacity-10 blur-3xl"></div>
                {{-- Grid pattern overlay --}}
                <div class="absolute inset-0 opacity-5" style="background-image:url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\")"></div>

                <div class="relative z-10 flex flex-col justify-center px-12 xl:px-16 text-white">
                    {{-- Brand --}}
                    <a href="{{ route('home') }}" class="flex items-center gap-3 mb-16">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-lg shadow-brand-900/30">
                            <svg class="w-7 h-7 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold tracking-tight">{{ config('app.name', 'ShopUp') }}</span>
                    </a>

                    {{-- Headline --}}
                    <h2 class="text-4xl xl:text-5xl font-extrabold leading-tight mb-5">
                        Shop smarter,<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-brand-200">
                            live better.
                        </span>
                    </h2>
                    <p class="text-blue-100 text-lg leading-relaxed mb-10 max-w-sm">
                        Join thousands of shoppers who trust us for quality products and fast, reliable delivery.
                    </p>

                    {{-- Feature list --}}
                    <ul class="space-y-3">
                        @foreach (['Free shipping on orders over $50', 'Easy 30-day hassle-free returns', 'Secure & encrypted checkout'] as $feature)
                            <li class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-white bg-opacity-20 flex items-center justify-center shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="text-blue-100 text-sm font-medium">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Right auth form panel --}}
            <div class="flex-1 flex flex-col justify-center py-12 px-6 sm:px-8 lg:px-12 bg-white overflow-y-auto">
                {{-- Mobile logo --}}
                <div class="lg:hidden mb-8 text-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5">
                        <div class="w-10 h-10 bg-brand-500 rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900">{{ config('app.name', 'ShopUp') }}</span>
                    </a>
                </div>

                <div class="mx-auto w-full max-w-sm">
                    {{ $slot }}
                </div>

                <p class="mt-8 text-center text-xs text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'ShopUp') }}. All rights reserved.
                </p>
            </div>

        </div>
    </body>
</html>
