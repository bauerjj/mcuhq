<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategories extends Model
{
    //comments table in database
    protected $guarded = [];
    protected $table = 'categories_blog';


    public function blogs()
    {
        //https://laracasts.com/discuss/channels/general-discussion/laravel-5-problems-with-relations-pivot
        //http://stackoverflow.com/questions/24547376/insert-data-to-a-pivot-table-in-laravel
        return $this->belongsToMany('App\Models\Blog', 'Categories_Blog_Pivot','category_id','blog_id');
    }

}