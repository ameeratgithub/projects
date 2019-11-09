<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class am_biltihistory extends Model
{
    protected $table='biltihistory';
    protected $primaryKey='number';
    public function sale(){
        return $this->belongsTo('App\am_sale','invoiceid');
    }
}
