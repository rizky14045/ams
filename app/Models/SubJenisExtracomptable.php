<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubJenisExtracomptable extends Model
{
    use SoftDeletes;

    protected $table = 'subjenis_extracomptable';

    public function jenis()
    {
        return $this->hasOne(JenisExtracomptable::class, 'id', 'id_jenis');
    }

    public function list_assets()
    {
        return $this->hasMany(AssetExtracomptable::class, 'id_subjenis', 'id');
    }
}
