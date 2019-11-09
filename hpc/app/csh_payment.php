<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class csh_payment extends Model
{
    protected $table='payments';
    protected $primaryKey='id';
    public function customer(){
        return $this->belongsTo('App\am_customer','customerid');
    }
}
