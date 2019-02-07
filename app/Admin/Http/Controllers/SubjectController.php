<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 22.01.2019
 * Time: 17:13
 */

namespace App\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
    public function createSubject(Request $request){

        $maxId = Subject::max("id");
        $maxId++;

        $sub = Subject::create([
            "name" => $request->get("name"),
            "id" => $maxId,
            "is_table" => false,
            "parent_id" => 1,
            "slug" => Str::slug($request->get("name")),
            "path" => [0 => 1, 1 => $maxId]
        ]);

        return redirect()->back();
    }
}