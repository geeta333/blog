@extends('layouts.default')

@section('title', '投稿ページ')

@section('content')
<div class="card">
    <div class="card-header">投稿ページ</div>
    <div class="card-body">
        <form method="post" action="{{ url('/posts') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                @if ($errors->has('file'))
                    <span class="error">{{ $errors->first('file') }}</span>
                @endif
                <label for="file">画像</label>
                <input id="file" type="file" class="form-control-file" name="file">
            </div>
            <div class="form-group">
                <label for="title">タイトル</label>
                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="タイトル" minlength="3" maxlength="30" required autofocus>
            </div>
            <div class="form-group">
                <label for="cat_id">カテゴリー</label>
                <select class="form-control" id="cat_id" name="cat_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="content">記事詳細</label>
                <textarea name="content" class="form-control" id="content" rows="5" cols="100" placeholder="記事詳細" required>{{ old('content') }}</textarea>
                @if ($errors->has('content'))
                    <span class="error">{{ $errors->first('content') }}</span>
                @endif
            </div>
            
            <div class="text-center">
                <input type="submit" value="投稿" class="btn btn-primary">
                <a href="{{ url('/') }}" class="btn btn-primary mx-4">戻る</a>
            </div>
        </form>
    </div>
</div>

@endsection