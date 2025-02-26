<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Gedung;
use App\Models\ModelAktivaTetap;
use App\Models\RequestAktivaTetap;
use App\Models\Ruang;
use Illuminate\Http\Request;

class RequestAktivaTetapController extends ApiController
{

    public function getList(Request $req)
    {
        $query = RequestAktivaTetap::with(['items']);
        return $this->listOf($query, $req, [
            'selectables' => [
                'kd_request',
                'lokasi',
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
        $query = RequestAktivaTetap::with(['items'])->where('id', $id);
        return $this->detailOf($query, $req, [
            'selectables' => [
                'kd_request',
                'lokasi',
            ],
            'resolve' => function($asset_request) {
                return $this->resolveAssetRequest($asset_request);
            }
        ]);
    }

    protected function resolveAssetRequest(RequestAktivaTetap $asset_request)
    {
        return $asset_request;
    }

    public function postCreate(Request $req)
    {
        $asset_request = new RequestAktivaTetap;
        $saved = $this->saveRequest($req, $asset_request);

        if (!$saved) {
            return $this->apiError('error_create_request_aktiva_tetap', 500);
        }

        return $this->apiSuccess(compact('request'));
    }

    public function postEdit(Request $req, $id)
    {
        $asset_request = RequestAktivaTetap::findOrfail($id);
        $saved = $this->saveRequest($req, $asset_request);

        if (!$saved) {
            return $this->apiError('error_update_request_aktiva_tetap', 500);
        }

        return $this->apiSuccess(compact('request'));
    }

    protected function saveRequest(Request $req, RequestAktivaTetap $asset_request)
    {
        $is_edit = (bool) $asset_request->exists;
        $this->validate($req, [
            'kd_request' => 'required|unique:request_aktiva_tetap,kd_request'.($is_edit? ','.$asset_request->id : ''),
            'lokasi' => 'required',
            'items' => 'required|array|min:1',
            'items.*.id_model' => 'required|exists:model_aktiva_tetap,id',
            'items.*.jumlah' => 'required|numeric',
            'items.*.note' => 'present',
            // 'ref_id_request' => '',
        ]);

        $items = $req->get('items');

        $asset_request->kd_request = $req->get('kd_request');
        $asset_request->lokasi = $req->get('lokasi');
        $asset_request->status = 'pending';
        $asset_request_saved = $asset_request->save();
        $items_synced = $asset_request->syncItems($items);

        return $asset_request_saved AND $items_synced;
    }
}
