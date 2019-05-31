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
    /**
     * Свой обработчик редактирования юзера
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editUser(Request $request,$id){


        $firstname  = $request->input("profile.firstname");
        $lastname   = $request->input("profile.lastname");
        $email      = $request->get("email");
        $qa_role    = $request->get("qa_role");
        $admin_role    = $request->get("adminRole");


        $user = User::where("_id",$id)->update([
            "profile.firstname" => $firstname,
            "profile.lastname"  => $lastname,
            "email"             => $email,
            "qa_role"           => $qa_role,
            "adminRole"         => $admin_role,
        ]);


        return redirect()->back();
    }

    public function blockUser(Request $request){
        User::where("_id",$request->id)->update([
            "block" => 1
        ]);
        return redirect()->back();
    }

    public function unblockUser(Request $request){
        User::where("_id",$request->id)->update([
            "block" => 0
        ]);
        return redirect()->back();
    }
}