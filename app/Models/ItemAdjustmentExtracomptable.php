<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class ItemAdjustmentExtracomptable extends Model
{

    public $timestamps = false;
    protected $table = 'item_adjustment_extracomptable';

    public function subjenis()
    {
        return $this->hasOne(SubJenisExtracomptable::class, 'id', 'id_subjenis');
    }

}
