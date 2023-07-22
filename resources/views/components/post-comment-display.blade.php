<div class="flex flex-col gap-6" x-data="{ replyTo: { name: '', content: '' }, showUpdateCommentForm: false }">
    <div class="bg-white shadow-sm sm:rounded-md flex flex-col gap-4 items-start p-6 max-h-[600px] overflow-y-auto scrollbar-thin scrollbar-track-cyan-50 scrollbar-thumb-cyan-500"
        x-show="showComments">
        @if (count($comments))
            <div class="text-zinc-400 self-center sm:self-start">COMMENTS</div>
        @else
            <div class="text-zinc-400 self-center">No Comments yet.</div>
        @endif
        @foreach ($comments as $comment)
            <x-comment-card :comment="$comment" />
        @endforeach
    </div>

    @include('components.comment-form')
</div>
