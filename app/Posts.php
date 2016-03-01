<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Conner\Tagging\Taggable;


class Posts extends Model
{
    use \Conner\Tagging\Taggable;

    //restricts columns from modifying
    protected $guarded = [];
    // posts has many comments
    // returns all comments on that post
    public function comments()
    {
        return $this->hasMany('App\Comments','on_post');
    }

    public function categories()
    {
        //return $this->hasMany('App\CategoriesPosts','post_id');
        //https://laravel.com/docs/5.1/eloquent-relationships#one-to-one
        return $this->hasManyThrough('App\Categories', 'App\CategoriesPosts','post_id','id');
    }

    // returns the instance of the user who is author of that post
    public function author()
    {
        return $this->belongsTo('App\User','author_id');
    }
}
