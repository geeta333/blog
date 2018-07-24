@extends('layouts.default')

{{--
@section('title')
Blog Posts
@endsection
--}}

@section('title', 'Blog')

@section('content')

<div class="col-md-12">
    <h1>
        ブログ
        @if (Auth::check())
            <span class="small-menu">
                <a href="{{ action('PostsController@create') }}">記事の作成</a>
            </span>
            <span class="small-menu">
                <a href="{{ url('/posts/category/make') }}">カテゴリー追加</a>
            </span>
        @endif
    </h1>
    <hr />

    @foreach($posts as $post)

        <h2>タイトル：{{ $post->title }}</h2>
        <small>投稿日：{{ date("Y年 m月 d日",strtotime($post->created_at)) }}</small>

        <p>カテゴリー：{{ $post->category->name }}</p>
        @if(app('env')=='local')
        <p><img src="{{ asset($post->filePath) }}" class="image"></p>
        @endif
        @if(app('env')=='production')
        <p><img src="{{ secure_asset($post->filePath)}}"></p>
        @endif
<!--        <p>{{ $post->content }}</p>-->
        <p>{{ str_limit($post->content, 100) }}</p>
        <p>
            <a href="{{ action('PostsController@show', $post) }}" class="btn btn-primary">続きを読む</a>
        </p>
        <p>コメント数：{{ $post->comment_count }}</p>
        @if (Auth::check())
            <p>
                <a href="{{ action('PostsController@edit', $post) }}">記事の編集</a>
                <a href="#" class="mx-4 del" data-id="{{ $post->id }}">記事の削除</a>
            </p>
            <form method="post" action="{{ url('/posts', $post->id) }}" id="form_{{ $post->id }}">
                @csrf
                {{ method_field('delete') }}
            </form>
        @endif
        <hr />
    @endforeach
    {{ $posts->links() }}
</div>

@endsection