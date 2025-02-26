<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class ItemRequestInventory extends Model
{
    public $timestamps = false;
    protected $table = 'item_request_inventory';

    public function kategori()
    {
        return $this->hasOne(KategoriInventory::class, 'id', 'id_kategori');
    }

}
