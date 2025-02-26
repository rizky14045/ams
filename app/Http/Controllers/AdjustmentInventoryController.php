<?php

namespace App\Http\Controllers;

use App\Models\AdjustmentInventory;
use App\Models\Gedung;
use App\Models\JenisInventory;
use App\Models\Ruang;
use App\Models\AssetInventory;
use Illuminate\Http\Request;

class AdjustmentInventoryController extends Controller
{

    public function postCreate(Request $req)
    {
        $adjustment = new AdjustmentInventory;
        $action = $req->get('action');
        $saved = $this->saveAdjustment($req, $adjustment);
        if (!$saved) {
            return redirect()->route('AdminAdjustmentInventoryControllerGetAdd')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminAdjustmentInventoryControllerGetIndex');
    }

    public function postEdit(Request $req, $id)
    {
        $adjustment = AdjustmentInventory::findOrfail($id);
        $saved = $this->saveAdjustment($req, $adjustment);
        if (!$saved) {
            return redirect()->route('AdminAdjustmentInventoryControllerGetEdit')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminAdjustmentInventoryControllerGetIndex');
    }

    protected function saveAdjustment(Request $req, AdjustmentInventory $adjustment)
    {
        $is_edit = (bool) $adjustment->exists;
        $this->validate($req, [
            'kd_adjustment' => 'required|unique:adjustment_inventory,kd_adjustment'.($is_edit? ','.$adjustment->id : ''),
            'id_gedung' => 'required|exists:gedung,id',
            'lantai' => 'required',
            'id_ruang' => 'required|exists:ruang,id',
            'tanggal' => 'required|date',
            // 'note' => 'required',
            'items' => 'required|array|min:1',
            'items.*.id_asset' => 'required|exists:asset_inventory,id',
            'items.*.new_qty' => 'required|numeric',
            'items.*.description' => 'present',
        ]);

        $ruang = Ruang::find($req->get('id_ruang'));
        $items = $req->get('items');
        $items = array_map(function($item) use ($ruang, $is_edit, $adjustment) {
            $asset = AssetInventory::find($item['id_asset']);
            if ($is_edit) {
                $itemAdj = $adjustment->items()->where('id_asset', $asset->getKey())->first();
                $item['current_qty'] = $itemAdj? $itemAdj->current_qty : $asset->jumlah;
            } else {
                $item['current_qty'] = $asset->jumlah;
            }
            return $item;
        }, $items);

        $adjustment->kd_adjustment = $req->get('kd_adjustment');
        $adjustment->tanggal = $req->get('tanggal');
        $adjustment->note = $req->get('note') ?: '';
        $adjustment->id_gedung = $req->get('id_gedung');
        $adjustment->lantai = $req->get('lantai');
        $adjustment->id_ruang = $req->get('id_ruang');
        $adjustment_saved = $adjustment->save();
        $items_synced = $adjustment->syncItems($items);

        return $adjustment_saved AND $items_synced;
    }
}
