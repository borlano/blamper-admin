<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Publication extends Eloquent
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    protected $connection = 'mongodb';
    protected $fillable = ["title", "status", "type", "id", "removed","block_body", "short_body", "tags","answers", "subjects"];
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
