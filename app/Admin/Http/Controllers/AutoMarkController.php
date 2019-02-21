<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 21.02.2019
 * Time: 16:13
 */

namespace App\Admin\Http\Controllers;


use App\Models\AutoMark;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AutoMarkController
{
    /**
     * Свой обработчик создания марки автомобиля
     * @param Request $request
     * @param \Cviebrock\LaravelElasticsearch\Manager $elasticsearch
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAutoMark(Request $request,\Cviebrock\LaravelElasticsearch\Manager $elasticsearch){

        $maxId = AutoMark::max("id");
        $maxId++;
        $name_ru = $request->get("name_ru");
        $name_en = $request->get("mark_name");
        $description_url = $request->get("description_url");
        $description = $request->get("description");
        $models = $request->get("models");

        //ид моделей приходят в виде строки, конвертим в инт
        foreach ($models as $key=>$model) {
            $models[$key] = (int)$model;
        }

        //dd($models);

        $auto_mark = AutoMark::create([
            "mark_id" => $maxId,
           "name_ru" => $name_ru,
           "mark_name" => $name_en,
           "slug" => Str::slug($name_ru),
           "description_url" => $description_url,
           "description" => $description,
           "models" => $models,
            "sort" => 100,
            "manual_desc" => false,
        ]);

        return redirect("/auto_marks/$auto_mark->_id/edit");
    }

    public function editAutoMark(Request $request,\Cviebrock\LaravelElasticsearch\Manager $elasticsearch, $id){

        return redirect()->back();
    }
}