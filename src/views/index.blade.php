@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Blog</h1>

        @foreach($posts as $post)
            @include('wordpress-to-laravel::_post_thumb', ['post' => $post])
        @endforeach
    </div>
@endsection