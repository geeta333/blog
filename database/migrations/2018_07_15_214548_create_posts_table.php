<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            // 画像表示に利用します
            $table->string('filePath');
            // ポストテーブルとカテゴリーテーブルの紐付けに利用します
            $table->string('cat_id'); 
            $table->text('content');
            // 投稿に何件のコメントがついたのかをカウントします
            $table->unsignedInteger('comment_count')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
