<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class am_saleoncredit extends Model
{
    protected $table='salesoncredit';
    protected $primaryKey='id';
    public $timestamps=false;
    public function customer(){
        return $this->belongsTo('App\am_customer','customerid');
    }
}
