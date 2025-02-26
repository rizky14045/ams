<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class ItemRequestAktivaTetap extends Model
{
    public $timestamps = false;
    protected $table = 'item_request_aktiva_tetap';

    public function model()
    {
        return $this->hasOne(ModelAktivaTetap::class, 'id', 'id_model');
    }

}
