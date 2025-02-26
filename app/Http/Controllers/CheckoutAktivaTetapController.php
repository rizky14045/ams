<?php

namespace App\Http\Controllers;

use App\Models\CheckoutAktivaTetap;
use App\Models\Gedung;
use App\Models\ModelAktivaTetap;
use App\Models\Ruang;
use Illuminate\Http\Request;

class CheckoutAktivaTetapController extends Controller
{

    public function postCreate(Request $req)
    {
        $checkout = new CheckoutAktivaTetap;
        $action = $req->get('action');
        $saved = $this->saveCheckout($req, $checkout);
        if (!$saved) {
            return redirect()->route('AdminCheckoutAktivaTetapControllerGetAdd')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminCheckoutAktivaTetapControllerGetIndex');
    }

    public function postEdit(Request $req, $id)
    {
        $checkout = CheckoutAktivaTetap::findOrfail($id);
        $saved = $this->saveCheckout($req, $checkout);
        if (!$saved) {
            return redirect()->route('AdminCheckoutAktivaTetapControllerGetEdit')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminCheckoutAktivaTetapControllerGetIndex');
    }

    protected function saveCheckout(Request $req, CheckoutAktivaTetap $checkout)
    {
        $is_edit = (bool) $checkout->exists;
        $this->validate($req, [
            'kd_checkout' => 'required|unique:checkout_aktiva_tetap,kd_checkout'.($is_edit? ','.$checkout->id : ''),
            'nik_karyawan' => 'required|exists:karyawan,nik',
            'tanggal' => 'required|date',
            'note' => 'required',
            'lokasi' => 'required',
            'items' => 'required|array|min:1',
            'items.*.id_asset' => 'required|exists:asset_aktiva_tetap,id',
            // 'ref_id_checkout' => '',
        ]);

        $items = $req->get('items');

        $checkout->kd_checkout = $req->get('kd_checkout');
        $checkout->nik_karyawan = $req->get('nik_karyawan');
        $checkout->tanggal = $req->get('tanggal');
        $checkout->note = $req->get('note') ?: '';
        $checkout->lokasi = $req->get('lokasi');
        $checkout_saved = $checkout->save();
        $items_synced = $checkout->syncItems($items);

        return $checkout_saved AND $items_synced;
    }

    public function getJsonDetail(Request $req, $id)
    {
        $checkout = CheckoutAktivaTetap::with([
            'items',
            'items.asset'
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
        $checkout = CheckoutAktivaTetap::findOrfail($id);
        $checkout->approved_at = date('Y-m-d H:i:s');
        $checkout->approved_by = \CB::myId();
        $checkout->save();

        $movedAssets = $checkout->moveAssetsLocation();

        foreach ($movedAssets as $asset) {
            $asset->logCheckout(\CB::myId(), [
                'checkout' => $checkout->toArray()
            ]);
        }

        return redirect()->route('AdminCheckoutAktivaTetapControllerGetIndex')->with([
            'message_type' => 'success',
            'message' => 'Data checkout "'.$checkout->kd_checkout.'" telah di approve',
        ]);
    }
}
