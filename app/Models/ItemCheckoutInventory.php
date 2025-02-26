<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class ItemCheckoutInventory extends Model
{
    protected $table = 'item_checkout_inventory';

    public function asset()
    {
        return $this->hasOne(AssetInventory::class, 'id', 'id_asset');
    }
}
