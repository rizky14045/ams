<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class ItemAdjustmentAktivaTetap extends Model
{

    public $timestamps = false;
    protected $table = 'item_adjustment_aktiva_tetap';

    public function model()
    {
        return $this->hasOne(ModelAktivaTetap::class, 'id', 'id_model');
    }

}
