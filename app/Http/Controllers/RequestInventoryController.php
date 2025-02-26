<?php

namespace App\Http\Controllers;

use App\Models\RequestInventory;
use App\Models\Gedung;
use App\Models\KategoriInventory;
use App\Models\Ruang;
use Illuminate\Http\Request;

class RequestInventoryController extends Controller
{

    public function postCreate(Request $req)
    {
        $asset_request = new RequestInventory;
        $action = $req->get('action');
        $saved = $this->saveRequest($req, $asset_request);
        if (!$saved) {
            return redirect()->route('AdminRequestInventoryControllerGetAdd')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminRequestInventoryControllerGetIndex');
    }

    public function postEdit(Request $req, $id)
    {
        $asset_request = RequestInventory::findOrfail($id);
        $saved = $this->saveRequest($req, $asset_request);
        if (!$saved) {
            return redirect()->route('AdminRequestInventoryControllerGetEdit')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminRequestInventoryControllerGetIndex');
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
