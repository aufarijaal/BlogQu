@props(['comment', 'postId'])

<div class="w-full">
    <div class="comment flex items-center gap-2 border w-full p-3 pr-1 rounded-md" {{ $attributes }}>
        <img class="w-8 h-8 rounded-full flex-shrink-0" src="{{ $comment['commenter']['profile']['pp'] }}"
            alt="{{ $comment['commenter']['name'] . '\'s profile picture' }}">
        <div class="flex flex-col gap-2 flex-grow">
            <div class="font-semibold">{{ $comment['commenter']['name'] }}</div>
            <p class="text-sm">{{ $comment['content'] }}</p>
            <div class="mt-2 flex gap-4">
                <form action="{{ route('comment-likes.create') }}" method="post">
                    @csrf
                    <button class="flex gap-1 items-center transition" title="Like">
                        @php
                            $commentLiked = false;
                            foreach ($comment['likes'] as $like) {
                                if ($like['user']['id'] === Auth::user()->id) {
                                    $commentLiked = true;
                                    break;
                                }
                            }
                        @endphp

                        @if ($commentLiked)
                            <x-icons.like-fill class="w-5 h-5 text-cyan-500" />
                        @else
                            <x-icons.like-outline class="w-5 h-5 text-zinc-400 hover:text-cyan-500" />
                        @endif
                        <div class="text-sm text-zinc-400">{{ count($comment['likes']) }}</div>
                    </button>
                </form>

                <button class="flex gap-1 text-zinc-400 hover:text-cyan-500 transition items-center"
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
                    <button class="w-7 h-7 flex-shrink-0 self-start">
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
        <div class="replies pl-4 flex flex-col gap-2 pt-4" x-data="{ showReplies: false }">
            <button class="text-zinc-400 pl-7 self-start hover:underline flex gap-1 items-center"
                @click="showReplies = !showReplies">
                <x-icons.arrow-down-right x-show="!showReplies" class="text-zinc-400" />
                <div
                    x-text="$el.innerText = showReplies ? 'Hide Replies' : 'Show Replies ({{ count($comment['replies']) }})'">
                    Show Replies</div>
            </button>
            <div class="flex flex-col gap-2" x-show="showReplies">
                @foreach ($comment['replies'] as $reply)
                    <div class="flex items-center gap-1">
                        <x-icons.arrow-down-right class="text-zinc-400 flex-shrink-0" />
                        <div class="reply flex items-center gap-2 border w-full p-3 pr-1 rounded-md flex-grow">
                            <img class="w-8 h-8 rounded-full" src="{{ $reply['commenter']['profile']['pp'] }}"
                                alt="{{ $reply['commenter']['name'] . '\'s profile picture' }}">
                            <div class="flex flex-col gap-2 flex-grow">
                                <div class="font-semibold">{{ $reply['commenter']['name'] }}</div>
                                <p class="text-sm">{{ $reply['content'] }}</p>
                            </div>
                            @if (Auth::user() && Auth::user()->id == (int) $reply['commenter']['id'])
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button class="w-7 h-7 flex-shrink-0 self-start">
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
