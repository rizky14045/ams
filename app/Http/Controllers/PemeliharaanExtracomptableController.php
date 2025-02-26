<?php

namespace App\Http\Controllers;

use App\Models\PemeliharaanExtracomptable;
use App\Models\Gedung;
use App\Models\JenisExtracomptable;
use App\Models\Ruang;
use App\Models\SubJenisExtracomptable;
use Illuminate\Http\Request;

class PemeliharaanExtracomptableController extends Controller
{

    public function postCreate(Request $req)
    {
        $pemeliharaan = new PemeliharaanExtracomptable;
        $action = $req->get('action');
        $saved = $this->savePemeliharaan($req, $pemeliharaan);
        if (!$saved) {
            return redirect()->route('AdminPemeliharaanExtracomptableControllerGetAdd')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminPemeliharaanExtracomptableControllerGetIndex');
    }

    public function postEdit(Request $req, $id)
    {
        $pemeliharaan = PemeliharaanExtracomptable::findOrfail($id);
        $saved = $this->savePemeliharaan($req, $pemeliharaan);
        if (!$saved) {
            return redirect()->route('AdminPemeliharaanExtracomptableControllerGetEdit')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminPemeliharaanExtracomptableControllerGetIndex');
    }

    protected function savePemeliharaan(Request $req, PemeliharaanExtracomptable $pemeliharaan)
    {
        $is_edit = (bool) $pemeliharaan->exists;
        $this->validate($req, [
            'kd_pemeliharaan' => 'required|unique:pemeliharaan_extracomptable,kd_pemeliharaan'.($is_edit? ','.$pemeliharaan->id : ''),
            'nik_karyawan' => 'required|exists:karyawan,nik',
            'id_jenis_pemeliharaan' => 'required',
            'id_gedung' => 'required|exists:gedung,id',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'lantai' => 'required',
            'note' => 'required',
            'id_ruang' => 'required|exists:ruang,id',
            'items' => 'required|array|min:1',
            'items.*.id_asset' => 'required|exists:asset_extracomptable,id',
            // 'ref_id_pemeliharaan' => '',
        ]);

        $items = $req->get('items');

        $pemeliharaan->kd_pemeliharaan = $req->get('kd_pemeliharaan');
        $pemeliharaan->nik_karyawan = $req->get('nik_karyawan');
        $pemeliharaan->id_jenis_pemeliharaan = $req->get('id_jenis_pemeliharaan');
        $pemeliharaan->tgl_mulai = $req->get('tgl_mulai');
        $pemeliharaan->tgl_selesai = $req->get('tgl_selesai');
        $pemeliharaan->note = $req->get('note') ?: '';
        $pemeliharaan->id_gedung = $req->get('id_gedung');
        $pemeliharaan->lantai = $req->get('lantai');
        $pemeliharaan->id_ruang = $req->get('id_ruang');
        $pemeliharaan_saved = $pemeliharaan->save();
        $items_synced = $pemeliharaan->syncItems($items);

        return $pemeliharaan_saved AND $items_synced;
    }
}
