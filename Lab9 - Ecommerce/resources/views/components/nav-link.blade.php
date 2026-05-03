@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center gap-1.5 px-3 h-full border-b-2 border-brand-500 text-sm font-semibold text-brand-600 focus:outline-none transition duration-150 ease-in-out'
    : 'inline-flex items-center gap-1.5 px-3 h-full border-b-2 border-transparent text-sm font-medium text-gray-600 hover:text-gray-900 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
