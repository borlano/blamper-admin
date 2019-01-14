<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 09.01.2019
 * Time: 11:59
 */

namespace App\Admin\Http\Controllers;


use App\Models\Publication;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicationController
{
    public function createPublication(Request $request){
        $maxId = Publication::where("type", 5)->where("status", 1)->max("id");
        $maxId++;
        //dd($maxId);
        $pub = Publication::create([
            "title" => $request->get("title"),
            "status" => (float)$request->get("status"),
            "type" => (int)$request->get("type"),
            "id" => $maxId,
            "short_body" => "",
            "created" => Carbon::now(),
            "updated" => Carbon::now(),
            "removed" => 0
        ]);
        $extra = $pub->extra;
        $res = $request->get("extra");
        $pub->author()->create([
            "id" => 1,
            "user_id" => "52244c5419ecc27f043c16f8",
            "avatar" => null,
            "firstname" => "Редакция",
            "lastname" => "Blamper"
        ]);
        $pub->extra()->create(["source" => $res["source"]]);
        return redirect()->back();
    }
}