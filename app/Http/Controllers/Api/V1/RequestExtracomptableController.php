<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Gedung;
use App\Models\JenisExtracomptable;
use App\Models\RequestExtracomptable;
use App\Models\Ruang;
use App\Models\SubJenisExtracomptable;
use Illuminate\Http\Request;

class RequestExtracomptableController extends ApiController
{

    public function getList(Request $req)
    {
        $query = RequestExtracomptable::with(['items']);
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
        $query = RequestExtracomptable::with(['items'])->where('id', $id);
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

    protected function resolveAssetRequest(RequestExtracomptable $asset_request)
    {
        return $asset_request;
    }

    public function postCreate(Request $req)
    {
        $asset_request = new RequestExtracomptable;
        $saved = $this->saveRequest($req, $asset_request);

        if (!$saved) {
            return $this->apiError('error_create_request_extracomptable', 500);
        }

        return $this->apiSuccess(compact('request'));
    }

    public function postEdit(Request $req, $id)
    {
        $asset_request = RequestExtracomptable::findOrfail($id);
        $saved = $this->saveRequest($req, $asset_request);

        if (!$saved) {
            return $this->apiError('error_update_request_extracomptable', 500);
        }

        return $this->apiSuccess(compact('request'));
    }

    protected function saveRequest(Request $req, RequestExtracomptable $asset_request)
    {
        $is_edit = (bool) $asset_request->exists;
        $list_status = array_keys(config('asset.status_extracomptable'));
        $this->validate($req, [
            'kd_request' => 'required|unique:request_extracomptable,kd_request'.($is_edit? ','.$asset_request->id : ''),
            'id_gedung' => 'required|exists:gedung,id',
            'lantai' => 'required',
            'id_ruang' => 'required|exists:ruang,id',
            'items' => 'required|array|min:1',
            'items.*.id_jenis' => 'required|exists:jenis_extracomptable,id',
            'items.*.id_subjenis' => 'required|exists:subjenis_extracomptable,id',
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
