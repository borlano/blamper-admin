<?php

use SleepingOwl\Admin\Navigation\Page;

return [
    (new Page(\App\Models\Publication::class))->setTitle("Публикации")->addBadge(function (){return \App\Models\Publication::count();}),
    (new Page(\App\Models\User::class))->addBadge(function (){return \App\Models\User::count();}),

];