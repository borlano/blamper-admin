<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Baum;
use Lex\Mongotree\TreeTrait;

class Subject extends Eloquent
{
    //use TreeTrait;
    protected $table = 'subject';
//    // 'parent_id' column name
    protected $fillable = ["parent_id", "name", "slug", "id", "is_table"];
    public $timestamps = false;

}
