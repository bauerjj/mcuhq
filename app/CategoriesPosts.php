<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriesPosts extends Model
{
    //comments table in database
    protected $guarded = [];


    public function category()
    {
        return $this->belongsTo('App\Categories','category_id');
    }

}