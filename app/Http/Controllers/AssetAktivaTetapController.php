<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\AssetUtils;
use App\Models\AssetAktivaTetap;
use App\Models\Gedung;
use App\Models\ModelAktivaTetap;
use App\Models\Ruang;
use Illuminate\Http\Request;

class AssetAktivaTetapController extends Controller
{
    use AssetUtils;

    protected $model = 'App\Models\AssetAktivaTetap';

    public function postCreate(Request $req)
    {
        $asset = new AssetAktivaTetap;
        $action = $req->get('action');
        $saved = $this->saveAsset($req, $asset);
        if (!$saved) {
            return redirect()->route('AdminAssetAktivaTetapControllerGetAdd')
                ->with('error', 'Something went wrong while saving data.');
        }

        if ($action == 'save-and-new') {
            return redirect()->route('AdminAssetAktivaTetapControllerGetAdd')->with([
                'id_model' => $asset->id_model,
                // 'kd_asset' => $asset->kd_asset,
                'nama_asset' => $asset->nama_asset,
                'tgl_masuk' => $asset->tgl_masuk,
                'status' => $asset->status,
            ]);
        } else {
            return redirect()->route('AdminAssetAktivaTetapControllerGetIndex');
        }

    }

    public function postEdit(Request $req, $id)
    {
        $asset = AssetAktivaTetap::findOrfail($id);
        $saved = $this->saveAsset($req, $asset);
        if (!$saved) {
            return redirect()->route('AdminAssetAktivaTetapControllerGetEdit')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminAssetAktivaTetapControllerGetIndex');
    }

    protected function saveAsset(Request $req, AssetAktivaTetap $asset)
    {
        $is_edit = (bool) $asset->exists;
        $list_status = array_map(function($status) {
            return $status['value'];
        }, config('asset.status_aktiva_tetap'));

        $this->validate($req, [
            'lokasi' => 'required',
            'id_model' => 'required|exists:model_aktiva_tetap,id',
            'kd_asset' => 'required|unique:asset_aktiva_tetap,kd_asset'.($is_edit? ','.$asset->id : ''),
            'nama_asset' => 'required',
            'tgl_masuk' => 'required|date',
            'status' => 'required|in:'.implode(',', $list_status),
            'gambar' => 'required|image',
            // 'ref_id_request' => '',
        ]);

        $path = public_path('uploads/assets-aktiva-tetap');
        $gambar = $req->file('gambar');
        $ext = $gambar->getClientOriginalExtension();
        $filename = implode('-', [md5($req->get('kd_asset')), date('ymd'), uniqid()]).'.'.$ext;
        $gambar->move($path, $filename);

        $asset->lokasi = $req->get('lokasi');
        $asset->id_model = $req->get('id_model');
        $asset->kd_asset = $req->get('kd_asset');
        $asset->nama_asset = $req->get('nama_asset');
        $asset->tgl_masuk = $req->get('tgl_masuk');
        $asset->status = $req->get('status');
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
        $asset = AssetAktivaTetap::with(['model'])
            ->where('kd_asset', $kd_asset)
            ->firstOrFail();

        return [
            'asset' => array_merge($asset->toArray(), ['id_asset' => $asset->id])
        ];
    }

    public function jsonGetKodeAsset(Request $req)
    {
        $this->validate($req, [
            'id_model' => 'required|exists:model_aktiva_tetap,id',
        ]);

        $id_model = $req->get('id_model');
        $model = ModelAktivaTetap::findOrfail($id_model);
        $kode_asset = AssetAktivaTetap::generateKodeAsset($model);

        return [
            'kode_asset' => $kode_asset
        ];
    }

    public function jsonGetQuantity(Request $req)
    {
        $this->validate($req, [
            'lokasi' => 'required',
            'id_model' => 'required|exists:model_aktiva_tetap,id'
        ]);

        $lokasi = $req->get('lokasi');
        $id_model = $req->get('id_model');

        $model = ModelAktivaTetap::findOrFail($id_model);
        $qty = $model->list_assets()->atLokasi($lokasi)->count();

        return [
            'qty' => (int) $qty
        ];
    }
}
