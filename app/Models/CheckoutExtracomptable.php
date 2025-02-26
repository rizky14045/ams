<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class CheckoutExtracomptable extends Model
{
    protected $table = 'checkout_extracomptable';

    public static function generateKodeCheckout(Datetime $date = null)
    {
        if (!$date) {
            $date = new Datetime;
        }

        $prefix = 'CE'.$date->format('ymd');
        $ndigit = 3;
        $last = static::where('kd_checkout', 'like', $prefix.'%')->max('kd_checkout');
        if (!$last) {
            $no_urut = 0;
        } else {
            $no_urut = (int) substr($last, -1 * $ndigit, $ndigit);
        }

        return $prefix.str_pad($no_urut + 1, $ndigit, '0', STR_PAD_LEFT);
    }

    public function addCheckoutItem($id_asset)
    {
        $item = new ItemCheckoutExtracomptable;
        $item->id_checkout = $this->getKey();
        $item->id_asset = $id_asset;
        return $item->save();
    }

    public function syncItems(array $items)
    {
        if ($this->exists) {
            $this->items()->delete();
        }

        foreach ($items as $i => $item) {
            $this->addCheckoutItem(
                $item['id_asset']
            );
        }

        return true;
    }

    public function moveAssetsLocation()
    {
        $movedAssets = [];

        foreach ($this->items()->get() as $item) {
            $asset = AssetExtracomptable::find($item->id_asset);
            if ($asset AND $this->shouldUpdateLocation($asset)) {
                $asset->updateLocation($this->gedung, $this->lantai, $this->ruang);
                $movedAssets[] = $asset;
            }
        }

        return $movedAssets;
    }

    public function shouldUpdateLocation(AssetExtracomptable $asset)
    {
        $id_asset = $asset->getKey();
        $last_id = ItemCheckoutExtracomptable::where('id_asset', $id_asset)->max('id');
        $checkout_item_id = $this->items()->where('id_asset', $id_asset)->max('id');
        if (!$last_id) {
            return true;
        } else {
            return $checkout_item_id === $last_id;
        }
    }

    public function items()
    {
        return $this->hasMany(ItemCheckoutExtracomptable::class, 'id_checkout', 'id');
    }

    public function gedung()
    {
        return $this->hasOne(Gedung::class, 'id', 'id_gedung');
    }

    public function ruang()
    {
        return $this->hasOne(Ruang::class, 'id', 'id_ruang');
    }

}
