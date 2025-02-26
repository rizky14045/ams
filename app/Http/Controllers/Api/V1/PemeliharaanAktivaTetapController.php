<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\PemeliharaanAktivaTetap;
use Illuminate\Http\Request;

class PemeliharaanAktivaTetapController extends ApiController
{

    public function getList(Request $req)
    {
        $query = PemeliharaanAktivaTetap::with([
            'items',
            'items.asset',
            'jenis_pemeliharaan',
        ]);

        return $this->listOf($query, $req, [
            'selectables' => [
                'kd_pemeliharaan',
                'nik_karyawan',
                'id_jenis_pemeliharaan',
                'tgl_mulai',
                'tgl_selesai',
                'lokasi',
                'note',
            ],
            'filter' => function($query, $keyword) {
                $query->where('kd_pemeliharaan', 'like', "%{$keyword}%");
            },
            'map' => function($pemeliharaan) {
                return $this->resolvePemeliharaan($pemeliharaan);
            }
        ]);
    }

    public function getDetail(Request $req, $id)
    {
        $query = PemeliharaanAktivaTetap::with([
            'items',
            'items.asset',
            'jenis_pemeliharaan',
        ])->where('id', $id);
        return $this->detailOf($query, $req, [
            'selectables' => [
                'kd_pemeliharaan',
                'nik_karyawan',
                'id_jenis_pemeliharaan',
                'tgl_mulai',
                'tgl_selesai',
                'lokasi',
                'note',
            ],
            'resolve' => function($pemeliharaan) {
                return $this->resolvePemeliharaan($pemeliharaan);
            }
        ]);
    }

    protected function resolvePemeliharaan(PemeliharaanAktivaTetap $pemeliharaan)
    {
        return $pemeliharaan;
    }

    public function postCreate(Request $req)
    {
        $pemeliharaan = new PemeliharaanAktivaTetap;
        $saved = $this->savePemeliharaan($req, $pemeliharaan);

        if (!$saved) {
            return $this->apiError('error_create_pemeliharaan_aktiva_tetap', 500);
        }

        return $this->apiSuccess(compact('pemeliharaan'));
    }

    public function postEdit(Request $req, $id)
    {
        $pemeliharaan = PemeliharaanAktivaTetap::findOrfail($id);
        $saved = $this->savePemeliharaan($req, $pemeliharaan);

        if (!$saved) {
            return $this->apiError('error_update_pemeliharaan_aktiva_tetap', 500);
        }

        return $this->apiSuccess(compact('pemeliharaan'));
    }

    protected function savePemeliharaan(Request $req, PemeliharaanAktivaTetap $pemeliharaan)
    {
        $is_edit = (bool) $pemeliharaan->exists;
        $this->validate($req, [
            'kd_pemeliharaan' => 'required|unique:pemeliharaan_aktiva_tetap,kd_pemeliharaan'.($is_edit? ','.$pemeliharaan->id : ''),
            // 'nik_karyawan' => 'required|exists:karyawan,nik',
            'id_jenis_pemeliharaan' => 'required',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'lokasi' => 'required',
            'note' => 'required',
            'items' => 'required|array|min:1',
            'items.*.id_asset' => 'required|exists:asset_aktiva_tetap,id',
            // 'ref_id_pemeliharaan' => '',
        ]);

        $items = $req->get('items');

        $pemeliharaan->kd_pemeliharaan = $req->get('kd_pemeliharaan');
        $pemeliharaan->nik_karyawan = $this->getUserNik();
        $pemeliharaan->id_jenis_pemeliharaan = $req->get('id_jenis_pemeliharaan');
        $pemeliharaan->tgl_mulai = $req->get('tgl_mulai');
        $pemeliharaan->tgl_selesai = $req->get('tgl_selesai');
        $pemeliharaan->note = $req->get('note') ?: '';
        $pemeliharaan->lokasi = $req->get('lokasi');
        $pemeliharaan_saved = $pemeliharaan->save();
        $items_synced = $pemeliharaan->syncItems($items);

        return $pemeliharaan_saved AND $items_synced;
    }
}
