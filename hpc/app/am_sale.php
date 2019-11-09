<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class am_sale extends Model
{
    protected $table='sales';
    protected $primaryKey='id';
    public function oncredit(){
        return $this->hasOne('App\am_saleoncredit','invoiceid');
    }
    public function saleDetails(){
        return $this->hasMany('App\am_saledetail','saleid');
    }
}
