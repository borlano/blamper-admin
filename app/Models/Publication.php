<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Publication extends Eloquent
{
    protected $connection = 'mongodb';

}
