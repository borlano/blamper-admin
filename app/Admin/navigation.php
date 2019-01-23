<?php

use SleepingOwl\Admin\Navigation\Page;

return [
    (new Page(\App\Models\Publication::class))->setTitle("Публикации")->addBadge(function (){return \App\Models\Publication::count();}),
    (new Page(\App\Models\User::class))->addBadge(function (){return \App\Models\User::count();}),
    (new Page(\App\Models\AutoMark::class))->addBadge(function (){return \App\Models\AutoMark::count();}),
    (new Page(\App\Models\AutoModel::class))->addBadge(function (){return \App\Models\AutoModel::count();}),
    (new Page(\App\Models\Subject::class))->addBadge(function (){return \App\Models\Subject::count();}),

];