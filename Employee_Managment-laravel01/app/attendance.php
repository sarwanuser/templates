<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    
    // protected $fillable = [
    //     'id', 'first_name', 'last_name', 'emp_code',
    // ];
    
    protected $table = 'attendances';

    protected $primaryKey = 'id';
}
