<?php

namespace App\Auth;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
   
    protected $table = 'clients';

    protected $primaryKey = 'id';
}