<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Extra extends Eloquent
{
    protected $fillable = ["source", "cover", "cover_basename"];
    public $timestamps = false;

}
