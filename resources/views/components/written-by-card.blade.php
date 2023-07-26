<div class="flex flex-col items-start gap-4 p-6 bg-white shadow-sm sm:rounded-md" x-show="!showComments">
    <div class="self-center text-zinc-400 sm:self-start">WRITTEN BY</div>
    <div class="flex flex-col items-center gap-4 sm:flex-row sm:items-start">
        @if (!is_null($post->author_pp))
        <img class="w-16 h-16 rounded-full" src="{{ asset('/storage/' . $post->author_pp) }}"
            alt="{{ $post->author_name . '\'s profile picture' }}">
        @else
            <div class="flex items-center justify-center flex-shrink-0 w-16 h-16 rounded-full cursor-pointer bg-zinc-200">
                <x-icons.user-outline class="w-7 h-7 text-zinc-400" />
            </div>
        @endif
        <div class="flex flex-col items-center sm:items-start">
            <a href="{{ route('authors.visit', [$post->author_username, 'page' => 1]) }}"
                class="text-lg font-semibold">{{ $post->author_name }}</a>
            <p class="text-sm text-zinc-400">{{ $post->author_bio }}</p>
        </div>
    </div>
</div>
