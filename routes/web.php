<?php


Route::get('/', function () {
    return redirect()->route('postsPage');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile','ProfileController@index')->name('profile');
Route::post('/profile','ProfileController@store');


Route::patch('/posts/{post}/update', 'PostsController@update');
Route::get('/posts/{post}/edit', 'PostsController@edit');

Route::get('/posts/{post}', 'PostsController@show');

Route::delete('/posts/{post}', 'PostsController@destroy');
Route::post('/posts', 'PostsController@store');
Route::get('/posts', 'PostsController@index')->name('postsPage');
Route::get('/category/{category}', 'PostsController@showCategory')->name('categoryPage');



Route::post('/comments/{post}','CommentsController@store');
Route::get('/comments/{post}','CommentsController@getMoreComments');

Route::post('/like/{post}','LikeController@store');
Route::delete('/like/{post}','LikeController@destroy');

Route::post('/subscribe/{post}/post','SubscriptionController@postSubscribe');
Route::delete('/subscribe/{post}/post','SubscriptionController@postUnSubscribe');

Route::post('/subscribe/{category}/category','SubscriptionController@categorySubscribe');
Route::delete('/subscribe/{category}/category','SubscriptionController@categoryUnSubscribe');

Route::get('/test','PostsController@test');


