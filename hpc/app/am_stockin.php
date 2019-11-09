<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class am_stockin extends Model
{
    protected $table='stockin';
    protected $primaryKey='id';
    public function details(){
        return $this->hasMany('App\am_stockindetail','stockinid');
    }
}
