<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Comment;
use App\Http\Requests\PostRequest;
use Intervention\Image\ImageManagerStatic as Image;

class PostsController extends Controller
{
    //indexページを表示する
    public function index() {
        $posts = Post::latest()->paginate(5);
        return view('blog.index')->with('posts', $posts);
    }
    
    //記事の詳細ページを表示する
    public function show(Post $post) {
        $comments = Comment::where('post_id', '=', $post->id)
            ->orderBy('id', 'desc')->get();
        return view('blog.show')->with([
            'post' => $post,
            'comments' => $comments,
        ]);
    }
    
    //コメントの作成を行い記事の詳細ページに戻る
    public function comment(Request $request) {
        $this->validate($request, [
            'post_id' => 'required',
            'commenter' => 'required|min:1',
            'comment' => 'required'
        ]);
        
        $comment = new Comment();
        $comment->post_id = $request->post_id;
        $comment->commenter = $request->commenter;
        $comment->comment = $request->comment;
        $comment->save();
        
        $post = Post::find($request->post_id);
        $post->increment('comment_count', 1);
            
        return back()->withInput();
    }
    
    //記事の作成ページを表示する
    public function create() {
        $categories = Category::all();
        return view('blog.create')->with('categories', $categories);
    }
    
    //記事の作成を行いindexページに戻る
    public function store(PostRequest $request) {
        
        if($request->file('file')->isValid()) {
            //ファイル名ランダム化
            $fileName = str_random(20).$request->file('file')->getClientOriginalName();
//            dd($fileName);
            //ファイルを取得
            $image = Image::make($request->file('file'));
            //ファイルをリサイズして保存
            $image->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path() . '/images/' .$fileName);
            
//            $str = mb_convert_encoding($request->title, "UTF-8");
//            echo $request->title;exit; 
            
            $post = new Post();
            $post->title = $request->title;
            $post->content = $request->content;
            $post->cat_id = $request->cat_id;
            $post->filePath = '/images/'.$fileName;
            $post->save();
            return redirect('/');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['file' => '画像がアップロードされていないか不正なデータです。']);
        }
    }
    
    //カテゴリーの作成を行いindexページに戻る
    public function category(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:1'
        ]);
        
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return redirect('/');
    }
    
    //編集ページを表示する
    public function edit(Post $post) {
        $categories = Category::all();
        return view('blog.edit')->with([
            'post' => $post,
            'categories' => $categories,
        ]);
    }
    
    //記事の編集を行いindexページに戻る
    public function update(PostRequest $request, Post $post) {
        
        if($request->file('file')->isValid()) {
            //ファイル名ランダム化
            $fileName = str_random(20).$request->file('file')->getClientOriginalName();
//            dd($fileName);
            //ファイルを取得
            $image = Image::make($request->file('file'));
            //ファイルをリサイズして保存
            $image->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path() . '/images/' .$fileName);
            
            $post->title = $request->title;
            $post->content = $request->content;
            $post->cat_id = $request->cat_id;
            $post->filePath = '/images/'.$fileName;
            $post->save();
            return redirect('/');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['file' => '画像がアップロードされていないか不正なデータです。']);
        }
    }
    
    public function delete(Post $post) {
        $post->delete();
        return redirect('/');
    }
}
