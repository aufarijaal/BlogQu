@props(['link', 'category'])

<a class="category-chip" title="{{ $category->name }}" href="{{ route('post_by_category', ['categorySlug' => $category->slug]) }}">{{ $category->name }}</a>
