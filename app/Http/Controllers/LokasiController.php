<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use Illuminate\Http\Request;

class LokasiController extends Controller
{

    /**
     * Mengambil opsi list gedung
     */
    public function jsonGetOptionsGedung()
    {
        return [
            'list_gedung' => Gedung::orderBy('nama', 'asc')->get()->toArray()
        ];
    }

    /**
     * Mengambil opsi list lantai pada gedung tertentu
     */
    public function jsonGetOptionsLantai(Request $req)
    {
        $this->validate($req, [
            'id_gedung' => 'required|exists:gedung,id'
        ]);

        $id_gedung = $req->get('id_gedung');
        $gedung = Gedung::findOrFail($id_gedung);

        return [
            'list_lantai' => $gedung->getListLantai()
        ];
    }

    /**
     * Mengambil opsi ruang pada gedung dan lantai tertentu
     */
    public function jsonGetOptionsRuang(Request $req)
    {
        $this->validate($req, [
            'id_gedung' => 'required|exists:gedung,id',
        ]);

        $id_gedung = $req->get('id_gedung');
        $lantai = $req->get('lantai');

        $gedung = Gedung::findOrFail($id_gedung);
        $query_ruang = $gedung->list_ruang();

        if ($lantai) {
            $query_ruang->lantai($lantai);
        }

        $list_ruang = $query_ruang->orderBy('nama_ruang', 'asc')->get();

        return [
            'list_ruang' => $list_ruang->toArray()
        ];
    }

}
