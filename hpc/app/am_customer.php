<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class am_customer extends Model
{
    protected $table='customers';
    protected $primaryKey='id';
    public function payments(){
        return $this->hasMany('App\am_payment','customerid');
    }
}
