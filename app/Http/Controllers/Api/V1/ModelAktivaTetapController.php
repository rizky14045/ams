<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\ModelAktivaTetap;
use Illuminate\Http\Request;

class ModelAktivaTetapController extends ApiController
{

    public function getList(Request $req)
    {
        $query = ModelAktivaTetap::query();
        return $this->listOf($query, $req, [
            'selectables' => [
                'id',
                'kd_model',
                'nama_model',
                'description',
                'created_at',
                'updated_at'
            ],
            'filter' => function($query, $keyword) {
                $query->where('kd_model', 'like', "%{$keyword}%");
                $query->orWhere('nama_model', 'like', "%{$keyword}%");
                $query->orWhere('description', 'like', "%{$keyword}%");
            },
            'map' => function($model) {
                return $model;
            }
        ]);
    }

}
