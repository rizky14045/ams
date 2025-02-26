<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\AdjustmentExtracomptable;
use App\Models\Gedung;
use App\Models\JenisExtracomptable;
use App\Models\Ruang;
use App\Models\SubJenisExtracomptable;
use Illuminate\Http\Request;

class AdjustmentExtracomptableController extends ApiController
{

    public function getList(Request $req)
    {
        $query = AdjustmentExtracomptable::with([
            'items',
            'items.subjenis',
            'gedung',
            'ruang',
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
        $query = AdjustmentExtracomptable::with([
            'gedung',
            'ruang',
            'items',
            'items.subjenis',
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

    protected function resolveAdjustment(AdjustmentExtracomptable $adjustment)
    {
        return $adjustment;
    }

    public function postCreate(Request $req)
    {
        $adjustment = new AdjustmentExtracomptable;
        $saved = $this->saveAdjustmentExtracomptable($req, $adjustment);
        if (!$saved) {
            return $this->apiError('error_create_adjustment_extracomptable', 500);
        }

        return $this->apiSuccess(compact('adjustment'));
    }

    public function postEdit(Request $req, $id)
    {
        $adjustment = AdjustmentExtracomptable::findOrfail($id);
        $saved = $this->saveAdjustmentExtracomptable($req, $adjustment);
        if (!$saved) {
            return $this->apiError('error_update_adjustment_extracomptable', 500);
        }

        return $this->apiSuccess(compact('adjustment'));
    }

    protected function saveAdjustmentExtracomptable(Request $req, AdjustmentExtracomptable $adjustment)
    {
        $is_edit = (bool) $adjustment->exists;
        $this->validate($req, [
            // 'kd_adjustment' => 'required|unique:adjustment_extracomptable,kd_adjustment'.($is_edit? ','.$adjustment->id : ''),
            'id_gedung' => 'required|exists:gedung,id',
            'lantai' => 'required',
            'id_ruang' => 'required|exists:ruang,id',
            // 'tanggal' => 'required|date',
            // 'note' => 'required',
            'items' => 'required|array|min:1',
            'items.*.id_subjenis' => 'required|exists:subjenis_extracomptable,id',
            'items.*.new_qty' => 'required|numeric',
            'items.*.description' => 'present',
        ]);

        $ruang = Ruang::find($req->get('id_ruang'));
        $items = $req->get('items');
        $items = array_map(function($item) use ($ruang, $is_edit, $adjustment) {
            $subjenis = SubJenisExtracomptable::find($item['id_subjenis']);
            if ($is_edit) {
                $itemAdj = $adjustment->items()->where('id_subjenis', $subjenis->getKey())->first();
                $item['current_qty'] = $itemAdj? $itemAdj->current_qty : $subjenis->list_assets()->atRuang($ruang)->count();
            } else {
                $item['current_qty'] = $subjenis->list_assets()->atRuang($ruang)->count();
            }
            return $item;
        }, $items);

        $adjustment->kd_adjustment = AdjustmentExtracomptable::generateKodeAdjustment();
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
