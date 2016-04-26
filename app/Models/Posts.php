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
        return $this->hasMany('App\Models\Comments','page_id')->where('status','=','approved');
    }

    public function categories()
    {
        //https://laracasts.com/discuss/channels/general-discussion/laravel-5-problems-with-relations-pivot
        //http://stackoverflow.com/questions/24547376/insert-data-to-a-pivot-table-in-laravel
        return $this->belongsToMany('App\Models\Categories', 'categories_posts','post_id','category_id');
    }

    public function mcu()
    {
        return $this->belongsTo('App\Models\Mcus','mcu_id');
    }

    public function compiler()
    {
        return $this->belongsTo('App\Models\McuCompilers','compiler_id');
    }

    public function languages()
    {
        return $this->belongsToMany('App\Models\McuLanguages', 'mcu_languages_posts','post_id','language_id');
    }

    // returns the instance of the user who is author of that post
    public function author()
    {
        return $this->belongsTo('App\Models\User','author_id');
    }
}
