@extends('layouts.app')

@section('title', 'Blog - Ligen Power®')
@section('meta_description', 'Ligen Power® blog - news, guides, and updates.')

@section('content')
<div class="blog-content container">
    <h1>Blog</h1>
    <div class="blog-grid">
        @forelse($posts as $post)
            <article class="blog-card">
                <a href="{{ route('blog.show', $post['slug']) }}">
                    @if(!empty($post['image']))
                        <img src="{{ $post['image'] }}" alt="{{ $post['title'] ?? '' }}" />
                    @endif
                    <h2>{{ $post['title'] ?? 'Untitled' }}</h2>
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($post['excerpt'] ?? $post['content'] ?? ''), 120) }}</p>
                    <time>{{ $post['date'] ?? '' }}</time>
                </a>
            </article>
        @empty
            <p>No posts yet.</p>
        @endforelse
    </div>
</div>
@endsection
