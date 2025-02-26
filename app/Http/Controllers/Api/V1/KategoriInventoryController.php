<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\KategoriInventory;
use Illuminate\Http\Request;

class KategoriInventoryController extends ApiController
{

    public function getList(Request $req)
    {
        $query = KategoriInventory::query();
        return $this->listOf($query, $req, [
            'selectables' => [
                'id',
                'kd_kategori',
                'nama_kategori',
                'created_at',
                'updated_at'
            ],
            'filter' => function($query, $keyword) {
                $query->where('kd_kategori', 'like', "%{$keyword}%");
                $query->orWhere('nama_kategori', 'like', "%{$keyword}%");
            },
            'map' => function($kategori) {
                return $kategori;
            }
        ]);
    }

}
