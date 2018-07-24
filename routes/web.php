<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PostsController@index');
Route::get('/posts/{post}', 'PostsController@show')->where('post', '[0-9]+');
Route::post('/posts/comment', 'PostsController@comment');
Route::group(['middleware' => 'auth'], function() {
    Route::get('/posts/create', 'PostsController@create');
    Route::post('/posts', 'PostsController@store');
    Route::get('/posts/category/make', function() {return view('blog.category');});
    Route::post('/posts/category', 'PostsController@category');
    Route::get('/posts/{post}/edit', 'PostsController@edit');
    Route::patch('/posts/{post}', 'PostsController@update');
    Route::delete('/posts/{post}', 'PostsController@delete');
});
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
