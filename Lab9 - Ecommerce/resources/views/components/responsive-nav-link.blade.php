@props(['active'])

@php
$classes = ($active ?? false)
    ? 'flex items-center gap-2 w-full ps-3 pe-4 py-2.5 border-l-4 border-brand-500 text-sm font-semibold text-brand-700 bg-brand-50 focus:outline-none transition duration-150 ease-in-out'
    : 'flex items-center gap-2 w-full ps-3 pe-4 py-2.5 border-l-4 border-transparent text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
