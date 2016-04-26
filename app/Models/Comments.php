<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //comments table in database
    protected $guarded = [];
    // user who has commented
    public function author()
    {
        return $this->belongsTo('App\Models\User','from_user');
    }
    // returns post of any comment
    public function post()
    {
        return $this->belongsTo('App\Models\Posts','page_id');
    }
}
