<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class am_stockindetail extends Model
{
    protected $table='stockindetails';
    protected $primaryKey='id';
    public $timestamps=false;
    public function stockin(){
        return $this->belongsTo('App\am_stockin','stockinid');
    }
}
