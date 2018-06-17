@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{!! $category->name !!}</h1>

        {!! $category->description !!}

        @foreach($category->posts as $post)
            @include('blog._post_thumb', ['post' => $post])
        @endforeach
    </div>
@endsection