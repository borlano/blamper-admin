<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 07.02.2019
 * Time: 16:58
 */

namespace App\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController
{
    public function editUser(Request $request,$id){


        $firstname = $request->input("profile.firstname");
        $lastname = $request->input("profile.lastname");
        $email = $request->get("email");


        $user = User::where("_id",$id)->update([
            "profile.firstname" => $firstname,
            "profile.lastname" => $lastname,
            "email" => $email,
        ]);


        return redirect()->back();
    }
}