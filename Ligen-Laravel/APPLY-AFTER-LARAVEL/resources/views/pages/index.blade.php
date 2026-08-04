@extends('layouts.app')

@section('title', 'Ligen Power®')
@section('meta_description', 'Ligen Power® - Green and clean energy solutions. Power inverters, BMS, solar, electric cycles.')

@section('content')
<div class="container">
    <p class="lead">Welcome to Ligen Power®. This is the Laravel home page.</p>
    <p>Copy the main content from your original <code>index.html</code> (the section between header and footer) into this Blade file to restore the full homepage.</p>
    <p><a href="{{ route('blog.index') }}">View Blog</a> | <a href="{{ url('electric-cycle') }}">Electric Cycle</a> | <a href="{{ url('contact') }}">Contact</a></p>
</div>
@endsection
