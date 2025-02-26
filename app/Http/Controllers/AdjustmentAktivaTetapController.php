<?php

namespace App\Http\Controllers;

use App\Models\AdjustmentAktivaTetap;
use App\Models\Gedung;
use App\Models\JenisAktivaTetap;
use App\Models\Ruang;
use App\Models\ModelAktivaTetap;
use Illuminate\Http\Request;

class AdjustmentAktivaTetapController extends Controller
{

    public function postCreate(Request $req)
    {
        $adjustment = new AdjustmentAktivaTetap;
        $action = $req->get('action');
        $saved = $this->saveAdjustment($req, $adjustment);
        if (!$saved) {
            return redirect()->route('AdminAdjustmentAktivaTetapControllerGetAdd')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminAdjustmentAktivaTetapControllerGetIndex');
    }

    public function postEdit(Request $req, $id)
    {
        $adjustment = AdjustmentAktivaTetap::findOrfail($id);
        $saved = $this->saveAdjustment($req, $adjustment);
        if (!$saved) {
            return redirect()->route('AdminAdjustmentAktivaTetapControllerGetEdit')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminAdjustmentAktivaTetapControllerGetIndex');
    }

    protected function saveAdjustment(Request $req, AdjustmentAktivaTetap $adjustment)
    {
        $is_edit = (bool) $adjustment->exists;
        $this->validate($req, [
            'kd_adjustment' => 'required|unique:adjustment_aktiva_tetap,kd_adjustment'.($is_edit? ','.$adjustment->id : ''),
            'lokasi' => 'required',
            'tanggal' => 'required|date',
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

        $adjustment->kd_adjustment = $req->get('kd_adjustment');
        $adjustment->tanggal = $req->get('tanggal');
        $adjustment->note = $req->get('note') ?: '';
        $adjustment->lokasi = $req->get('lokasi');
        $adjustment_saved = $adjustment->save();
        $items_synced = $adjustment->syncItems($items);

        return $adjustment_saved AND $items_synced;
    }
}
