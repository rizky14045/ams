<?php

namespace App\Models;

use App\Libraries\QrcodeAsset;
use App\Traits\AssetLogger;
use Illuminate\Database\Eloquent\Model;

class AssetInventory extends ArchiveableModel
{
    use AssetLogger;

    protected $table = 'asset_inventory';

    public static function generateKodeAsset(
        Gedung $gedung,
        $lantai,
        Ruang $ruang,
        KategoriInventory $kategori
    ) {
        $separator = ".";
        $ndigit = 4;
        $prefix_kode = implode($separator, [
            $gedung->kd_gedung,
            $lantai,
            $ruang->kd_ruang,
            $kategori->kd_kategori
        ]);

        $last = static::where('kd_asset', 'like', $prefix_kode.$separator.'%')->max('kd_asset');
        if (!$last) {
            $no_urut = 0;
        } else {
            $no_urut = (int) substr($last, -1 * $ndigit, $ndigit);
        }

        return $prefix_kode.$separator.str_pad($no_urut + 1, $ndigit, '0', STR_PAD_LEFT);
    }

    public function qrcode()
    {
        $textRuangLantai = ($this->ruang ? $this->ruang->nama_ruang : '') . ' / Lt. ' . $this->lantai;
        $textGedung = $this->gedung ? $this->gedung->nama : '';
        return QrcodeAsset::make($this->kd_asset, [
            'name' => $this->nama_asset,
            'location' => $this->getLocation(),
            'texts' => [
                $textRuangLantai,
                $textGedung
            ],
            'directory' => 'inventory',
        ]);
    }

    public function getLocation()
    {
        $ruang = $this->ruang;
        $gedung = $this->gedung;

        $paths = [];
        if ($ruang) $paths[] = $ruang->nama_ruang;
        $paths[] = "Lt. {$this->lantai}";
        if ($gedung) $paths[] = $gedung->nama;

        return implode(' / ', $paths);
    }

    public function urlGambar()
    {
        return asset('uploads/assets-inventory/'.$this->gambar) ?: asset('img/default-asset-inventory.png');
    }

    public function updateLocation(Gedung $gedung, $lantai, Ruang $ruang)
    {
        $this->id_gedung = $gedung->getKey();
        $this->lantai = $lantai;
        $this->id_ruang = $ruang->getKey();
        return $this->save();
    }

    public function kategori()
    {
        return $this->hasOne(KategoriInventory::class, 'id', 'id_kategori');
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
