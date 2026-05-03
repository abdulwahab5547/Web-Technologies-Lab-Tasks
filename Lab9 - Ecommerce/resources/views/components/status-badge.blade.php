@props(['status'])

@php
$config = match ($status) {
    'pending'    => ['classes' => 'bg-amber-50 text-amber-700 border-amber-200',   'dot' => 'bg-amber-400',  'label' => 'Pending'],
    'processing' => ['classes' => 'bg-brand-50 text-brand-700 border-brand-200',   'dot' => 'bg-brand-400',  'label' => 'Processing'],
    'shipped'    => ['classes' => 'bg-indigo-50 text-indigo-700 border-indigo-200','dot' => 'bg-indigo-400', 'label' => 'Shipped'],
    'delivered'  => ['classes' => 'bg-green-50 text-green-700 border-green-200',   'dot' => 'bg-green-400',  'label' => 'Delivered'],
    'cancelled'  => ['classes' => 'bg-red-50 text-red-700 border-red-200',         'dot' => 'bg-red-400',    'label' => 'Cancelled'],
    default      => ['classes' => 'bg-gray-50 text-gray-700 border-gray-200',      'dot' => 'bg-gray-400',   'label' => ucfirst($status)],
};
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border ' . $config['classes']]) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }}"></span>
    {{ $config['label'] }}
</span>
