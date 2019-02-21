<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use SleepingOwl\Admin\Traits\OrderableModel;

class AutoMark extends Eloquent
{
    use OrderableModel;
    protected $table = 'auto_mark';
    protected $fillable = [
        "name_ru",
        "models",
        "mark_name",
        "description_url",
        "description",
        "slug",
        "sort",
        "mark_id",
        "manual_desc"
    ];


    /**
     * Get order field name.
     * @return string
     */
    public function getOrderField()
    {
        return 'mark_id';
    }

    public static function getAutoMarks(){
        $models = AutoMark::select("mark_id","mark_name")->where("mark_name", "!=", null)->get()->toArray();
        $modeles = [];
        foreach ($models as $key=>$model)
        {
            $modeles[$model["mark_id"]] = $model["mark_name"];
        }
        return $modeles;
    }


}
