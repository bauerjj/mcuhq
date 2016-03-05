<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mcus extends Model
{
    //comments table in database
    protected $guarded = [];
    protected $table = 'mcus';

    public function vendor()
    {
        return $this->belongsTo('App\Models\McuVendors','vendor_id');
    }


    public function arch()
    {
        return $this->belongsTo('App\Models\McuArchs','arch_id');
    }

}