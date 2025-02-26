<?php

namespace App\Http\Controllers;

use App\Models\RequestExtracomptable;
use App\Models\Gedung;
use App\Models\JenisExtracomptable;
use App\Models\Ruang;
use App\Models\SubJenisExtracomptable;
use Illuminate\Http\Request;

class RequestExtracomptableController extends Controller
{

    public function postCreate(Request $req)
    {
        $asset_request = new RequestExtracomptable;
        $action = $req->get('action');
        $saved = $this->saveRequest($req, $asset_request);
        if (!$saved) {
            return redirect()->route('AdminRequestExtracomptableControllerGetAdd')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminRequestExtracomptableControllerGetIndex');
    }

    public function postEdit(Request $req, $id)
    {
        $asset_request = RequestExtracomptable::findOrfail($id);
        $saved = $this->saveRequest($req, $asset_request);
        if (!$saved) {
            return redirect()->route('AdminRequestExtracomptableControllerGetEdit')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminRequestExtracomptableControllerGetIndex');
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
