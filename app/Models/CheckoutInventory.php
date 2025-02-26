<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class CheckoutInventory extends Model
{
    protected $table = 'checkout_inventory';

    protected $prevIdGedung;
    protected $prevLantai;
    protected $prevIdRuang;

    protected $state = [];

    public function saveCurrentState()
    {
        $this->state = $this->toArray();
    }

    public function state($key)
    {
        return isset($this->state[$key]) ? $this->state[$key] : null;
    }

    public static function generateKodeCheckout(Datetime $date = null, $isPos = false)
    {
        if (!$date) {
            $date = new Datetime;
        }

        $prefix = ($isPos ? 'PCI' : 'CI').$date->format('ymd');
        $ndigit = 3;
        $last = static::where('kd_checkout', 'like', $prefix.'%')->max('kd_checkout');
        if (!$last) {
            $no_urut = 0;
        } else {
            $no_urut = (int) substr($last, -1 * $ndigit, $ndigit);
        }

        return $prefix.str_pad($no_urut + 1, $ndigit, '0', STR_PAD_LEFT);
    }

    public function addCheckoutItem($id_asset, $jumlah)
    {
        $item = new ItemCheckoutInventory;
        $item->id_checkout = $this->getKey();
        $item->id_asset = $id_asset;
        $item->jumlah = $jumlah;
        $item->save();
        return $item;
    }

    public function syncItems(array $items)
    {
        $new_id_assets = array_map(function($item) {
            return $item['id_asset'];
        }, $items);
        $current_id_assets = $this->exists ? array_unique($this->items()->pluck('id_asset')->toArray()) : [];
        $should_deletes = array_diff($current_id_assets, $new_id_assets);

        // Jika checkout exists (sedang diedit), dan terdapat item yg harus di delete
        if ($this->exists AND !empty($should_deletes)) {
            $query_should_deletes = $this->items()->where('id_asset', $should_deletes);

            // Kembalikan data stok asset dari lokasi tujuan ke lokasi ini
            $items = $query_should_deletes->get();
            foreach($items as $item) {
                $this->revertQty($item);
            }

            // delete id item yg harus dihapus
            $query_should_deletes->delete();
        }

        foreach ($items as $i => $item) {
            $itemCheckout = $this->items()->where('id_asset', $item['id_asset'])->first();
            if ($itemCheckout) {
                // Kembalikan stok pada data asset
                $this->revertQty($itemCheckout);
                // Ubah jumlah/qty item checkout
                $itemCheckout->jumlah = $item['jumlah'];
                $itemCheckout->save();
            } else {
                $itemCheckout = $this->addCheckoutItem($item['id_asset'], $item['jumlah']);
            }
            // Pindahkan stok asset dari lokasi A ke B
            $this->moveQty($itemCheckout);
        }

        return true;
    }

    protected function moveQty(ItemCheckoutInventory $item)
    {
        $qty = $item->jumlah;
        $related_asset = $this->findOrCreateRelatedAsset($item);
        $related_asset->jumlah = $related_asset->jumlah + $qty;
        $related_asset->save();

        $item->asset->jumlah = $item->asset->jumlah - $qty;
        $item->asset->save();
    }

    protected function revertQty(ItemCheckoutInventory $item)
    {
        $qty = $item->jumlah;
        $related_asset = $this->findRelatedAsset($item);
        if ($related_asset) {
            $related_asset->jumlah = $related_asset->jumlah - $qty;
            $related_asset->save();
        }
        $item->asset->jumlah = $item->asset->jumlah + $qty;
        $item->asset->save();
    }

    protected function findOrCreateRelatedAsset(ItemCheckoutInventory $item)
    {
        return $this->findRelatedAsset($item) ?: $this->createRelatedAsset($item);
    }

    protected function findRelatedAsset(ItemCheckoutInventory $item)
    {
        $id_gedung = $this->state('id_gedung') ?: $this->id_gedung;
        $lantai = $this->state('lantai') ?: $this->lantai;
        $id_ruang = $this->state('id_ruang') ?: $this->id_ruang;
        $id_kategori = $item->asset->id_kategori;

        $related_asset = AssetInventory::query()
        ->where('id_gedung', $id_gedung)
        ->where('lantai', $lantai)
        ->where('id_ruang', $id_ruang)
        ->where('id_kategori', $id_kategori)
        ->first();

        return $related_asset;
    }

    protected function createRelatedAsset(ItemCheckoutInventory $item)
    {
        $item_asset = $item->asset;
        $id_gedung = $this->state('id_gedung') ?: $this->id_gedung;
        $lantai = $this->state('lantai') ?: $this->lantai;
        $id_ruang = $this->state('id_ruang') ?: $this->id_ruang;
        $id_kategori = $item_asset->id_kategori;

        $gedung = Gedung::findOrFail($id_gedung);
        $ruang = Ruang::findOrFail($id_ruang);
        $kategori = KategoriInventory::findOrFail($id_kategori);
        $kd_asset = AssetInventory::generateKodeAsset($gedung, $lantai, $ruang, $kategori);

        $related_asset = new AssetInventory;
        $related_asset->kd_asset = $kd_asset;
        $related_asset->id_gedung = $id_gedung;
        $related_asset->lantai = $lantai;
        $related_asset->id_ruang = $id_ruang;
        $related_asset->id_kategori = $id_kategori;
        $related_asset->nama_asset = $item_asset->nama_asset;
        $related_asset->jumlah = 0;
        $related_asset->jumlah_minimum = $item_asset->jumlah_minimum;
        $related_asset->gambar = $item_asset->gambar;
        $related_asset->ref_id_request = $item_asset->ref_id_request;
        $related_asset->save();

        return $related_asset;
    }

    public function items()
    {
        return $this->hasMany(ItemCheckoutInventory::class, 'id_checkout', 'id');
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
