<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    //comments table in database
    protected $guarded = [];


    public function posts()
    {
        //https://laracasts.com/discuss/channels/general-discussion/laravel-5-problems-with-relations-pivot
        //http://stackoverflow.com/questions/24547376/insert-data-to-a-pivot-table-in-laravel
        return $this->belongsToMany('App\Models\Posts', 'Categories_Posts','category_id','post_id');
    }

}