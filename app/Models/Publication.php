<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Publication extends Eloquent
{
    protected $connection = 'mongodb';
    public function extra()
    {
        return $this->embedsOne(Extra::class);
    }

//    function __construct()
//    {
//        $this->extras = $this->extra["source"];
//    }
}
