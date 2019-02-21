<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use SleepingOwl\Admin\Traits\OrderableModel;

class AutoMark extends Eloquent
{
    use OrderableModel;
    protected $table = 'auto_mark';
    protected $fillable = ["name_ru", "models"];


    /**
     * Get order field name.
     * @return string
     */
    public function getOrderField()
    {
        return 'mark_id';
    }


}
