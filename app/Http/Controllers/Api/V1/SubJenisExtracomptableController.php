<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\SubJenisExtracomptable;
use Illuminate\Http\Request;

class SubJenisExtracomptableController extends ApiController
{

    public function getList(Request $req)
    {
        $query = SubJenisExtracomptable::query();

        if ($id_jenis = $req->get('id_jenis')) {
            $query->where('id_jenis', $id_jenis);
        }

        return $this->listOf($query, $req, [
            'selectables' => [
                'id',
                'id_jenis',
                'kd_subjenis',
                'nama',
                'description',
                'created_at',
                'updated_at',
            ],
            'filter' => function($query, $keyword) {
                $query->where('kd_subjenis', 'like', "%{$keyword}%");
                $query->where('nama', 'like', "%{$keyword}%");
                $query->where('description', 'like', "%{$keyword}%");
            },
            'map' => function($subjenis) {
                return $subjenis;
            }
        ]);
    }

}
