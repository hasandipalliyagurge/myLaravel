@extends('layouts.app')

@section('title', 'Blog posts')

@section('content')

@forelse($posts as $id => $post)
    @include('posts.partials.post', [])
@empty
<h1>No posts found!</h1>
@endforelse


@endsection