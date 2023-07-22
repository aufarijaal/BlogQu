@props(['active'])

@php
    $classes = $active ?? false ? 'bg-cyan-500 text-white sm:h-12 h-8 rounded-md shadow-sm sm:text-base text-sm flex items-center justify-center font-semibold overflow-hidden' : 'bg-white sm:h-12 h-8 rounded-md shadow-sm sm:text-base text-sm flex items-center justify-center font-semibold overflow-hidden';
    
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
