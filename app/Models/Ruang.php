<?php

namespace App\Models;

use App\Libraries\QrcodeRuang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ruang extends Model
{
    use SoftDeletes;

    protected $table = 'ruang';

    public function qrcode()
    {
        return QrcodeRuang::make($this->getKode(), [
            'code' => $this->getKode(),
            'name' => $this->nama_ruang,
            'directory' => 'ruang',
        ]);
    }

    public function getKode()
    {
        return $this->getKodeGedung().'.'.$this->kd_ruang.'.'.$this->getKey();
    }

    public function getKodeGedung()
    {
        return $this->gedung ? $this->gedung->kd_gedung : '';
    }

    public function scopeLantai($query, $lantai)
    {
        return $query->where('lantai', $lantai);
    }

    public function scopeGudang($query)
    {
        return $query->where('is_gudang', 1);
    }

    public function gedung()
    {
        return $this->hasOne(Gedung::class, 'id', 'id_gedung')->withTrashed();
    }
}
