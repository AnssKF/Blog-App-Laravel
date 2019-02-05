<?php


Route::get('/', function () {
    return redirect()->route('postsPage');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


Route::patch('/posts/{post}/update', 'PostsController@update');
Route::get('/posts/{post}/edit', 'PostsController@edit');

Route::get('/posts/{post}', 'PostsController@show');

Route::delete('/posts/{post}', 'PostsController@destroy');
Route::post('/posts', 'PostsController@store');
Route::get('/posts', 'PostsController@index')->name('postsPage');
Route::get('/category/{category}', 'PostsController@showCategory')->name('categoryPage');



Route::post('/comments/{post}','CommentsController@store');

Route::post('/like/{post}','LikeController@store');

Route::post('/subscribe/{post}/post','SubscriptionController@postSubscribe');
Route::post('/subscribe/{category}/category','SubscriptionController@categorySubscribe');


