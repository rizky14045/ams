<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Concerns\AssetUtils;
use App\Models\AssetAktivaTetap;
use App\Models\CheckoutAktivaTetap;
use App\Models\Gedung;
use App\Models\ItemCheckoutAktivaTetap;
use App\Models\Karyawan;
use App\Models\ModelAktivaTetap;
use App\Models\Ruang;
use Illuminate\Http\Request;

class AssetAktivaTetapController extends ApiController
{
    use AssetUtils;

    protected $model = 'App\Models\AssetAktivaTetap';

    public function getList(Request $req)
    {
        $query = AssetAktivaTetap::with(['model'])->orderBy('id', 'desc');
        return $this->listOf($query, $req, [
            'selectables' => [
                'lokasi',
                'id_model',
                'kd_asset',
                'nama_asset',
                'tgl_masuk',
                'status',
                'gambar',
            ],
            'filter' => function($query, $keyword) {
                $query->where('kd_asset', 'like', "%{$keyword}%");
                $query->orWhere('nama_asset', 'like', "%{$keyword}%");
            },
            'map' => function($asset) {
                return $this->resolveAsset($asset);
            }
        ]);
    }

    public function getDetail(Request $req, $id)
    {
        $query = AssetAktivaTetap::with(['model'])->where('id', $id);
        return $this->detailOf($query, $req, [
            'selectables' => [
                'lokasi',
                'id_model',
                'kd_asset',
                'nama_asset',
                'tgl_masuk',
                'status',
                'gambar',
            ],
            'resolve' => function($asset) {
                return $this->resolveAsset($asset);
            }
        ]);
    }

    protected function resolveAsset(AssetAktivaTetap $asset)
    {
        return array_merge($asset->toArray(), [
            'url_gambar' => $asset->urlGambar()
        ]);
    }

    public function postCreate(Request $req)
    {
        $asset = new AssetAktivaTetap;
        $saved = $this->saveAssetAktivaTetap($req, $asset);
        if (!$saved) {
            return $this->apiError('error_create_asset_aktiva_tetap', 500);
        }

        return $this->apiSuccess(compact('asset'));
    }

    public function postEdit(Request $req, $id)
    {
        $asset = AssetAktivaTetap::findOrfail($id);
        $saved = $this->saveAssetAktivaTetap($req, $asset);
        if (!$saved) {
            return $this->apiError('error_update_asset_aktiva_tetap', 500);
        }

        return $this->apiSuccess(compact('asset'));
    }

    protected function saveAssetAktivaTetap(Request $req, AssetAktivaTetap $asset)
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
        return $asset->save();
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

    public function getQuantity(Request $req)
    {
        $this->validate($req, [
            'lokasi' => 'required',
            'id_model' => 'required|exists:model_aktiva_tetap,id'
        ]);

        $lokasi = $req->get('lokasi');
        $id_model = $req->get('id_model');

        $model = ModelAktivaTetap::findOrFail($id_model);
        $qty = $model->list_assets()->atLokasi($lokasi)->count();

        return $this->apiSuccess([
            'qty' => (int) $qty
        ]);
    }

    public function getHistoryCheckout(Request $req, $kodeAsset)
    {
        $asset = $this->findOrFailByKode($kodeAsset);
        $tableCheckout = (new CheckoutAktivaTetap)->getTable();
        $tableCheckoutItem = (new ItemCheckoutAktivaTetap)->getTable();
        $historyCheckout = ItemCheckoutAktivaTetap::where('id_asset', $asset->getKey())
        ->join($tableCheckout, "{$tableCheckout}.id", "=", "{$tableCheckoutItem}.id_checkout")
        ->select([
            "{$tableCheckout}.*"
        ])
        ->orderBy("{$tableCheckout}.tanggal", "desc")
        ->get()
        ->toArray();

        $historyCheckout = array_map(function($row) {
            $row['karyawan'] = Karyawan::where('nik', $row['nik_karyawan'])->first();
            return $row;
        }, $historyCheckout);

        $data = [
            'asset' => $this->resolveAsset($asset),
            'history_checkout' => $historyCheckout
        ];

        return $this->apiSuccess($data);
    }

    protected function findOrFailByKode($kodeAsset)
    {
        return AssetAktivaTetap::where('kd_asset', $kodeAsset)->firstOrFail();
    }

}
