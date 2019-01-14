<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Publication extends Eloquent
{
    protected $connection = 'mongodb';
    protected $fillable = ["title", "status", "type", "id", "removed"];
    protected $dates = ["created","updated"];
    public function extra()
    {
        return $this->embedsOne(Extra::class);
    }

    public function author()
    {
        return $this->embedsOne(User::class);
    }

//    function __construct()
//    {
//        $this->extras = $this->extra["source"];
//    }
}
