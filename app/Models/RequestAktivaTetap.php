<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class RequestAktivaTetap extends Model
{
    protected $table = 'request_aktiva_tetap';

    public static function generateKodeRequest(Datetime $date = null)
    {
        if (!$date) {
            $date = new Datetime;
        }

        $prefix = 'RA'.$date->format('ymd');
        $ndigit = 3;
        $last = static::where('kd_request', 'like', $prefix.'%')->max('kd_request');
        if (!$last) {
            $no_urut = 0;
        } else {
            $no_urut = (int) substr($last, -1 * $ndigit, $ndigit);
        }

        return $prefix.str_pad($no_urut + 1, $ndigit, '0', STR_PAD_LEFT);
    }

    public function addRequestedItem($id_model, $jumlah, $note)
    {
        $item = new ItemRequestAktivaTetap;
        $item->id_request = $this->getKey();
        $item->id_model = $id_model;
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
                $item['id_model'],
                $item['jumlah'],
                $item['note']
            );
        }

        return true;
    }

    public function items()
    {
        return $this->hasMany(ItemRequestAktivaTetap::class, 'id_request', 'id');
    }
}
