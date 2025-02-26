<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\AdjustmentAktivaTetap;
use App\Models\Gedung;
use App\Models\JenisAktivaTetap;
use App\Models\ModelAktivaTetap;
use App\Models\Ruang;
use Illuminate\Http\Request;

class AdjustmentAktivaTetapController extends ApiController
{

    public function getList(Request $req)
    {
        $query = AdjustmentAktivaTetap::with(['items'])->orderBy('id', 'desc');
        return $this->listOf($query, $req, [
            'selectables' => [
                'kd_adjustment',
                'lokasi',
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
        $query = AdjustmentAktivaTetap::with(['items'])->where('id', $id);
        return $this->detailOf($query, $req, [
            'selectables' => [
                'kd_adjustment',
                'lokasi',
                'tanggal',
            ],
            'resolve' => function($adjustment) {
                return $this->resolveAdjustment($adjustment);
            }
        ]);
    }

    protected function resolveAdjustment(AdjustmentAktivaTetap $adjustment)
    {
        return $adjustment;
    }

    public function postCreate(Request $req)
    {
        $adjustment = new AdjustmentAktivaTetap;
        $saved = $this->saveAdjustmentAktivaTetap($req, $adjustment);

        if (!$saved) {
            return $this->apiError('error_create_adjustment_aktiva_tetap', 500);
        }

        return $this->apiSuccess(compact('adjustment'));
    }

    public function postEdit(Request $req, $id)
    {
        $adjustment = AdjustmentAktivaTetap::findOrfail($id);
        $saved = $this->saveAdjustmentAktivaTetap($req, $adjustment);
        if (!$saved) {
            return $this->apiError('error_update_adjustment_aktiva_tetap', 500);
        }

        return redirect()->route('AdminAdjustmentAktivaTetapControllerGetIndex');
    }

    protected function saveAdjustmentAktivaTetap(Request $req, AdjustmentAktivaTetap $adjustment)
    {
        $is_edit = (bool) $adjustment->exists;
        $this->validate($req, [
            // 'kd_adjustment' => 'required|unique:adjustment_aktiva_tetap,kd_adjustment'.($is_edit? ','.$adjustment->id : ''),
            'lokasi' => 'required',
            // 'tanggal' => 'required|date',
            // 'note' => 'required',
            'items' => 'required|array|min:1',
            'items.*.id_model' => 'required|exists:model_aktiva_tetap,id',
            'items.*.new_qty' => 'required|numeric',
            'items.*.description' => 'present',
        ]);

        $lokasi = trim($req->get('lokasi'));
        $items = $req->get('items');
        $items = array_map(function($item) use ($lokasi, $is_edit, $adjustment) {
            $model = ModelAktivaTetap::find($item['id_model']);
            if ($is_edit) {
                $itemAdj = $adjustment->items()->where('id_model', $model->getKey())->first();
                $item['current_qty'] = $itemAdj? $itemAdj->current_qty : $model->list_assets()->atLokasi($lokasi)->count();
            } else {
                $item['current_qty'] = $model->list_assets()->atLokasi($lokasi)->count();
            }
            return $item;
        }, $items);

        $adjustment->kd_adjustment = AdjustmentAktivaTetap::generateKodeAdjustment();
        $adjustment->tanggal = $req->get('tanggal') ?: date('Y-m-d');
        $adjustment->note = $req->get('note') ?: '';
        $adjustment->lokasi = $req->get('lokasi');
        $adjustment_saved = $adjustment->save();
        $items_synced = $adjustment->syncItems($items);

        return $adjustment_saved AND $items_synced;
    }
}
