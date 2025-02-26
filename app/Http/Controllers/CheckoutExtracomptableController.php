<?php

namespace App\Http\Controllers;

use App\Models\AssetExtracomptable;
use App\Models\CheckoutExtracomptable;
use App\Models\Gedung;
use App\Models\JenisExtracomptable;
use App\Models\Ruang;
use App\Models\SubJenisExtracomptable;
use Illuminate\Http\Request;

class CheckoutExtracomptableController extends Controller
{

    public function postCreate(Request $req)
    {
        $checkout = new CheckoutExtracomptable;
        $action = $req->get('action');
        $saved = $this->saveCheckout($req, $checkout);
        if (!$saved) {
            return redirect()->route('AdminCheckoutExtracomptableControllerGetAdd')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminCheckoutExtracomptableControllerGetIndex');
    }

    public function postEdit(Request $req, $id)
    {
        $checkout = CheckoutExtracomptable::findOrfail($id);
        $saved = $this->saveCheckout($req, $checkout);
        if (!$saved) {
            return redirect()->route('AdminCheckoutExtracomptableControllerGetEdit')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminCheckoutExtracomptableControllerGetIndex');
    }

    public function getJsonDetail(Request $req, $id)
    {
        $checkout = CheckoutExtracomptable::with([
            'items',
            'items.asset',
            'items.asset.jenis',
            'items.asset.subjenis',
        ])
        ->where('id', $id)
        ->firstOrFail();

        return [
            'status' => 'success',
            'checkout' => $checkout
        ];
    }

    public function postApprove(Request $req, $id)
    {
        $checkout = CheckoutExtracomptable::findOrfail($id);
        $checkout->approved_at = date('Y-m-d H:i:s');
        $checkout->approved_by = \CB::myId();
        $checkout->save();

        $movedAssets = $checkout->moveAssetsLocation();

        foreach ($movedAssets as $asset) {
            $asset->logCheckout(\CB::myId(), [
                'checkout' => $checkout->toArray()
            ]);
        }

        return redirect()->route('AdminCheckoutExtracomptableControllerGetIndex')->with([
            'message_type' => 'success',
            'message' => 'Data checkout "'.$checkout->kd_checkout.'" telah di approve',
        ]);
    }

    protected function saveCheckout(Request $req, CheckoutExtracomptable $checkout)
    {
        $is_edit = (bool) $checkout->exists;
        $this->validate($req, [
            'kd_checkout' => 'required|unique:checkout_extracomptable,kd_checkout'.($is_edit? ','.$checkout->id : ''),
            'nik_karyawan' => 'required|exists:karyawan,nik',
            'id_gedung' => 'required|exists:gedung,id',
            'tanggal' => 'required|date',
            'lantai' => 'required',
            'note' => 'required',
            'id_ruang' => 'required|exists:ruang,id',
            'items' => 'required|array|min:1',
            'items.*.id_asset' => 'required|exists:asset_extracomptable,id',
            // 'ref_id_checkout' => '',
        ]);

        $items = $req->get('items');

        $checkout->kd_checkout = $req->get('kd_checkout');
        $checkout->nik_karyawan = $req->get('nik_karyawan');
        $checkout->tanggal = $req->get('tanggal');
        $checkout->note = $req->get('note') ?: '';
        $checkout->id_gedung = $req->get('id_gedung');
        $checkout->lantai = $req->get('lantai');
        $checkout->id_ruang = $req->get('id_ruang');
        $checkout_saved = $checkout->save();
        $items_synced = $checkout->syncItems($items);

        return $checkout_saved AND $items_synced;
    }
}
