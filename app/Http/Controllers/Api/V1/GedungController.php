<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Gedung;
use Illuminate\Http\Request;

class GedungController extends ApiController
{

    public function getList(Request $req)
    {
        $query = Gedung::query();
        return $this->listOf($query, $req, [
            'selectables' => [
                'id',
                'kd_gedung',
                'nama',
                'lokasi',
                'jumlah_lantai',
                'created_at',
                'updated_at',
            ],
            'filter' => function($query, $keyword) {
                $query->where('kd_gedung', 'like', "%{$keyword}%");
                $query->orWhere('nama', 'like', "%{$keyword}%");
                $query->orWhere('lokasi', 'like', "%{$keyword}%");
            },
            'map' => function($gedung) {
                return $gedung;
            }
        ]);
    }

}
