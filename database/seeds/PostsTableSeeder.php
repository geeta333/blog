<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Comment;
use App\Category;
use App\User;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//         DB::table('users')->delete();
//         DB::table('posts')->delete();
//         DB::table('comments')->delete();
//         DB::table('categories')->delete();
        
        $content = 'この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。';
        
        $filePath = '/images/illust814.png';

//        $commentdammy = 'コメントダミーです。ダミーコメントだよ。';

        //12個の記事の作成
        for( $i = 1 ; $i <= 12 ; $i++) {
            $post = new Post;
            $post->title = "$i 番目の投稿";
            $post->filePath = $filePath;
            $post->content = $content;
            $post->cat_id = 1;
            $post->save();

            //記事にコメントを3～15付ける
            $maxComments = mt_rand(3, 15);
            for ($j=1; $j <= $maxComments; $j++) {
                $comment = new Comment;
                $comment->commenter = '名無しさん';
                $comment->comment = "$j 番目のコメント";

                // モデル(Post.php)のCommentsメソッドを読み込み、post_idにデータを保存する
                $post->comments()->save($comment);
                $post->increment('comment_count');
            }
            sleep(1);
        }

        // カテゴリーを追加する
        $cat1 = new Category;
        $cat1->name = "動物";
        $cat1->save();

        $cat2 = new Category;
        $cat2->name = "食品";
        $cat2->save();
        
        //ユーザーを追加する
        $user = new User;
        $user->name = 'admin';
        $user->email = 'admin@yahoo.co.jp';
        $user->password = bcrypt('admin');
        $user->save();

    }
}
