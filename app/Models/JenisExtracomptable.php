<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisExtracomptable extends Model
{
    use SoftDeletes;

    protected $table = 'jenis_extracomptable';

    public function list_subjenis()
    {
        return $this->hasMany(SubJenisExtracomptable::class, 'id_jenis', 'id');
    }
}
