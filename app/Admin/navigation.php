<?php

use SleepingOwl\Admin\Navigation\Page;

return [
    (new Page(\App\Models\Publication::class))->setTitle("Публикации")->addBadge(function (){return \App\Models\Publication::where("type",5)->count();}),
    (new Page(\App\Models\User::class))->addBadge(function (){return \App\Models\User::count();}),
    (new Page(\App\Models\AutoMark::class))->addBadge(function (){return \App\Models\AutoMark::count();}),
    (new Page(\App\Models\AutoModel::class))->addBadge(function (){return \App\Models\AutoModel::count();}),
    (new Page(\App\Models\Subject::class))->addBadge(function (){return \App\Models\Subject::where("parent_id",1)->orWhere("id", "=",127)->where("is_table", false)->count();}),

];