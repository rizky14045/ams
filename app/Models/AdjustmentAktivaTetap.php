<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class AdjustmentAktivaTetap extends Model
{
    protected $table = 'adjustment_aktiva_tetap';

    public static function generateKodeAdjustment(Datetime $date = null)
    {
        if (!$date) {
            $date = new Datetime;
        }

        $prefix = 'AA'.$date->format('ymd');
        $ndigit = 3;
        $last = static::where('kd_adjustment', 'like', $prefix.'%')->max('kd_adjustment');
        if (!$last) {
            $no_urut = 0;
        } else {
            $no_urut = (int) substr($last, -1 * $ndigit, $ndigit);
        }

        return $prefix.str_pad($no_urut + 1, $ndigit, '0', STR_PAD_LEFT);
    }

    public function addAdjustmentedItem($id_model, $current_qty, $new_qty, $description)
    {
        $item = new ItemAdjustmentAktivaTetap;
        $item->id_adjustment = $this->getKey();
        $item->id_model = $id_model;
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
                $item['id_model'],
                $item['current_qty'],
                $item['new_qty'],
                $item['description']
            );
        }

        return true;
    }

    public function items()
    {
        return $this->hasMany(ItemAdjustmentAktivaTetap::class, 'id_adjustment', 'id');
    }
}
