<div class="bg-white shadow-sm sm:rounded-md flex flex-col gap-4 items-start p-6" x-show="!showComments">
    <div class="text-zinc-400 self-center sm:self-start">WRITTEN BY</div>
    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
        <img class="w-16 h-16 rounded-full" src="{{ $post->author_pp }}"
            alt="{{ $post->author_name . '\'s profile picture' }}">
        <div class="flex flex-col items-center sm:items-start">
            <a href="{{ route('authors.visit', [$post->author_username, 'page' => 1]) }}"
                class="text-lg font-semibold">{{ $post->author_name }}</a>
            <p class="text-zinc-400 text-sm">{{ $post->author_bio }}</p>
        </div>
    </div>
</div>