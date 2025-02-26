<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\JenisExtracomptable;
use Illuminate\Http\Request;

class JenisExtracomptableController extends ApiController
{

    public function getList(Request $req)
    {
        $query = JenisExtracomptable::query();
        return $this->listOf($query, $req, [
            'selectables' => [
                'id',
                'kd_jenis',
                'nama',
                'description',
                'created_at',
                'updated_at'
            ],
            'filter' => function($query, $keyword) {
                $query->where('kd_jenis', 'like', "%{$keyword}%");
                $query->orWhere('nama', 'like', "%{$keyword}%");
                $query->orWhere('description', 'like', "%{$keyword}%");
            },
            'map' => function($jenis) {
                return $jenis;
            }
        ]);
    }

}
