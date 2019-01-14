<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 27.12.2018
 * Time: 16:46
 */

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class User extends Eloquent
{
    protected $fillable = ["id", "avatar", "lastname", "firstname", "user_id"];
}