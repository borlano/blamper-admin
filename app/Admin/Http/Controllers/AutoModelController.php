<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 21.02.2019
 * Time: 17:23
 */

namespace App\Admin\Http\Controllers;


use Illuminate\Http\Request;

class AutoModelController
{
    public function createAutoModel(Request $request,\Cviebrock\LaravelElasticsearch\Manager $elasticsearch){
        return redirect()->back();
    }

    public function editAutoModel(Request $request,\Cviebrock\LaravelElasticsearch\Manager $elasticsearch){
        return redirect()->back();
    }
}