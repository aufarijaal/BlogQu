@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-cyan-400 dark:border-cyan-600 text-left text-base font-medium text-cyan-700 dark:text-cyan-300 bg-cyan-50 dark:bg-cyan-900/50 focus:outline-none focus:text-cyan-800 dark:focus:text-cyan-200 focus:bg-cyan-100 dark:focus:bg-cyan-900 focus:border-cyan-700 dark:focus:border-cyan-300 transition duration-150 ease-in-out'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
