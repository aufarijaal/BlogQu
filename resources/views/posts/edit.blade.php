<x-root-layout>
    <x-slot name="head">
        <title>Editing post</title>
    </x-slot>

    <x-slot name="body">
        <div class="max-w-5xl min-h-screen py-20 mx-auto" x-data>
            <form id="form-change-thumbnail" action="{{ route('posts.thumbnail.store') }}" method="POST"
                x-ref="formChangeThumbnail" enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="hidden" name="post-id" value="{{ $post->post_id }}">
            </form>
            <form id="form-remove-thumbnail" action="{{ route('posts.thumbnail.destroy') }}" method="POST">
                @csrf
                @method('delete')
                <input type="hidden" name="post-id" value="{{ $post->post_id }}">
            </form>

            <form action="{{ route('posts.store') }}" method="post">
                @csrf
                @method('put')

                <input type="hidden" name="id" value="{{ $post->post_id }}">
                <div class="flex flex-col gap-4 p-6 bg-white dark:bg-zinc-800 rounded-md shadow-sm">
                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="p-2 border rounded-md cursor-pointer bg-rose-50 border-rose-500" id="form-errors"
                            @click="$el.remove()">
                            <ul class="flex flex-col gap-2 text-sm text-rose-500">
                                @foreach ($errors->all() as $error)
                                    <li>&bullet; {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Input post thumbnail --}}
                    <div class="flex flex-col items-center self-center gap-2">
                        <label class="text-xl font-bold dark:text-white" for="post-thumbnail">Thumbnail</label>

                        @if (!is_null($post->post_thumbnail))
                            <div class="flex gap-1">
                                <label
                                    class="flex items-center justify-center w-8 h-8 text-white bg-green-500 rounded-md cursor-pointer"
                                    type="button" title="Change thumbnail" for="post-thumbnail">
                                    <x-icons.pencil />
                                </label>
                                <button
                                    class="flex items-center justify-center w-8 h-8 text-white rounded-md bg-rose-500"
                                    type="submit" title="Remove thumbnail" form="form-remove-thumbnail">
                                    <x-icons.delete />
                                </button>
                            </div>
                        @endif

                        @if (!is_null($post->post_thumbnail))
                            <img class="object-cover w-3/4 max-h-[300px]"
                                src="{{ asset(str_contains($post->post_thumbnail, 'http') ? $post->post_thumbnail : '/storage/' . $post->post_thumbnail) }}" alt="Thumbnail">
                        @else
                            <label
                                class="w-[360px] h-[250px] text-lg flex justify-center items-center cursor-pointer text-zinc-500 bg-zinc-100"
                                for="post-thumbnail">
                                Select image
                            </label>
                        @endif
                        <input class="hidden" type="file" name="thumbnail" x-ref="inputThumbnailEl"
                            accept="image/png, image/jpg, image/jpeg" id="post-thumbnail" form="form-change-thumbnail"
                            @change="() => {
                                document.getElementById('form-change-thumbnail').submit();
                            }">
                    </div>

                    {{-- Input post title --}}
                    <div class="flex flex-col gap-2">
                        <label class="text-xl font-bold dark:text-white" for="post-title">Title</label>
                        <input
                            class="text-xl transition duration-150 ease-in-out bg-white dark:bg-zinc-900 dark:border-zinc-600 dark:text-white rounded-md border-zinc-300 focus:outline-none focus:border-zinc-300 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800"
                            type="text" id="post-title" name="title" autofocus value="{{ $post->post_title }}" maxlength="255">
                    </div>

                    {{-- Input post category --}}
                    <div class="flex flex-col gap-2">
                        <label class="text-xl font-bold dark:text-white" for="post-category">Category</label>
                        <select class="bg-white rounded-md cursor-pointer border-zinc-300 focus:border-zinc-300 dark:bg-zinc-900 dark:border-zinc-600 dark:text-white"
                            name="category" id="post-category">
                            @foreach ($allCategories as $category)
                                <option value="{{ $category->slug }}"
                                    {{ $post->category_slug == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xl font-bold dark:text-white" for="post-tags">
                            Tags
                            <span class="text-sm font-normal text-zinc-400">(Max 5)</span>
                        </label>
                        <x-tags-selector :tags="$allTags" :existing="$existing" id="post-tags" name="tags" />
                    </div>

                    {{-- Input post body --}}
                    <div class="flex flex-col gap-2 dark:text-white">
                        <label class="text-xl font-bold" for="post-body">Content</label>
                        <x-trix-field id="post-body" name="body" value="{!! $postBody->toTrixHtml() !!}" />
                    </div>

                    {{-- Footer --}}
                    <div class="flex items-center justify-end gap-2" x-data="{ postStatus: `{{ $post->post_status }}` }">
                        <input x-model="postStatus" type="hidden" name="status">

                        {{-- Last updated label --}}
                        <div class="flex-grow hidden text-xs text-zinc-400 sm:block">Last updated
                            {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $post->updated_at)->diffForHumans() }}
                        </div>

                        {{-- Input status --}}
                        <x-dropdown width="w-32">
                            <x-slot name="trigger">
                                <button
                                    class="flex items-center gap-2 p-1 px-3 text-sm bg-white dark:bg-zinc-700 dark:text-white border dark:border-none rounded-md border-zinc-300 h-9"
                                    type="button">
                                    <div
                                        x-text="postStatus === 'draft' ? 'Draft' : postStatus === 'archived' ? 'Archive' : 'Publish'">
                                        {{ ($post->post_status == 'draft' ? 'Draft' : $post->post_status == 'archived') ? 'Archive' : 'Publish' }}
                                    </div>
                                    <x-icons.chevron-down class="w-4 h-4" />
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-item
                                    class="py-1 text-xs font-bold text-center uppercase bg-transparent select-none hover:bg-transparent">
                                    SET STATUS
                                </x-dropdown-item>
                                <x-dropdown-button type="button" @click="postStatus = 'published'">
                                    Publish
                                </x-dropdown-button>
                                <x-dropdown-button type="button" @click="postStatus = 'archived'">
                                    Archive
                                </x-dropdown-button>
                                <x-dropdown-button type="button" @click="postStatus = 'draft'">
                                    Draft
                                </x-dropdown-button>
                            </x-slot>
                        </x-dropdown>

                        {{-- Submit button --}}
                        <x-primary-button type="submit">SAVE</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </x-slot>

    <x-slot name="script">

    </x-slot>
</x-root-layout>
