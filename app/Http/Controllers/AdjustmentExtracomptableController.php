<?php

namespace App\Http\Controllers;

use App\Models\AdjustmentExtracomptable;
use App\Models\Gedung;
use App\Models\JenisExtracomptable;
use App\Models\Ruang;
use App\Models\SubJenisExtracomptable;
use Illuminate\Http\Request;

class AdjustmentExtracomptableController extends Controller
{

    public function postCreate(Request $req)
    {
        $adjustment = new AdjustmentExtracomptable;
        $action = $req->get('action');
        $saved = $this->saveAdjustment($req, $adjustment);
        if (!$saved) {
            return redirect()->route('AdminAdjustmentExtracomptableControllerGetAdd')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminAdjustmentExtracomptableControllerGetIndex');
    }

    public function postEdit(Request $req, $id)
    {
        $adjustment = AdjustmentExtracomptable::findOrfail($id);
        $saved = $this->saveAdjustment($req, $adjustment);
        if (!$saved) {
            return redirect()->route('AdminAdjustmentExtracomptableControllerGetEdit')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminAdjustmentExtracomptableControllerGetIndex');
    }

    protected function saveAdjustment(Request $req, AdjustmentExtracomptable $adjustment)
    {
        $is_edit = (bool) $adjustment->exists;
        $this->validate($req, [
            'kd_adjustment' => 'required|unique:adjustment_extracomptable,kd_adjustment'.($is_edit? ','.$adjustment->id : ''),
            'id_gedung' => 'required|exists:gedung,id',
            'lantai' => 'required',
            'id_ruang' => 'required|exists:ruang,id',
            'tanggal' => 'required|date',
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
