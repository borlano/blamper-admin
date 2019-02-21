<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AutoModel extends Eloquent
{
    protected $table = 'auto_model';

    public function mark(){
        return $this->belongsTo(AutoMark::class,"mark_id","mark_id");
    }

    /**
     *Вытащить массив моделей автомобилей для мультиселекта
     * @return array
     */
    public static function getAutoModels(){
        $models = AutoModel::select("model_id","model_name")->get()->toArray();
        $modeles = [];
        foreach ($models as $key=>$model)
        {
            $modeles[$model["model_id"]] = $model["model_name"];
        }
        return $modeles;
    }
}
