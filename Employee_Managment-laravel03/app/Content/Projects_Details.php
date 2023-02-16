<?php

namespace App\Content;

use Illuminate\Database\Eloquent\Model;

class Projects_Details extends Model
{
    protected $table = 'projects_details';
    
    protected $primaryKey = 'id';

    public function sub_projects_details(){
        return $this->hasMany('App\Content\Sub_Projects_Details' , 'projects_details_id', 'id');
    }
}
