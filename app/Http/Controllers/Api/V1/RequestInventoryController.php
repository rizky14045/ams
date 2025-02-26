<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Gedung;
use App\Models\KategoriInventory;
use App\Models\RequestInventory;
use App\Models\Ruang;
use Illuminate\Http\Request;

class RequestInventoryController extends ApiController
{

    public function getList(Request $req)
    {
        $query = RequestInventory::with(['items']);
        return $this->listOf($query, $req, [
            'selectables' => [
                'kd_request',
                'id_gedung',
                'lantai',
                'id_ruang',
            ],
            'filter' => function($query, $keyword) {
                $query->where('kd_request', 'like', "%{$keyword}%");
            },
            'map' => function($asset_request) {
                return $this->resolveAssetRequest($asset_request);
            }
        ]);
    }

    public function getDetail(Request $req, $id)
    {
        $query = RequestInventory::with(['items'])->where('id', $id);
        return $this->detailOf($query, $req, [
            'selectables' => [
                'kd_request',
                'id_gedung',
                'lantai',
                'id_ruang',
            ],
            'resolve' => function($asset_request) {
                return $this->resolveAssetRequest($asset_request);
            }
        ]);
    }

    protected function resolveAssetRequest(RequestInventory $asset_request)
    {
        return $asset_request;
    }

    public function postCreate(Request $req)
    {
        $asset_request = new RequestInventory;
        $saved = $this->saveRequest($req, $asset_request);

        if (!$saved) {
            return $this->apiError('error_create_request_inventory', 500);
        }

        return $this->apiSuccess([
            'request' => $asset_request
        ]);
    }

    public function postEdit(Request $req, $id)
    {
        $asset_request = RequestInventory::findOrfail($id);
        $saved = $this->saveRequest($req, $asset_request);

        if (!$saved) {
            return $this->apiError('error_update_request_inventory', 500);
        }

        return $this->apiSuccess([
            'request' => $asset_request
        ]);
    }

    protected function saveRequest(Request $req, RequestInventory $asset_request)
    {
        $is_edit = (bool) $asset_request->exists;
        $this->validate($req, [
            'kd_request' => 'required|unique:request_inventory,kd_request'.($is_edit? ','.$asset_request->id : ''),
            'id_gedung' => 'required|exists:gedung,id',
            'lantai' => 'required',
            'id_ruang' => 'required|exists:ruang,id',
            'items' => 'required|array|min:1',
            'items.*.id_kategori' => 'required|exists:kategori_inventory,id',
            'items.*.jumlah' => 'required|numeric',
            'items.*.note' => 'present',
            // 'ref_id_request' => '',
        ]);

        $items = $req->get('items');

        $asset_request->kd_request = $req->get('kd_request');
        $asset_request->id_gedung = $req->get('id_gedung');
        $asset_request->lantai = $req->get('lantai');
        $asset_request->id_ruang = $req->get('id_ruang');
        $asset_request->status = 'pending'; // $req->get('id_ruang');
        $asset_request_saved = $asset_request->save();
        $items_synced = $asset_request->syncItems($items);

        return $asset_request_saved AND $items_synced;
    }
}
