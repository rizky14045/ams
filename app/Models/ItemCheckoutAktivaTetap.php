<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class ItemCheckoutAktivaTetap extends Model
{
    protected $table = 'item_checkout_aktiva_tetap';

    public function asset()
    {
        return $this->hasOne(AssetAktivaTetap::class, 'id', 'id_asset');
    }
}
