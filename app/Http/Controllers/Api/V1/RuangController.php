<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Ruang;
use Illuminate\Http\Request;

class RuangController extends ApiController
{

    public function getList(Request $req)
    {
        $query = Ruang::query();

        if ($id_gedung = $req->get('id_gedung')) {
            $query->where('id_gedung', $id_gedung);
        }

        if ($lantai = $req->get('lantai')) {
            $query->where('lantai', $lantai);
        }

        return $this->listOf($query, $req, [
            'selectables' => [
                'id',
                'id_gedung',
                'lantai',
                'kd_ruang',
                'nama_ruang',
                'created_at',
                'updated_at',
            ],
            'filter' => function($query, $keyword) {
                $query->where('kd_ruang', 'like', "%{$keyword}%");
                $query->orWhere('nama_ruang', 'like', "%{$keyword}%");
            },
            'map' => function($ruang) {
                return $ruang;
            }
        ]);
    }

}
