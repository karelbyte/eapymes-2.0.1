<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persons extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
}
