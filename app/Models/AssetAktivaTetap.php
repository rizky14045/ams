<?php

namespace App\Models;

use App\Traits\AssetLogger;
use Illuminate\Database\Eloquent\Model;

class AssetAktivaTetap extends ArchiveableModel
{
    use AssetLogger;

    protected $table = 'asset_aktiva_tetap';

    public static function generateKodeAsset(
        ModelAktivaTetap $model
    ) {
        $separator = ".";
        $ndigit = 4;
        $prefix_kode = implode($separator, [
            $model->kd_model
        ]);

        $last = static::where('kd_asset', 'like', $prefix_kode.$separator.'%')->max('kd_asset');
        if (!$last) {
            $no_urut = 0;
        } else {
            $no_urut = (int) substr($last, -1 * $ndigit, $ndigit);
        }

        return $prefix_kode.$separator.str_pad($no_urut + 1, $ndigit, '0', STR_PAD_LEFT);
    }

    public function urlGambar()
    {
        return asset('uploads/assets-aktiva-tetap/'.$this->gambar) ?: asset('img/default-asset-aktiva-tetap.png');
    }

    public function scopeAtLokasi($query, $lokasi)
    {
        return $query->where('lokasi', $lokasi);
    }

    public function updateLocation($lokasi)
    {
        $this->lokasi = $lokasi;
        return $this->save();
    }

    public function model()
    {
        return $this->hasOne(ModelAktivaTetap::class, 'id', 'id_model');
    }
}
