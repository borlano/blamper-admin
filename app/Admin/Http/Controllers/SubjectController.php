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
    /**
     * Метод обработки создания рубрики
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createSubject(Request $request){

        $maxId = Subject::max("id");
        $maxId++;
        $is_new = $request->get("is_new"); //новая рубрика?

        $sub = Subject::create([
            "name"      => $request->get("name"),
            "id"        => $maxId,
            "is_table"  => false,
            "parent_id" => 1,
            "slug"      => Str::slug($request->get("name")),
            "path"      => [0 => 1, 1 => $maxId],
            "is_new"    => $is_new ? $is_new : 0,
        ]);

        return redirect()->back();
    }

    /** Метод обработки редактирования рубрики */
    public function editSubject(Request $request,$id){

        $name = $request->get("name");
        $slug = Str::slug($request->get("name"));
        $is_new = $request->get("is_new");

        $user = Subject::where("_id",$id)->update([
            "name" => $name,
            "slug" => $slug,
            "is_new" => $is_new ? $is_new : 0,
        ]);

        return redirect()->back();
    }
}