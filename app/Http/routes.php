<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


// check for logged in user
Route::group(['middleware' => ['web','ViewThrottle']], function()
{

    // show new post form
    Route::get('new-post','PostController@create');
    // save new post
    Route::post('new-post','PostController@store');
    // edit post form
    Route::get('edit/{id}/{slug}','PostController@edit');
    // update post
    Route::post('update','PostController@update');
    // delete post
    Route::get('delete/{id}','PostController@destroy');
    // display user's all posts
    Route::get('my-all-posts','UserController@user_posts_all');
    // display user's drafts
    Route::get('my-drafts','UserController@user_posts_draft');
    // add comment
    Route::post('comment/add','CommentController@store');
    // delete comment
    Route::post('comment/delete/{id}','CommentController@distroy');


});

Route::group(['middleware' =>  ['web','ViewThrottle']], function () {
    Route::auth();


    Route::get('/','PostController@index');
    Route::get('/blog', 'HomeController@blog');
    Route::get('/about','PostController@about');

    Route::get('/vendors/{vendor}','FilterController@vendor')->where('vendor','[A-Za-z0-9-_]+');
    Route::get('/category/{category}','FilterController@category')->where('category','[A-Za-z0-9-_]+');

    Route::get('/home',['as' => 'home', 'uses' => 'PostController@index']);
    Route::post('upload-image','PostController@image_upload');

    // display single post
    Route::get('{id}/{slug}',['as' => 'post', 'uses' => 'PostController@show'])->where(['id' => '[0-9]+', 'slug' => '[A-Za-z0-9-_]+']);
    //users profile
    Route::get('user/{id}','UserController@profile')->where('id', '[0-9]+');
    // display list of posts
    Route::get('user/{id}/posts','UserController@user_posts')->where('id', '[0-9]+');
});