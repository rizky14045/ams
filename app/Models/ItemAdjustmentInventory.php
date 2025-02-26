<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class ItemAdjustmentInventory extends Model
{

    public $timestamps = false;
    protected $table = 'item_adjustment_inventory';

    public function asset()
    {
        return $this->hasOne(AssetInventory::class, 'id', 'id_asset');
    }

}
