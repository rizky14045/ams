<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class PemeliharaanAktivaTetap extends Model
{
    protected $table = 'pemeliharaan_aktiva_tetap';

    public static function generateKodePemeliharaan(Datetime $date = null)
    {
        if (!$date) {
            $date = new Datetime;
        }

        $prefix = 'PA'.$date->format('ymd');
        $ndigit = 3;
        $last = static::where('kd_pemeliharaan', 'like', $prefix.'%')->max('kd_pemeliharaan');
        if (!$last) {
            $no_urut = 0;
        } else {
            $no_urut = (int) substr($last, -1 * $ndigit, $ndigit);
        }

        return $prefix.str_pad($no_urut + 1, $ndigit, '0', STR_PAD_LEFT);
    }

    public function addPemeliharaanItem($id_asset)
    {
        $item = new ItemPemeliharaanAktivaTetap;
        $item->id_pemeliharaan = $this->getKey();
        $item->id_asset = $id_asset;
        return $item->save();
    }

    public function syncItems(array $items)
    {
        if ($this->exists) {
            $this->items()->delete();
        }

        foreach ($items as $i => $item) {
            $this->addPemeliharaanItem(
                $item['id_asset']
            );
        }

        return true;
    }

    public function jenis_pemeliharaan()
    {
        return $this->hasOne(JenisPemeliharaanAktivaTetap::class, 'id', 'id_jenis_pemeliharaan');
    }

    public function items()
    {
        return $this->hasMany(ItemPemeliharaanAktivaTetap::class, 'id_pemeliharaan', 'id');
    }

}
