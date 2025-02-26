<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class CheckoutAktivaTetap extends Model
{
    protected $table = 'checkout_aktiva_tetap';

    public static function generateKodeCheckout(Datetime $date = null)
    {
        if (!$date) {
            $date = new Datetime;
        }

        $prefix = 'CA'.$date->format('ymd');
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
        $item = new ItemCheckoutAktivaTetap;
        $item->id_checkout = $this->getKey();
        $item->id_asset = $id_asset;
        return $item->save();
    }

    public function syncItems(array $items)
    {
        $new_id_assets = array_map(function($item) {
            return $item['id_asset'];
        }, $items);
        $current_id_assets = $this->exists ? array_unique($this->items()->pluck('id_asset')->toArray()) : [];
        $should_deletes = array_diff($current_id_assets, $new_id_assets);

        if ($this->exists AND !empty($should_deletes)) {
            // delete id item yg tidak terdaftar
            $this->items()->where('id_asset', $should_deletes)->delete();
        }

        foreach ($items as $i => $item) {
            $itemCheckout = $this->items()->where('id_asset', $item['id_asset'])->first();
            if (!$itemCheckout) {
                // Add item checkout
                $this->addCheckoutItem($item['id_asset']);
            }
        }

        return true;
    }

    public function moveAssetsLocation()
    {
        $movedAssets = [];

        foreach ($this->items()->get() as $item) {
            $asset = AssetAktivaTetap::find($item->id_asset);
            if ($asset AND $this->shouldUpdateLocation($asset)) {
                $asset->updateLocation($this->lokasi);
                $movedAssets[] = $asset;
            }
        }

        return $movedAssets;
    }

    public function shouldUpdateLocation(AssetAktivaTetap $asset)
    {
        $id_asset = $asset->getKey();
        $last_id = ItemCheckoutAktivaTetap::where('id_asset', $id_asset)->max('id');
        $checkout_item_id = $this->items()->where('id_asset', $id_asset)->max('id');
        if (!$last_id) {
            return true;
        } else {
            return $checkout_item_id === $last_id;
        }
    }

    public function items()
    {
        return $this->hasMany(ItemCheckoutAktivaTetap::class, 'id_checkout', 'id');
    }

}
