<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McuLanguages extends Model
{
    //comments table in database
    protected $guarded = [];
    protected $table = 'mcu_languages';

    public function languages()
    {
        //https://laracasts.com/discuss/channels/general-discussion/laravel-5-problems-with-relations-pivot
        //http://stackoverflow.com/questions/24547376/insert-data-to-a-pivot-table-in-laravel
        return $this->belongsToMany('App\Models\Posts', 'mcu_languages_posts','language_id','post_id');
    }

}