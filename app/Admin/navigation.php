<?php

use SleepingOwl\Admin\Navigation\Page;

return [
    (new Page(\App\Models\Publication::class))->setTitle("Публикации")->addBadge(function (){return \App\Models\Publication::count();}),

];