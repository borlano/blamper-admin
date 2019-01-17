<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Extra extends Eloquent
{
    protected $fillable = ["source"];
    protected $hidden = ["_id"];
    public $timestamps = false;

}
