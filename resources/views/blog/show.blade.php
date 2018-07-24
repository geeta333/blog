@extends('layouts.default')

@section('title', $post->title)

@section('content')
<div class="col-md-12">
    <h2>
        {{ $post->title }}
        <span class="small-menu">
            <a href="{{ url('/') }}">戻る</a>
        </span>
    </h2>
    <p>投稿日：{{ date("Y年 m月 d日",strtotime($post->created_at)) }}</p>
    <p>カテゴリー：{{ $post->category->name }}</p>
    <p><img src="{{ asset($post->filePath) }}"></p>
    <p>{!! nl2br(e($post->content)) !!}</p>

    <hr />

    <section>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="#comments" class="nav-link active" data-toggle="tab"><h3>コメント一覧</h3></a>
            </li>
            <li class="nav-item">
                <a href="#comment-create" class="nav-link" data-toggle="tab"><h3>コメントする</h3></a>
            </li>
        </ul>
        <div class="tab-content py-5">
            <div id="comments" class="tab-pane active">
                @forelse($comments as $comment)
                    <h4>{{ $comment->commenter }}</h4>
                    <p>{{ $comment->comment }}</p><br />
                @empty
                    <p>コメントはありません。</p><br />
                @endforelse
            </div>
            
            <div id="comment-create" class="tab-pane">
                <form method="post" action="{{ url('/posts/comment') }}">
                    @csrf
                    <div class="form-group">
                        <label for="commenter">名前</label>
                        <input id="commenter" type="text" class="form-control" name="commenter" value="名無しさん" placeholder="名前" minlength="1" maxlength="20" required>
                    </div>
                    <div class="form-group">
                        <label for="comment">コメント</label>
                        <textarea name="comment" placeholder="コメント" class="form-control" id="comment" rows="3" required autofocus>{{ old('content') }}</textarea>

                        @if ($errors->has('content'))
                            <span class="error">{{ $errors->first('content') }}</span>
                        @endif

                    </div>
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <div class="text-center">
                        <input type="submit" value="書き込む" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

@endsection