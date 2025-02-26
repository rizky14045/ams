<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelAktivaTetap extends Model
{
    use SoftDeletes;

    protected $table = 'model_aktiva_tetap';

    public function list_assets()
    {
        return $this->hasMany(AssetAktivaTetap::class, 'id_model', 'id');
    }
}
