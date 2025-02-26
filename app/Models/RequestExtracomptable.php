<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class RequestExtracomptable extends Model
{
    protected $table = 'request_extracomptable';

    public static function generateKodeRequest(Datetime $date = null)
    {
        if (!$date) {
            $date = new Datetime;
        }

        $prefix = 'RE'.$date->format('ymd');
        $ndigit = 3;
        $last = static::where('kd_request', 'like', $prefix.'%')->max('kd_request');
        if (!$last) {
            $no_urut = 0;
        } else {
            $no_urut = (int) substr($last, -1 * $ndigit, $ndigit);
        }

        return $prefix.str_pad($no_urut + 1, $ndigit, '0', STR_PAD_LEFT);
    }

    public function addRequestedItem($id_jenis, $id_subjenis, $jumlah, $note)
    {
        $item = new ItemRequestExtracomptable;
        $item->id_request = $this->getKey();
        $item->id_jenis = $id_jenis;
        $item->id_subjenis = $id_subjenis;
        $item->jumlah = $jumlah;
        $item->note = $note;
        return $item->save();
    }

    public function syncItems(array $items)
    {
        if ($this->exists) {
            $this->items()->delete();
        }

        foreach ($items as $i => $item) {
            $this->addRequestedItem(
                $item['id_jenis'],
                $item['id_subjenis'],
                $item['jumlah'],
                $item['note']
            );
        }

        return true;
    }

    public function items()
    {
        return $this->hasMany(ItemRequestExtracomptable::class, 'id_request', 'id');
    }
}
