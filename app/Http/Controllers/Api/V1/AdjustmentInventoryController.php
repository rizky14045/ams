<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\AdjustmentInventory;
use App\Models\AssetInventory;
use App\Models\Gedung;
use App\Models\JenisInventory;
use App\Models\Ruang;
use Illuminate\Http\Request;

class AdjustmentInventoryController extends ApiController
{
    public function getList(Request $req)
    {
        $query = AdjustmentInventory::with([
            'gedung',
            'ruang',
            'items',
            'items.asset',
        ])->orderBy('id', 'desc');

        return $this->listOf($query, $req, [
            'selectables' => [
                'kd_adjustment',
                'id_gedung',
                'lantai',
                'id_ruang',
                'tanggal',
            ],
            'filter' => function($query, $keyword) {
                $query->where('kd_adjustment', 'like', "%{$keyword}%");
            },
            'map' => function($adjustment) {
                return $this->resolveAdjustment($adjustment);
            }
        ]);
    }

    public function getDetail(Request $req, $id)
    {
        $query = AdjustmentInventory::with([
            'ruang',
            'gedung',
            'items',
            'items.asset',
        ])->where('id', $id);
        return $this->detailOf($query, $req, [
            'selectables' => [
                'kd_adjustment',
                'id_gedung',
                'lantai',
                'id_ruang',
                'tanggal',
            ],
            'resolve' => function($adjustment) {
                return $this->resolveAdjustment($adjustment);
            }
        ]);
    }

    protected function resolveAdjustment(AdjustmentInventory $adjustment)
    {
        return $adjustment;
    }

    public function postCreate(Request $req)
    {
        $adjustment = new AdjustmentInventory;
        $saved = $this->saveAdjustmentInventory($req, $adjustment);
        if (!$saved) {
            return $this->apiError('error_create_adjustment_inventory', 500);
        }

        return $this->apiSuccess(compact('adjustment'));
    }

    public function postEdit(Request $req, $id)
    {
        $adjustment = AdjustmentInventory::findOrfail($id);
        $saved = $this->saveAdjustmentInventory($req, $adjustment);
        if (!$saved) {
            return $this->apiError('error_update_adjustment_inventory', 500);
        }

        return $this->apiSuccess(compact('adjustment'));
    }

    protected function saveAdjustmentInventory(Request $req, AdjustmentInventory $adjustment)
    {
        $is_edit = (bool) $adjustment->exists;
        $this->validate($req, [
            // 'kd_adjustment' => 'required|unique:adjustment_inventory,kd_adjustment'.($is_edit? ','.$adjustment->id : ''),
            'id_gedung' => 'required|exists:gedung,id',
            'lantai' => 'required',
            'id_ruang' => 'required|exists:ruang,id',
            // 'tanggal' => 'required|date',
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

        $adjustment->kd_adjustment = AdjustmentInventory::generateKodeAdjustment();
        $adjustment->tanggal = $req->get('tanggal') ?: date('Y-m-d');
        $adjustment->note = $req->get('note') ?: '';
        $adjustment->id_gedung = $req->get('id_gedung');
        $adjustment->lantai = $req->get('lantai');
        $adjustment->id_ruang = $req->get('id_ruang');
        $adjustment_saved = $adjustment->save();
        $items_synced = $adjustment->syncItems($items);

        return $adjustment_saved AND $items_synced;
    }
}
