<?php

namespace App\Auth;

use Illuminate\Database\Eloquent\Model;

class WeeklyRating extends Model
{
    protected $table = 'weekly_ratings';

    protected $primaryKey = 'id';
}
