<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AutoModel extends Eloquent
{
    protected $table = 'auto_model';

    public function mark(){
        return $this->belongsTo(AutoMark::class,"mark_id","mark_id");
    }
}
