<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Profile extends Eloquent
{
    protected $fillable = ["firstname, lastname"];
    public $timestamps = false;

}
