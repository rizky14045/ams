<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Concerns\AssetUtils;
use App\Models\AdjustmentExtracomptable;
use App\Models\AssetExtracomptable;
use App\Models\CheckoutExtracomptable;
use App\Models\Gedung;
use App\Models\ItemAdjustmentExtracomptable;
use App\Models\ItemCheckoutExtracomptable;
use App\Models\JenisExtracomptable;
use App\Models\Karyawan;
use App\Models\Ruang;
use App\Models\SubJenisExtracomptable;
use Illuminate\Http\Request;

class AssetExtracomptableController extends ApiController
{
    use AssetUtils;

    protected $model = 'App\Models\AssetExtracomptable';

    public function getList(Request $req)
    {
        $query = AssetExtracomptable::with(['gedung', 'ruang', 'jenis', 'subjenis'])->orderBy('id', 'desc');
        return $this->listOf($query, $req, [
            'selectables' => [
                'id_gedung',
                'lantai',
                'id_ruang',
                'id_jenis',
                'id_subjenis',
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
        $query = AssetExtracomptable::with(['gedung', 'ruang', 'jenis', 'subjenis'])->where('id', $id);
        return $this->detailOf($query, $req, [
            'selectables' => [
                'id_gedung',
                'lantai',
                'id_ruang',
                'id_jenis',
                'id_subjenis',
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

    public function postCreate(Request $req)
    {
        $asset = new AssetExtracomptable;
        $saved = $this->saveAssetExtracomptable($req, $asset);
        if (!$saved) {
            return $this->apiError('error_create_asset_extracomptable', 500);
        }

        return $this->apiSuccess(compact('asset'));
    }

    public function postEdit(Request $req, $id)
    {
        $asset = AssetExtracomptable::findOrfail($id);
        $saved = $this->saveAssetExtracomptable($req, $asset);
        if (!$saved) {
            return $this->apiError('error_update_asset_extracomptable', 500);
        }

        return $this->apiSuccess(compact('asset'));
    }

    protected function resolveAsset(AssetExtracomptable $asset)
    {
        return array_merge($asset->toArray(), [
            'url_gambar' => $asset->urlGambar()
        ]);
    }

    protected function saveAssetExtracomptable(Request $req, AssetExtracomptable $asset)
    {
        $is_edit = (bool) $asset->exists;
        $list_status = array_map(function($status) {
            return $status['value'];
        }, config('asset.status_extracomptable'));

        $this->validate($req, [
            'id_gedung' => 'required|exists:gedung,id',
            'lantai' => 'required',
            'id_ruang' => 'required|exists:ruang,id',
            'id_jenis' => 'required|exists:jenis_extracomptable,id',
            'id_subjenis' => 'required|exists:subjenis_extracomptable,id',
            'kd_asset' => 'required|unique:asset_extracomptable,kd_asset'.($is_edit? ','.$asset->id : ''),
            'nama_asset' => 'required',
            'tgl_masuk' => 'required|date',
            'status' => 'required|in:'.implode(',', $list_status),
            'gambar' => 'required|image',
            // 'ref_id_request' => '',
        ]);

        $path = public_path('uploads/assets-extracomptable');
        $gambar = $req->file('gambar');
        $ext = $gambar->getClientOriginalExtension();
        $filename = implode('-', [md5($req->get('kd_asset')), date('ymd'), uniqid()]).'.'.$ext;
        $gambar->move($path, $filename);

        $asset->id_gedung = $req->get('id_gedung');
        $asset->lantai = $req->get('lantai');
        $asset->id_ruang = $req->get('id_ruang');
        $asset->id_jenis = $req->get('id_jenis');
        $asset->id_subjenis = $req->get('id_subjenis');
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
        $asset = AssetExtracomptable::with(['jenis', 'subjenis', 'gedung', 'ruang'])
            ->where('kd_asset', $kd_asset)
            ->firstOrFail();

        return [
            'asset' => array_merge($asset->toArray(), ['id_asset' => $asset->id])
        ];
    }

    public function jsonGetKodeAsset(Request $req)
    {
        $this->validate($req, [
            'id_gedung' => 'required|exists:gedung,id',
            'lantai' => 'required',
            'id_ruang' => 'required|exists:ruang,id',
            'id_jenis' => 'required|exists:jenis_extracomptable,id',
            'id_subjenis' => 'required|exists:subjenis_extracomptable,id',
        ]);

        $id_gedung = $req->get('id_gedung');
        $lantai = $req->get('lantai');
        $id_ruang = $req->get('id_ruang');
        $id_jenis = $req->get('id_jenis');
        $id_subjenis = $req->get('id_subjenis');

        $gedung = Gedung::findOrfail($id_gedung);
        $ruang = Ruang::findOrfail($id_ruang);
        $jenis = JenisExtracomptable::findOrfail($id_jenis);
        $subjenis = SubJenisExtracomptable::findOrfail($id_subjenis);

        $kode_asset = AssetExtracomptable::generateKodeAsset(
            $gedung,
            $lantai,
            $ruang,
            $jenis,
            $subjenis
        );

        return [
            'kode_asset' => $kode_asset
        ];
    }

    public function getQuantity(Request $req)
    {
        $this->validate($req, [
            'id_ruang' => 'required|exists:ruang,id',
            'id_subjenis' => 'required|exists:subjenis_extracomptable,id'
        ]);

        $id_ruang = $req->get('id_ruang');
        $id_subjenis = $req->get('id_subjenis');

        $ruang = Ruang::findOrFail($id_ruang);
        $subjenis = SubJenisExtracomptable::findOrFail($id_subjenis);

        $qty = $subjenis->list_assets()->atRuang($ruang)->count();

        return $this->apiSuccess(['qty' => $qty]);
    }

    public function getHistoryCheckout(Request $req, $kodeAsset)
    {
        $asset = $this->findOrFailByKode($kodeAsset);
        $tableCheckout = (new CheckoutExtracomptable)->getTable();
        $tableCheckoutItem = (new ItemCheckoutExtracomptable)->getTable();
        $historyCheckout = ItemCheckoutExtracomptable::where('id_asset', $asset->getKey())
        ->join($tableCheckout, "{$tableCheckout}.id", "=", "{$tableCheckoutItem}.id_checkout")
        ->select(["{$tableCheckout}.*"])
        ->orderBy("{$tableCheckout}.tanggal", "desc")
        ->get()
        ->toArray();

        $historyCheckout = array_map(function($row) {
            $row['gedung'] = Gedung::find($row['id_gedung']);
            $row['ruang'] = Ruang::find($row['id_ruang']);
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
        return AssetExtracomptable::where('kd_asset', $kodeAsset)->firstOrFail();
    }

}
