<?php

namespace App\Http\Controllers;

use App\Models\JenisExtracomptable;
use Illuminate\Http\Request;

class JenisExtracomptableController extends Controller
{

    /**
     * Mengambil opsi jenis extracomptable
     */
    public function jsonGetOptionsJenis()
    {
        return [
            'list_jenis' => JenisExtracomptable::orderBy('nama', 'asc')->get()->toArray()
        ];
    }

    /**
     * Mengambil opsi subjenis extracomptable
     */
    public function jsonGetOptionsSubjenis(Request $req)
    {
        $this->validate($req, [
            'id_jenis' => 'required|exists:jenis_extracomptable,id'
        ]);

        $id_jenis = $req->get('id_jenis');
        $jenis = JenisExtracomptable::findOrFail($id_jenis);

        return [
            'list_subjenis' => $jenis->list_subjenis()->orderBy('nama', 'asc')->get()->toArray()
        ];
    }

}
