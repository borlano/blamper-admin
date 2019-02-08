<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 27.12.2018
 * Time: 16:46
 */

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
class User extends Eloquent implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    protected $connection = 'mongodb';
    protected $dates = ["created","updated"];
    protected $fillable = [
        "id",
        "avatar",
        "lastname",
        "firstname",
        'email',
        'password',
        "user_id",
        "qa_role", //роль на форуме
    ];

    public $qa_roles = [0 => "Новичок", "expert" => "Эксперт", "profi" => "Профи","parts" => "Подбор запчастей"];

    public $timestamps = false;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', '_id'
    ];

    public function profile()
    {
        return $this->embedsOne(Profile::class);
    }
}