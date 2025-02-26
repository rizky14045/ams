<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\AssetUtils;
use App\Models\AssetInventory;
use App\Models\Gedung;
use App\Models\KategoriInventory;
use App\Models\Ruang;
use App\Models\User;
use Illuminate\Http\Request;

class AssetInventoryController extends Controller
{
    use AssetUtils;

    protected $model = 'App\Models\AssetInventory';

    public function postCreate(Request $req)
    {
        $asset = new AssetInventory;
        $action = $req->get('action');
        $saved = $this->saveAsset($req, $asset);
        if (!$saved) {
            return redirect()->route('AdminAssetInventoryControllerGetAdd')
                ->with('error', 'Something went wrong while saving data.');
        }

        if ($action == 'save-and-new') {
            return redirect()->route('AdminAssetInventoryControllerGetAdd')->with([
                'id_gedung' => $asset->id_gedung,
                'lantai' => $asset->lantai,
                'id_ruang' => $asset->id_ruang,
                'id_kategori' => $asset->id_kategori,
                // 'kd_asset' => $asset->kd_asset,
                'nama_asset' => $asset->nama_asset,
            ]);
        } else {
            return redirect()->route('AdminAssetInventoryControllerGetIndex');
        }

    }

    public function postEdit(Request $req, $id)
    {
        $asset = AssetInventory::findOrfail($id);
        $saved = $this->saveAsset($req, $asset);
        if (!$saved) {
            return redirect()->route('AdminAssetInventoryControllerGetEdit')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminAssetInventoryControllerGetIndex');
    }

    protected function saveAsset(Request $req, AssetInventory $asset)
    {
        $is_edit = (bool) $asset->exists;
        $this->validate($req, [
            'id_gedung' => 'required|exists:gedung,id',
            'lantai' => 'required',
            'id_ruang' => 'required|exists:ruang,id',
            'id_kategori' => 'required|exists:kategori_inventory,id',
            'kd_asset' => 'required|unique:asset_inventory,kd_asset'.($is_edit? ','.$asset->id : ''),
            'nama_asset' => 'required',
            'jumlah' => 'required|numeric',
            'jumlah_minimum' => 'required|numeric',
            'gambar' => 'required|image',
            // 'ref_id_request' => '',
        ]);

        $path = public_path('uploads/assets-inventory');
        $gambar = $req->file('gambar');
        $ext = $gambar->getClientOriginalExtension();
        $filename = implode('-', [md5($req->get('kd_asset')), date('ymd'), uniqid()]).'.'.$ext;
        $gambar->move($path, $filename);

        $asset->id_gedung = $req->get('id_gedung');
        $asset->lantai = $req->get('lantai');
        $asset->id_ruang = $req->get('id_ruang');
        $asset->id_kategori = $req->get('id_kategori');
        $asset->kd_asset = $req->get('kd_asset');
        $asset->nama_asset = $req->get('nama_asset');
        $asset->jumlah = $req->get('jumlah');
        $asset->jumlah_minimum = $req->get('jumlah_minimum');
        $asset->gambar = $filename;
        $asset->ref_id_request = $req->get('ref_id_request') ?: null;
        $saved = $asset->save();

        if ($saved) {
            if ($is_edit) {
                $asset->logUpdate(\CB::me()->id);
            } else {
                $asset->logCreate(\CB::me()->id);
            }
        }

        return $saved;
    }

    public function jsonGetDetailAsset(Request $req, $kd_asset)
    {
        $asset = AssetInventory::with(['kategori', 'gedung', 'ruang'])
            ->where('kd_asset', $kd_asset)
            ->firstOrFail();

        $user = $this->getLoggedUser();
        if (!$user->hasAksesRuang($asset->ruang)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki hak akses ke data asset ini.'
            ], 403);
        }

        return [
            'asset' => array_merge($asset->toArray(), ['id_asset' => $asset->id])
        ];
    }

    protected function getLoggedUser()
    {
        return User::find(\CB::myId());
    }

    public function jsonGetKodeAsset(Request $req)
    {
        $this->validate($req, [
            'id_gedung' => 'required|exists:gedung,id',
            'lantai' => 'required',
            'id_ruang' => 'required|exists:ruang,id',
            'id_kategori' => 'required|exists:kategori_inventory,id',
        ]);

        $id_gedung = $req->get('id_gedung');
        $lantai = $req->get('lantai');
        $id_ruang = $req->get('id_ruang');
        $id_kategori = $req->get('id_kategori');

        $gedung = Gedung::findOrfail($id_gedung);
        $ruang = Ruang::findOrfail($id_ruang);
        $kategori = KategoriInventory::findOrfail($id_kategori);

        $kode_asset = AssetInventory::generateKodeAsset(
            $gedung,
            $lantai,
            $ruang,
            $kategori
        );

        return [
            'kode_asset' => $kode_asset
        ];
    }

    public function jsonGetQuantity(Request $req)
    {
        $this->validate($req, [
            'id_asset' => 'required|exists:asset_inventory,id',
        ]);

        $asset = AssetInventory::findOrfail($req->get('id_asset'));

        return [
            'qty' => (int) $asset->jumlah
        ];
    }
}
