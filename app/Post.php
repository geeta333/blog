<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    
    protected $fillable = ['title', 'content', 'cat_id'];
    
	public function Comments(){
		// 投稿はたくさんのコメントを持つ
		return $this->hasMany('App\Comment', 'post_id');
	}
    
	public function Category(){
		// 投稿は1つのカテゴリーに属する
		return $this->belongsTo('App\Category','cat_id');
	}
}
