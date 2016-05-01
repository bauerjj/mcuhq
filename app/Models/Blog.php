<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

//use Conner\Tagging\Taggable;


class Blog extends Model
{
    protected $guarded = [];
    protected $table = 'blog';

    use \Conner\Tagging\Taggable;


    public function categories()
    {
        //https://laracasts.com/discuss/channels/general-discussion/laravel-5-problems-with-relations-pivot
        //http://stackoverflow.com/questions/24547376/insert-data-to-a-pivot-table-in-laravel
        return $this->belongsToMany('App\Models\BlogCategories', 'categories_blog_pivot','blog_id','category_id');
    }

    public function commentsCount(){
        $result =  DB::select(DB::raw("(SELECT count(*) as comments_count FROM comments WHERE page_id = ($this->id + 900000) AND comments.status = 'approved')"));
        return $result[0]->comments_count;
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User','author_id');
    }
}
