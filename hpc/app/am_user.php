<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
class am_user extends Authenticatable
{
    protected $table="users";
    protected $primaryKey="id";


}
