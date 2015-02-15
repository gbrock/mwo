@extends('layouts.dashboard', array(
    'breadcrumbs' => 'blog',
))

@section('content')
    <a href="{{ action('Blog\PostController@getCreate') }}" class="btn btn-primary">
        Write New Post
    </a>

    @include('includes.table', array(
        'headers' => $table_headers,
        'rows' => $table_rows,
    ))

@overwrite
