<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gedung extends Model
{
    use SoftDeletes;

    protected $table = 'gedung';

    public function getListLantai()
    {
        return range(1, $this->jumlah_lantai);
    }

    public function list_ruang()
    {
        return $this->hasMany(Ruang::class, 'id_gedung', 'id');
    }
}
