<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile_Details extends Model
{
    protected $table = 'profile_details';
    public $timestamps = false;
    protected $guarded = ['id'];
}
