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

use App\Models\Posts;
use \Illuminate\Support\Facades\DB;

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

// Every request will enter this function which populates the navbar
// MAKE SURE THE VARIABLE NAMES DON'T INTERFERE WITH EXISTING ONES
// FROM THE VIEWS!!!
View::composer('*', function($view) {
    $categories = Db::table("categories")->orderby('name','asc')->get();
    $tags = Db::table('tagging_tags')->orderby('count','desc')->get();
    $recentPosts = Db::table('posts')->where('active', 1)->orderby('created_at', 'desc')->limit(8)->get();
    $view->with(array('categoriesNavBar'=>$categories, 'tagsNavBar'=>$tags, 'recentPostsSidebar'=>$recentPosts));
});

Route::group(['middleware' =>  ['web','ViewThrottle']], function () {
    Route::get('/','PostController@index');
    Route::get('/blog', 'HomeController@blog');
    Route::get('/about','PostController@about');

    Route::get('/blog','BlogController@index');
    Route::get('/new-blog','BlogController@create');
    Route::post('/new-blog','BlogController@store');
    Route::get('/blog/{id}/{slug}',['as' => 'blog', 'uses' => 'BlogController@show'])->where(['id' => '[0-9]+', 'slug' => '[A-Za-z0-9-_]+']);
    Route::get('/blog/edit/{id}/{slug}','BlogController@edit');
    Route::post('/blog/update','BlogController@update');
    Route::post('/blog/delete/{id}','BlogController@destroy');

    Route::get('/search','FilterController@search');
    Route::get('/vendors/{vendor}','FilterController@vendor')->where('vendor','[A-Za-z0-9-_]+');
    Route::get('/tags/{tag}','FilterController@tag')->where('tag','[A-Za-z0-9-_]+');
    Route::get('/categories/{category}','FilterController@category')->where('category','[A-Za-z0-9-_]+');

    Route::get('/home',['as' => 'home', 'uses' => 'PostController@index']);
    Route::post('upload-image','PostController@image_upload');

    // display single post
    Route::get('{id}/{slug}',['as' => 'post', 'uses' => 'PostController@show'])->where(['id' => '[0-9]+', 'slug' => '[A-Za-z0-9-_]+']);
    // display list of posts
    Route::get('user/{id}/posts','UserController@user_posts')->where('id', '[0-9]+');
    //users profile
    Route::get('user/{id}/{username}','UserController@profile')->where('id', '[0-9]+'); // username is wildcard
    Route::get('user/{id}','UserController@profile')->where('id', '[0-9]+'); // username is wildcard

    Route::get('sitemap', function(){

        // create new sitemap object
        $sitemap = App::make("sitemap");

        // add items to the sitemap (url, date, priority, freq)
        $sitemap->add(URL::to('about'), '2016-03-26T12:30:00+02:00', '0.1', 'yearly');

        // get all posts from db
        $posts = DB::table('posts')->orderBy('created_at', 'desc')->get();
        $categories = DB::table('categories')->get();
        $tags = Posts::existingTags();
        $vendors = DB::table('mcu_vendors')->get();

        // add every post to the sitemap
        foreach ($posts as $post)
        {
            $sitemap->add(url($post->id .'/'.$post->slug), $post->created_at, 0.99, 'weekly');
        }

        $blogs = DB::table('blog')->orderBy('created_at', 'desc')->get();
        foreach ($blogs as $blog)
        {
            $sitemap->add(url('/blog/'.$blog->id .'/'.$blog->slug), $blog->created_at, 0.99, 'weekly');
        }

        foreach ($vendors as $vendor)
        {
            $sitemap->add(url('vendors/'.$vendor->slug), $vendor->created_at, 0.8, 'weekly');
        }


        foreach ($tags as $tag)
        {
            $sitemap->add(url('tags/'.$tag->slug), '2016-03-26T12:30:00+02:00', 0.7, 'weekly');
        }

        foreach ($categories as $category)
        {
            $sitemap->add(url('categories/'.$category->slug), $category->created_at, 0.2, 'weekly');
        }





        // generate your sitemap (format, filename)
        $sitemap->store('xml', 'sitemap');
        // this will generate file sitemap.xml to your public folder

        echo 'Created Sitemap Successfully!';

    });
});