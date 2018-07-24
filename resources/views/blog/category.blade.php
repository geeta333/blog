@extends('layouts.default')

@section('title', 'カテゴリー')

@section('content')
<div class="card">
    <div class="card-header">カテゴリー追加ページ</div>
    <div class="card-body">
        <form method="post" action="{{ url('/posts/category') }}">
            @csrf
            <div class="form-group">
                <label for="name">カテゴリー名</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="カテゴリー名" minlength="1" maxlength="30" required autofocus>
            </div>

            <div class="text-center">
                <input type="submit" value="投稿" class="btn btn-primary">
                <a href="{{ url('/') }}" class="btn btn-primary mx-4">戻る</a>
            </div>
        </form>
    </div>
</div>

@endsection