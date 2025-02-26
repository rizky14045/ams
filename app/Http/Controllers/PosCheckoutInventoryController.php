<?php

namespace App\Http\Controllers;

use App\Models\CheckoutInventory;
use App\Models\Gedung;
use App\Models\KategoriInventory;
use App\Models\Ruang;
use Illuminate\Http\Request;

class PosCheckoutInventoryController extends Controller
{

    public function postCreate(Request $req)
    {
        $checkout = new CheckoutInventory;
        $action = $req->get('action');
        $saved = $this->saveCheckout($req, $checkout);
        if (!$saved) {
            return redirect()->route('AdminPosCheckoutControllerGetAdd')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminPosCheckoutControllerGetIndex');
    }

    public function postEdit(Request $req, $id)
    {
        $checkout = CheckoutInventory::findOrfail($id);
        $saved = $this->saveCheckout($req, $checkout);
        if (!$saved) {
            return redirect()->route('AdminPosCheckoutControllerGetEdit')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminPosCheckoutControllerGetIndex');
    }

    protected function saveCheckout(Request $req, CheckoutInventory $checkout)
    {
        $is_edit = (bool) $checkout->exists;
        $this->validate($req, [
            'kd_checkout' => 'required|unique:checkout_inventory,kd_checkout'.($is_edit? ','.$checkout->id : ''),
            'nik_karyawan' => 'required|exists:karyawan,nik',
            'id_gedung' => 'required|exists:gedung,id',
            'tanggal' => 'required|date',
            'lantai' => 'required',
            'note' => 'required',
            'id_ruang' => 'required|exists:ruang,id',
            'items' => 'required|array|min:1',
            'items.*.id_asset' => 'required|exists:asset_inventory,id',
            // 'ref_id_checkout' => '',
        ]);

        $items = $req->get('items');

        if ($is_edit) {
            // ini untuk nyimpan sementara (ke memory)
            // data saat ini (sebelum di update)
            // untuk keperluan syncItems
            $checkout->saveCurrentState();
        }

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

    public function getJsonDetail(Request $req, $id)
    {
        $checkout = CheckoutInventory::with([
            'items',
            'items.asset',
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
        $checkout = CheckoutInventory::findOrfail($id);
        $checkout->approved_at = date('Y-m-d H:i:s');
        $checkout->approved_by = \CB::myId();
        $checkout->save();

        return redirect()->route('AdminPosCheckoutControllerGetIndex')->with([
            'message_type' => 'success',
            'message' => 'Data checkout "'.$checkout->kd_checkout.'" telah di approve',
        ]);
    }
}
