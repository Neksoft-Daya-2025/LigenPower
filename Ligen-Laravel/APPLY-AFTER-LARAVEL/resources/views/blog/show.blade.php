@extends('layouts.app')

@section('title', ($post['title'] ?? 'Post') . ' - Ligen Power®')
@section('meta_description', $post['meta_description'] ?? $post['excerpt'] ?? '')

@push('meta')
@if(!empty($post['meta_description']))
<meta name="description" content="{{ $post['meta_description'] }}">
@endif
<meta property="og:title" content="{{ $post['title'] ?? '' }}">
<meta property="og:description" content="{{ $post['meta_description'] ?? $post['excerpt'] ?? '' }}">
@if(!empty($post['image']))
<meta property="og:image" content="{{ asset($post['image']) }}">
@endif
@endsection

@section('content')
<article class="blog-single container">
    @if(!empty($post['image']))
        <figure>
            <img src="{{ $post['image'] }}" alt="{{ $post['title'] ?? '' }}" />
        </figure>
    @endif
    <header>
        <h1>{{ $post['title'] ?? 'Untitled' }}</h1>
        <p>By {{ $post['author'] ?? 'Ligen Power®' }} · {{ $post['date'] ?? '' }}</p>
    </header>
    <div class="blog-body">
        {!! $post['content'] ?? '' !!}
    </div>
</article>
@endsection
