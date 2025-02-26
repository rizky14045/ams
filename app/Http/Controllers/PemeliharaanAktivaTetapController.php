<?php

namespace App\Http\Controllers;

use App\Models\PemeliharaanAktivaTetap;
use Illuminate\Http\Request;

class PemeliharaanAktivaTetapController extends Controller
{

    public function postCreate(Request $req)
    {
        $pemeliharaan = new PemeliharaanAktivaTetap;
        $action = $req->get('action');
        $saved = $this->savePemeliharaan($req, $pemeliharaan);
        if (!$saved) {
            return redirect()->route('AdminPemeliharaanAktivaTetapControllerGetAdd')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminPemeliharaanAktivaTetapControllerGetIndex');
    }

    public function postEdit(Request $req, $id)
    {
        $pemeliharaan = PemeliharaanAktivaTetap::findOrfail($id);
        $saved = $this->savePemeliharaan($req, $pemeliharaan);
        if (!$saved) {
            return redirect()->route('AdminPemeliharaanAktivaTetapControllerGetEdit')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminPemeliharaanAktivaTetapControllerGetIndex');
    }

    protected function savePemeliharaan(Request $req, PemeliharaanAktivaTetap $pemeliharaan)
    {
        $is_edit = (bool) $pemeliharaan->exists;
        $this->validate($req, [
            'kd_pemeliharaan' => 'required|unique:pemeliharaan_aktiva_tetap,kd_pemeliharaan'.($is_edit? ','.$pemeliharaan->id : ''),
            'nik_karyawan' => 'required|exists:karyawan,nik',
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
        $pemeliharaan->nik_karyawan = $req->get('nik_karyawan');
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
