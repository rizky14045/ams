<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\CheckoutAktivaTetap;
use App\Models\Gedung;
use App\Models\ModelAktivaTetap;
use App\Models\Ruang;
use Illuminate\Http\Request;

class CheckoutAktivaTetapController extends ApiController
{

    public function getList(Request $req)
    {
        $query = CheckoutAktivaTetap::with(['items'])->orderBy('id', 'desc');
        return $this->listOf($query, $req, [
            'selectables' => [
                'kd_checkout',
                'nik_karyawan',
                'tanggal',
                'note',
                'lokasi',
            ],
            'filter' => function($query, $keyword) {
                $query->where('kd_checkout', 'like', "%{$keyword}%");
                $query->orWhere('lokasi', 'like', "%{$keyword}%");
            },
            'map' => function($checkout) {
                return $this->resolveCheckout($checkout);
            }
        ]);
    }

    public function getDetail(Request $req, $id)
    {
        $query = CheckoutAktivaTetap::with([
            'items',
            'items.asset'
        ])->where('id', $id);
        return $this->detailOf($query, $req, [
            'selectables' => [
                'kd_checkout',
                'nik_karyawan',
                'tanggal',
                'note',
                'lokasi',
            ],
            'resolve' => function($checkout) {
                return $this->resolveCheckout($checkout);
            }
        ]);
    }

    protected function resolveCheckout(CheckoutAktivaTetap $checkout)
    {
        return $checkout;
    }

    public function postCreate(Request $req)
    {
        $checkout = new CheckoutAktivaTetap;
        $saved = $this->saveCheckoutAktivaTetap($req, $checkout);

        if (!$saved) {
            return $this->apiError('error_create_checkout_aktiva_tetap', 500);
        }

        return $this->apiSuccess(compact('checkout'));
    }

    public function postEdit(Request $req, $id)
    {
        $checkout = CheckoutAktivaTetap::findOrfail($id);
        $saved = $this->saveCheckoutAktivaTetap($req, $checkout);

        if (!$saved) {
            return $this->apiError('error_update_checkout_aktiva_tetap', 500);
        }

        return $this->apiSuccess(compact('checkout'));
    }

    protected function saveCheckoutAktivaTetap(Request $req, CheckoutAktivaTetap $checkout)
    {
        $is_edit = (bool) $checkout->exists;
        $this->validate($req, [
            // 'kd_checkout' => 'required|unique:checkout_aktiva_tetap,kd_checkout'.($is_edit? ','.$checkout->id : ''),
            // 'nik_karyawan' => 'required|exists:karyawan,nik',
            // 'tanggal' => 'required|date',
            // 'note' => 'required',
            'lokasi' => 'required',
            'items' => 'required|array|min:1',
            'items.*.id_asset' => 'required|exists:asset_aktiva_tetap,id',
            // 'ref_id_checkout' => '',
        ]);

        $items = $req->get('items');

        $checkout->kd_checkout = CheckoutAktivaTetap::generateKodeCheckout();
        $checkout->nik_karyawan = $this->getUserNik();
        $checkout->tanggal = $req->get('tanggal');
        $checkout->note = $req->get('note') ?: '';
        $checkout->lokasi = $req->get('lokasi');
        $checkout_saved = $checkout->save();
        $items_synced = $checkout->syncItems($items);

        return $checkout_saved AND $items_synced;
    }
}
