<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Concerns\AssetUtils;
use App\Models\AssetInventory;
use App\Models\CheckoutInventory;
use App\Models\Gedung;
use App\Models\ItemCheckoutInventory;
use App\Models\Karyawan;
use App\Models\KategoriInventory;
use App\Models\Ruang;
use Illuminate\Http\Request;

class AssetInventoryController extends ApiController
{
    use AssetUtils;

    protected $model = 'App\Models\AssetInventory';

    public function getList(Request $req)
    {
        $query = AssetInventory::with(['kategori', 'ruang', 'gedung'])->orderBy('id', 'desc');
        return $this->listOf($query, $req, [
            'selectables' => [
                'id_gedung',
                'lantai',
                'id_ruang',
                'id_kategori',
                'kd_asset',
                'nama_asset',
                'jumlah',
                'jumlah_minimum',
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
        $query = AssetInventory::with(['gedung', 'ruang', 'kategori'])->where('id', $id);
        return $this->detailOf($query, $req, [
            'selectables' => [
                'id_gedung',
                'lantai',
                'id_ruang',
                'id_kategori',
                'kd_asset',
                'nama_asset',
                'jumlah',
                'jumlah_minimum',
                'gambar',
            ],
            'resolve' => function($asset) {
                return $this->resolveAsset($asset);
            }
        ]);
    }

    protected function resolveAsset(AssetInventory $asset)
    {
        return array_merge($asset->toArray(), [
            'url_gambar' => $asset->urlGambar()
        ]);
    }

    public function postCreate(Request $req)
    {
        $asset = new AssetInventory;
        $saved = $this->saveAssetInventory($req, $asset);

        if (!$saved) {
            return $this->apiError('error_create_asset_inventory', 500);
        }

        return $this->apiSuccess(compact('asset'));
    }

    public function postEdit(Request $req, $id)
    {
        $asset = AssetInventory::findOrfail($id);
        $saved = $this->saveAssetInventory($req, $asset);
        if (!$saved) {
            return $this->apiError('error_update_asset_inventory', 500);
        }

        return $this->apiSuccess(compact('asset'));
    }

    protected function saveAssetInventory(Request $req, AssetInventory $asset)
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
        return $asset->save();
    }

    public function jsonGetDetailAsset(Request $req, $kd_asset)
    {
        $asset = AssetInventory::with(['kategori', 'gedung', 'ruang'])
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

    public function getQuantity(Request $req)
    {
        $this->validate($req, [
            'id_asset' => 'required|exists:asset_inventory,id',
        ]);

        $asset = AssetInventory::findOrfail($req->get('id_asset'));

        return $this->apiSuccess([
            'qty' => (int) $asset->jumlah
        ]);
    }

    public function getHistoryCheckout(Request $req, $kodeAsset)
    {
        $asset = $this->findOrFailByKode($kodeAsset);
        $tableCheckout = (new CheckoutInventory)->getTable();
        $tableCheckoutItem = (new ItemCheckoutInventory)->getTable();
        $historyCheckout = ItemCheckoutInventory::where('id_asset', $asset->getKey())
        ->join($tableCheckout, "{$tableCheckout}.id", "=", "{$tableCheckoutItem}.id_checkout")
        ->select([
            "{$tableCheckout}.*",
            "{$tableCheckoutItem}.jumlah"
        ])
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
        return AssetInventory::where('kd_asset', $kodeAsset)->firstOrFail();
    }

}
