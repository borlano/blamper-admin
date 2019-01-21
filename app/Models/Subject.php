<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Baum;
use Lex\Mongotree\TreeTrait;

class Subject extends Eloquent
{
    use TreeTrait;
    protected $table = 'subject';
//    // 'parent_id' column name
    protected $fillable = ["parent_id"];
//
//    // 'lft' column name
//    protected $leftColumn = 'nested_set.left';
//
//    // 'rgt' column name
//    protected $rightColumn = 'nested_set.right';
//
//    // 'depth' column name
//    protected $depthColumn = 'nested_set.level';

}
