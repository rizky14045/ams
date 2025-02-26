<?php

namespace App\Http\Controllers;

use App\Models\RequestAktivaTetap;
use App\Models\Gedung;
use App\Models\ModelAktivaTetap;
use App\Models\Ruang;
use Illuminate\Http\Request;

class RequestAktivaTetapController extends Controller
{

    public function postCreate(Request $req)
    {
        $asset_request = new RequestAktivaTetap;
        $action = $req->get('action');
        $saved = $this->saveRequest($req, $asset_request);
        if (!$saved) {
            return redirect()->route('AdminRequestAktivaTetapControllerGetAdd')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminRequestAktivaTetapControllerGetIndex');
    }

    public function postEdit(Request $req, $id)
    {
        $asset_request = RequestAktivaTetap::findOrfail($id);
        $saved = $this->saveRequest($req, $asset_request);
        if (!$saved) {
            return redirect()->route('AdminRequestAktivaTetapControllerGetEdit')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminRequestAktivaTetapControllerGetIndex');
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
