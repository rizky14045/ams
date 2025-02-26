<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\CheckoutExtracomptable;
use App\Models\Gedung;
use App\Models\JenisExtracomptable;
use App\Models\Ruang;
use App\Models\SubJenisExtracomptable;
use Illuminate\Http\Request;

class CheckoutExtracomptableController extends ApiController
{

    public function getList(Request $req)
    {
        $query = CheckoutExtracomptable::with([
            'items',
            'gedung',
            'ruang'
        ])
        ->orderBy('id', 'desc');

        return $this->listOf($query, $req, [
            'selectables' => [
                'kd_checkout',
                'nik_karyawan',
                'id_gedung',
                'tanggal',
                'lantai',
                'note',
                'id_ruang',
            ],
            'filter' => function($query, $keyword) {
                $query->where('kd_checkout', 'like', "%{$keyword}%");
                $query->orWhere('note', 'like', "%{$keyword}%");
            },
            'map' => function($checkout) {
                return $this->resolveCheckout($checkout);
            }
        ]);
    }

    public function getDetail(Request $req, $id)
    {
        $query = CheckoutExtracomptable::with([
            'ruang',
            'gedung',
            'items',
            'items.asset',
            'items.asset.gedung',
            'items.asset.ruang',
        ])->where('id', $id);
        return $this->detailOf($query, $req, [
            'selectables' => [
                'kd_checkout',
                'nik_karyawan',
                'id_gedung',
                'tanggal',
                'lantai',
                'note',
                'id_ruang',
            ],
            'resolve' => function($checkout) {
                return $this->resolveCheckout($checkout);
            }
        ]);
    }

    protected function resolveCheckout(CheckoutExtracomptable $checkout)
    {
        return $checkout;
    }

    public function postCreate(Request $req)
    {
        $checkout = new CheckoutExtracomptable;
        $saved = $this->saveCheckoutExtracomptable($req, $checkout);

        if (!$saved) {
            return $this->apiError('error_create_checkout_extracomptable', 500);
        }

        return $this->apiSuccess(compact('checkout'));
    }

    public function postEdit(Request $req, $id)
    {
        $checkout = CheckoutExtracomptable::findOrfail($id);
        $saved = $this->saveCheckoutExtracomptable($req, $checkout);

        if (!$saved) {
            return $this->apiError('error_update_checkout_extracomptable', 500);
        }

        return $this->apiSuccess(compact('checkout'));
    }

    protected function saveCheckoutExtracomptable(Request $req, CheckoutExtracomptable $checkout)
    {
        $is_edit = (bool) $checkout->exists;
        $this->validate($req, [
            // 'kd_checkout' => 'required|unique:checkout_extracomptable,kd_checkout'.($is_edit? ','.$checkout->id : ''),
            // 'nik_karyawan' => 'required|exists:karyawan,nik',
            'id_gedung' => 'required|exists:gedung,id',
            // 'tanggal' => 'required|date',
            'lantai' => 'required',
            // 'note' => 'required',
            'id_ruang' => 'required|exists:ruang,id',
            'items' => 'required|array|min:1',
            'items.*.id_asset' => 'required|exists:asset_extracomptable,id',
            // 'ref_id_checkout' => '',
        ]);

        $items = $req->get('items');

        $checkout->kd_checkout = CheckoutExtracomptable::generateKodeCheckout();
        $checkout->nik_karyawan = $this->getUserNik();
        $checkout->tanggal = $req->get('tanggal') ?: date('Y-m-d');
        $checkout->note = $req->get('note') ?: '';
        $checkout->id_gedung = $req->get('id_gedung');
        $checkout->lantai = $req->get('lantai');
        $checkout->id_ruang = $req->get('id_ruang');
        $checkout_saved = $checkout->save();
        $items_synced = $checkout->syncItems($items);

        return $checkout_saved AND $items_synced;
    }
}
