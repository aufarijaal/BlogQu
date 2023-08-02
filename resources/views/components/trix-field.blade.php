@props(['id', 'name', 'value' => ''])

<input type="hidden" name="{{ $name }}" id="{{ $id }}_input" value="{{ $value }}" />

<trix-editor id="{{ $id }}" input="{{ $id }}_input"
    {{ $attributes->merge(['class' => 'trix-content rounded-md shadow-sm border-gray-300 leading-[1.7] text-[#213547] dark:text-white dark:border-zinc-600']) }}></trix-editor>
