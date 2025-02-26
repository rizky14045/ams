<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriInventory extends Model
{
    use SoftDeletes;

    protected $table = 'kategori_inventory';
}
