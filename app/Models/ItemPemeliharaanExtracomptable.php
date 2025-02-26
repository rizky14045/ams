<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class ItemPemeliharaanExtracomptable extends Model
{
    protected $table = 'item_pemeliharaan_extracomptable';

    public function asset()
    {
        return $this->hasOne(AssetExtracomptable::class, 'id', 'id_asset');
    }
}
