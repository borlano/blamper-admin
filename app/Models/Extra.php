<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Extra extends Eloquent
{
    protected $fillable = ["source"];
    public $timestamps = false;

}
