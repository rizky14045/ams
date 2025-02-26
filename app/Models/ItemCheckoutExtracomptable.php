<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class ItemCheckoutExtracomptable extends Model
{
    protected $table = 'item_checkout_extracomptable';

    public function asset()
    {
        return $this->hasOne(AssetExtracomptable::class, 'id', 'id_asset');
    }
}
