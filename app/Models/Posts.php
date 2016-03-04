<?php

namespace App\Models;

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
        return $this->hasMany('App\Models\Comments','on_post');
    }

    public function categories()
    {
        //https://laracasts.com/discuss/channels/general-discussion/laravel-5-problems-with-relations-pivot
        //http://stackoverflow.com/questions/24547376/insert-data-to-a-pivot-table-in-laravel
        return $this->belongsToMany('App\Models\Categories', 'Categories_Posts','post_id','category_id');
    }

    // returns the instance of the user who is author of that post
    public function author()
    {
        return $this->belongsTo('App\Models\User','author_id');
    }
}
