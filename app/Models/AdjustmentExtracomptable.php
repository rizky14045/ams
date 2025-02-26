<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class AdjustmentExtracomptable extends Model
{
    protected $table = 'adjustment_extracomptable';

    public static function generateKodeAdjustment(Datetime $date = null)
    {
        if (!$date) {
            $date = new Datetime;
        }

        $prefix = 'AE'.$date->format('ymd');
        $ndigit = 3;
        $last = static::where('kd_adjustment', 'like', $prefix.'%')->max('kd_adjustment');
        if (!$last) {
            $no_urut = 0;
        } else {
            $no_urut = (int) substr($last, -1 * $ndigit, $ndigit);
        }

        return $prefix.str_pad($no_urut + 1, $ndigit, '0', STR_PAD_LEFT);
    }

    public function addAdjustmentedItem($id_subjenis, $current_qty, $new_qty, $description)
    {
        $item = new ItemAdjustmentExtracomptable;
        $item->id_adjustment = $this->getKey();
        $item->id_subjenis = $id_subjenis;
        $item->current_qty = $current_qty;
        $item->new_qty = $new_qty;
        $item->description = $description ?: '';
        return $item->save();
    }

    public function syncItems(array $items)
    {
        if ($this->exists) {
            $this->items()->delete();
        }

        foreach ($items as $i => $item) {
            $this->addAdjustmentedItem(
                $item['id_subjenis'],
                $item['current_qty'],
                $item['new_qty'],
                $item['description']
            );
        }

        return true;
    }

    public function gedung()
    {
        return $this->hasOne(Gedung::class, 'id', 'id_gedung');
    }

    public function ruang()
    {
        return $this->hasOne(Ruang::class, 'id', 'id_ruang');
    }

    public function items()
    {
        return $this->hasMany(ItemAdjustmentExtracomptable::class, 'id_adjustment', 'id');
    }
}
