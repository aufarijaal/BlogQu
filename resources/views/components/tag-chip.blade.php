@props(['link', 'tag'])

<a class="tag-chip" title="{{ $tag->name }}" href="{{ route('post_by_tags.index', ['tagSlug' => $tag->slug]) }}">{{ $tag->name }}</a>
