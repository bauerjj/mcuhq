<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McuCompilers extends Model
{
    //comments table in database
    protected $guarded = [];
    protected $table = 'mcu_compilers';

    public function vendor()
    {
        return $this->belongsTo('App\Models\McuVendors','vendor_id');
    }


}