<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class am_product extends Model
{
    protected $table='products';
    public function company(){
        return $this->belongsTo('App\am_companies','companyid');
    }
    public function repository(){
        return $this->belongsTo('App\am_repository','repositoryno');
    }
}
