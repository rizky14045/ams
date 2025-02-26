<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class ItemPemeliharaanAktivaTetap extends Model
{
    protected $table = 'item_pemeliharaan_aktiva_tetap';

    public function asset()
    {
        return $this->hasOne(AssetAktivaTetap::class, 'id', 'id_asset');
    }
}
