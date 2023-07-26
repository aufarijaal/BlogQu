@props(['comment', 'postId'])

@php
    $commentLiked = false;
    foreach ($comment['likes'] as $like) {
        if ($like['user']['id'] === Auth::user()->id) {
            $commentLiked = true;
            break;
        }
    }
@endphp

<div class="w-full">
    <div class="flex items-center w-full gap-2 p-3 pr-1 border rounded-md comment" {{ $attributes }}>
        @if (!is_null($comment['commenter']['profile']['pp']))
            <img class="flex-shrink-0 w-8 h-8 rounded-full"
                src="{{ asset('/storage/' . $comment['commenter']['profile']['pp']) }}"
                alt="{{ $comment['commenter']['name'] . '\'s profile picture' }}">
        @else
            <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-full cursor-pointer bg-zinc-200">
                <x-icons.user-outline class="w-4 h-4 text-zinc-400" />
            </div>
        @endif
        <div class="flex flex-col flex-grow gap-2">
            <div class="font-semibold">{{ $comment['commenter']['name'] }}</div>
            <p class="text-sm break-all">{{ $comment['content'] }}</p>
            <div class="flex gap-4 mt-2">
                <form action="{{ $commentLiked ? route('comment-likes.destroy') : route('comment-likes.create') }}"
                    method="post">
                    @csrf

                    @if ($commentLiked)
                        @method('delete')
                    @endif

                    <input type="hidden" name="comment-id" value="{{ $comment['id'] }}">
                    <button class="flex items-center gap-1 transition" title="Like">
                        @if ($commentLiked)
                            <x-icons.like-fill class="w-5 h-5 text-cyan-500" />
                        @else
                            <x-icons.like-outline class="w-5 h-5 text-zinc-400 hover:text-cyan-500" />
                        @endif
                        <div class="text-sm text-zinc-400">{{ count($comment['likes']) }}</div>
                    </button>
                </form>

                <button class="flex items-center gap-1 transition text-zinc-400 hover:text-cyan-500"
                    @click="() => {
                    $refs.inputCommentParentId.value = {{ $comment['id'] }}
                    replyTo = {
                        name: `{{ $comment['commenter']['name'] }}`,
                        content: `{{ $comment['content'] }}`,
                    }
                }"
                    title="Reply this">
                    <x-icons.reply class="w-5 h-5" />
                </button>
            </div>
        </div>

        {{-- Comment actions for authenticated user --}}
        @if (Auth::user() && Auth::user()->id == (int) $comment['commenter']['id'])
            <x-dropdown>
                <x-slot name="trigger">
                    <button class="self-start flex-shrink-0 w-7 h-7">
                        <x-icons.three-dots class="w-5 h-5 text-zinc-400" />
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-button
                        @click="() => {
                        $refs.inputUpdateCommentId.value = {{ $comment['id'] }};
                        $refs.inputUpdateCommentContent.value = `{{ $comment['content'] }}`;
                        showUpdateCommentForm = true;
                    }">
                        Edit comment
                    </x-dropdown-button>
                    <x-dropdown-button class="font-semibold text-rose-500" type="submit" form="form-delete-comment">
                        <form id="form-delete-comment" action="{{ route('comments.destroy') }}" method="post">
                            @csrf
                            @method('delete')

                            <input type="hidden" name="comment-id" value="{{ $comment['id'] }}">
                        </form>
                        Delete comment
                    </x-dropdown-button>
                </x-slot>
            </x-dropdown>
        @endif
    </div>

    @if ($comment['replies'])
        <div class="flex flex-col gap-2 pt-4 pl-4 replies" x-data="{ showReplies: false }">
            <button class="flex items-center self-start gap-1 text-zinc-400 pl-7 hover:underline"
                @click="showReplies = !showReplies">
                <x-icons.arrow-down-right x-show="!showReplies" class="w-5 h-5 text-zinc-400" />
                <div class="text-sm"
                    x-text="$el.innerText = showReplies ? 'Hide Replies' : 'Replies ({{ count($comment['replies']) }})'">
                    Show Replies</div>
            </button>
            <div class="flex flex-col gap-2" x-show="showReplies">
                @foreach ($comment['replies'] as $reply)
                    <div class="flex items-center gap-1">
                        <x-icons.arrow-down-right class="flex-shrink-0 text-zinc-400" />
                        <div class="flex items-center flex-grow w-full gap-2 p-3 pr-1 border rounded-md reply">
                            @if (!is_null($comment['commenter']['profile']['pp']))
                                <img class="flex-shrink-0 w-8 h-8 rounded-full"
                                    src="{{ asset('/storage/' . $comment['commenter']['profile']['pp']) }}"
                                    alt="{{ $comment['commenter']['name'] . '\'s profile picture' }}">
                            @else
                                <div
                                    class="flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-full cursor-pointer bg-zinc-200">
                                    <x-icons.user-outline class="w-4 h-4 text-zinc-400" />
                                </div>
                            @endif
                            <div class="flex flex-col flex-grow gap-2">
                                <div class="font-semibold">{{ $reply['commenter']['name'] }}</div>
                                <p class="text-sm">{{ $reply['content'] }}</p>
                            </div>
                            @if (Auth::user() && Auth::user()->id == (int) $reply['commenter']['id'])
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button class="self-start flex-shrink-0 w-7 h-7">
                                            <x-icons.three-dots class="w-5 h-5 text-zinc-400" />
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-button
                                            @click="() => {
                                        $refs.inputUpdateCommentId.value = {{ $reply['id'] }};
                                        $refs.inputUpdateCommentContent.value = `{{ $reply['content'] }}`;
                                        showUpdateCommentForm = true;
                                    }">
                                            Edit comment
                                        </x-dropdown-button>
                                        <x-dropdown-button class="font-semibold text-rose-500" type="submit"
                                            form="form-delete-comment">
                                            <form id="form-delete-comment" action="{{ route('comments.destroy') }}"
                                                method="post">
                                                @csrf
                                                @method('delete')

                                                <input type="hidden" name="comment-id" value="{{ $reply['id'] }}">
                                            </form>
                                            Delete comment
                                        </x-dropdown-button>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
