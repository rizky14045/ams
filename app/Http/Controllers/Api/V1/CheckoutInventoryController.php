<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\CheckoutInventory;
use App\Models\Gedung;
use App\Models\KategoriInventory;
use App\Models\Ruang;
use Illuminate\Http\Request;

class CheckoutInventoryController extends ApiController
{

    public function getList(Request $req)
    {
        $query = CheckoutInventory::with(['items', 'gedung', 'ruang'])->orderBy('id', 'desc');
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
        $query = CheckoutInventory::with([
            'items',
            'items.asset',
            'items.asset.gedung',
            'items.asset.ruang',
            'gedung',
            'ruang'
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

    protected function resolveCheckout(CheckoutInventory $checkout)
    {
        return $checkout;
    }

    public function postCreate(Request $req)
    {
        $checkout = new CheckoutInventory;
        $saved = $this->saveCheckoutInventory($req, $checkout);

        if (!$saved) {
            return $this->apiError('error_create_checkout_inventory', 500);
        }

        return $this->apiSuccess(compact('checkout'));
    }

    public function postEdit(Request $req, $id)
    {
        $checkout = CheckoutInventory::findOrfail($id);
        $saved = $this->saveCheckoutInventory($req, $checkout);

        if (!$saved) {
            return $this->apiError('error_update_checkout_inventory', 500);
        }

        return $this->apiSuccess(compact('checkout'));
    }

    protected function saveCheckoutInventory(Request $req, CheckoutInventory $checkout)
    {
        $is_edit = (bool) $checkout->exists;
        $this->validate($req, [
            // 'kd_checkout' => 'required|unique:checkout_inventory,kd_checkout'.($is_edit? ','.$checkout->id : ''),
            // 'nik_karyawan' => 'required|exists:karyawan,nik',
            'id_gedung' => 'required|exists:gedung,id',
            // 'tanggal' => 'required|date',
            'lantai' => 'required',
            // 'note' => 'required',
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

        $checkout->kd_checkout = CheckoutInventory::generateKodeCheckout();
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
