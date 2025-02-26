<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class ItemRequestExtracomptable extends Model
{
    public $timestamps = false;
    protected $table = 'item_request_extracomptable';

    public function jenis()
    {
        return $this->hasOne(JenisExtracomptable::class, 'id', 'id_jenis');
    }

    public function subjenis()
    {
        return $this->hasOne(SubJenisExtracomptable::class, 'id', 'id_subjenis');
    }

}
