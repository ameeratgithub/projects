<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dummy extends Model
{
    protected $table='dummy';
    protected $primaryKey='id';
    public $timestamps=false;
}
