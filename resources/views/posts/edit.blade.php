<x-root-layout>
    <x-slot name="head">
        <title>Editing post</title>
    </x-slot>

    <x-slot name="body">
        <div class="max-w-5xl min-h-screen mx-auto py-20">
            @dump($post)
        </div>
    </x-slot>

    <x-slot name="script">
        
    </x-slot>
</x-root-layout>