<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\AssetUtils;
use App\Models\AssetExtracomptable;
use App\Models\Gedung;
use App\Models\JenisExtracomptable;
use App\Models\Ruang;
use App\Models\SubJenisExtracomptable;
use App\Models\User;
use App\Reports\ExcelListAssetExtracomptableByJenis;
use App\Reports\ExcelListAssetExtracomptableByLokasi;
use App\Reports\ExcelListAssetExtracomptablePerJenis;
use App\Reports\ExcelListAssetExtracomptablePerLokasi;
use App\Reports\ExcelReportExtracomptable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AssetExtracomptableController extends Controller
{
    use AssetUtils;

    protected $model = 'App\Models\AssetExtracomptable';

    public function pageReport(Request $req)
    {
        $data['page_title'] = 'Report Extra Comptable';
        return view('asset-extracomptable.page-report', $data);
    }

    public function getJsonReport(Request $req)
    {
        $limit = (int) $req->get('limit') ?: 15;
        $filter = (array) $req->get('filter');
        $id_gedung = array_get($filter, 'id_gedung');
        $lantai = array_get($filter, 'lantai');
        $id_ruang = array_get($filter, 'id_ruang');

        $query = AssetExtracomptable::queryReport($id_gedung, $lantai, $id_ruang);

        $pagination = $query->paginate($limit);

        $pagination->getCollection()->transform(function($asset) {
            return array_merge($asset->toArray(), [
                'url_detail' => route('asset-extracomptable::page-list-per-lokasi', [
                    'id_gedung' => $asset->id_gedung,
                    'lantai' => $asset->lantai,
                    'id_ruang' => $asset->id_ruang,
                ])
            ]);
        });

        return array_merge(['status' => 'success'], $pagination->toArray());
    }

    public function downloadReport(Request $req, $format)
    {
        if (!in_array($format, ['csv', 'xlsx'])) {
            return abort(404);
        }

        $id_gedung = $req->get('id_gedung');
        $lantai = $req->get('lantai');
        $id_ruang = $req->get('id_ruang');

        $excel = new ExcelReportExtracomptable($id_gedung, $lantai, $id_ruang);
        return $excel->generate()->download($format);
    }

    // ============================================================================================

    public function pageSummary(Request $req)
    {
        $data['page_title'] = 'List Asset Extra Comptable';
        return view('asset-extracomptable.page-summary', $data);
    }

    public function getJsonSummaryByJenis(Request $req)
    {
        $limit = (int) $req->get('limit') ?: 15;

        $query = AssetExtracomptable::querySummaryByJenis();

        $pagination = $query->paginate($limit);

        $pagination->getCollection()->transform(function($asset) {
            return array_merge($asset->toArray(), [
                'url_detail' => route('asset-extracomptable::page-list-per-jenis', [
                    'id_jenis' => $asset->id_jenis,
                    'id_subjenis' => $asset->id_subjenis
                ])
            ]);
        });

        return array_merge(['status' => 'success'], $pagination->toArray());
    }

    public function getJsonSummaryByLokasi(Request $req)
    {
        $limit = (int) $req->get('limit') ?: 15;

        $query = AssetExtracomptable::querySummaryByLokasi();

        $pagination = $query->paginate($limit);

        $pagination->getCollection()->transform(function($asset) {
            return array_merge($asset->toArray(), [
                'url_detail' => route('asset-extracomptable::page-list-per-lokasi', [
                    'id_gedung' => $asset->id_gedung,
                    'lantai' => $asset->lantai,
                    'id_ruang' => $asset->id_ruang,
                ])
            ]);
        });

        return array_merge(['status' => 'success'], $pagination->toArray());
    }

    public function downloadSummaryByJenis(Request $req, $format)
    {
        if (!in_array($format, ['csv', 'xlsx'])) {
            return abort(404);
        }

        $excel = new ExcelListAssetExtracomptableByJenis;
        $excel->generate()->download($format);
    }

    public function downloadSummaryByLokasi(Request $req, $format)
    {
        if (!in_array($format, ['csv', 'xlsx'])) {
            return abort(404);
        }

        $excel = new ExcelListAssetExtracomptableByLokasi;
        $excel->generate()->download($format);
    }

    public function pageListPerJenis(Request $req)
    {
        $jenis = JenisExtracomptable::findOrFail($req->get('id_jenis') ?: 0);
        $subjenis = SubJenisExtracomptable::findOrfail($req->get('id_subjenis') ?: 0);

        $data['page_title'] = "List Asset Extra Comptable";
        $data['page_subtitle'] = $subjenis->nama;
        $data['id_jenis'] = $jenis->getKey();
        $data['id_subjenis'] = $subjenis->getKey();

        return view('asset-extracomptable.page-list-per-jenis', $data);
    }

    public function pageListPerLokasi(Request $req)
    {
        $gedung = Gedung::findOrFail($req->get('id_gedung') ?: 0);
        $lantai = $req->get('lantai');
        $ruang = Ruang::findOrfail($req->get('id_ruang') ?: 0);

        $data['page_title'] = "List Asset Extra Comptable";
        $data['page_subtitle'] = "{$gedung->nama} / Lantai {$lantai} / {$ruang->nama_ruang}";
        $data['id_gedung'] = $gedung->getKey();
        $data['lantai'] = $ruang->lantai;
        $data['id_ruang'] = $ruang->getKey();

        return view('asset-extracomptable.page-list-per-lokasi', $data);
    }

    public function getJsonListPerJenis(Request $req)
    {
        $limit = (int) $req->get('limit') ?: 15;
        $id_jenis = $req->get('id_jenis');
        $id_subjenis = $req->get('id_subjenis');

        if (!$id_jenis || !$id_subjenis) {
            return response()->json([
                'status' => 'error',
                'error' => 'validation_error',
                'message' => 'id_jenis and id_subjenis are required'
            ], 422);
        }

        $query = AssetExtracomptable::with(['jenis', 'subjenis', 'gedung', 'ruang'])
        ->where(function($q) use ($id_jenis, $id_subjenis) {
            $q->where('id_jenis', $id_jenis);
            $q->where('id_subjenis', $id_subjenis);
        });

        $pagination = $query->paginate();
        $pagination->getCollection()->transform(function($asset) {
            return array_merge($asset->toArray(), [
                'url_detail' => route('AdminAssetExtracomptableControllerGetDetail', [$asset->getKey()]),
                'url_edit' => route('AdminAssetExtracomptableControllerGetEdit', [$asset->getKey()]),
                'url_delete' => route('AdminAssetExtracomptableControllerGetDelete', [$asset->getKey()]),
            ]);
        });

        return array_merge(['status' => 'success'], $pagination->toArray());
    }

    public function getJsonListPerLokasi(Request $req)
    {
        $limit = (int) $req->get('limit') ?: 15;
        $id_gedung = $req->get('id_gedung');
        $lantai = $req->get('lantai');
        $id_ruang = $req->get('id_ruang');

        if (!$id_gedung || !$lantai || !$id_ruang) {
            return response()->json([
                'status' => 'error',
                'error' => 'validation_error',
                'message' => 'id_gedung, lantai, and id_ruang are required'
            ], 422);
        }

        $query = AssetExtracomptable::with(['jenis', 'subjenis', 'gedung', 'ruang'])
        ->where(function($q) use ($id_gedung, $lantai, $id_ruang) {
            $q->where('id_gedung', $id_gedung);
            $q->where('lantai', $lantai);
            $q->where('id_ruang', $id_ruang);
        });

        $pagination = $query->paginate();
        $pagination->getCollection()->transform(function($asset) {
            return array_merge($asset->toArray(), [
                'url_detail' => route('AdminAssetExtracomptableControllerGetDetail', [$asset->getKey()]),
                'url_edit' => route('AdminAssetExtracomptableControllerGetEdit', [$asset->getKey()]),
                'url_delete' => route('AdminAssetExtracomptableControllerGetDelete', [$asset->getKey()]),
            ]);
        });

        return array_merge(['status' => 'success'], $pagination->toArray());
    }

    public function downloadListPerJenis(Request $req, $format)
    {
        if (!in_array($format, ['csv', 'xlsx'])) {
            return abort(404);
        }

        $id_subjenis = $req->get('id_subjenis') or abort(400, 'Invalid Request');
        $subjenis = SubJenisExtracomptable::findOrFail($id_subjenis);

        $excel = new ExcelListAssetExtracomptablePerJenis($subjenis);
        return $excel->generate()->download($format);
    }

    public function downloadListPerLokasi(Request $req, $format)
    {
        if (!in_array($format, ['csv', 'xlsx'])) {
            return abort(404);
        }

        $id_ruang = $req->get('id_ruang') or abort(400, 'Invalid Request');
        $ruang = Ruang::findOrFail($id_ruang);

        $excel = new ExcelListAssetExtracomptablePerLokasi($ruang);
        return $excel->generate()->download($format);
    }

    // ============================================================================================

    public function postCreate(Request $req)
    {
        $asset = new AssetExtracomptable;
        $action = $req->get('action');
        $saved = $this->saveAsset($req, $asset);
        if (!$saved) {
            return redirect()->route('AdminAssetExtracomptableControllerGetAdd')
                ->with('error', 'Something went wrong while saving data.');
        }

        if ($action == 'save-and-new') {
            return redirect()->route('AdminAssetExtracomptableControllerGetAdd')->with([
                'id_gedung' => $asset->id_gedung,
                'lantai' => $asset->lantai,
                'id_ruang' => $asset->id_ruang,
                'id_jenis' => $asset->id_jenis,
                'id_subjenis' => $asset->id_subjenis,
                // 'kd_asset' => $asset->kd_asset,
                'nama_asset' => $asset->nama_asset,
                'tgl_masuk' => $asset->tgl_masuk,
                'status' => $asset->status,
            ]);
        } else {
            return redirect()->route('AdminAssetExtracomptableControllerGetIndex');
        }

    }

    public function postEdit(Request $req, $id)
    {
        $asset = AssetExtracomptable::findOrfail($id);
        $saved = $this->saveAsset($req, $asset);
        if (!$saved) {
            return redirect()->route('AdminAssetExtracomptableControllerGetEdit')
                ->with('error', 'Something went wrong while saving data.');
        }

        return redirect()->route('AdminAssetExtracomptableControllerGetIndex');
    }

    protected function saveAsset(Request $req, AssetExtracomptable $asset)
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
        $asset = AssetExtracomptable::with(['jenis', 'subjenis', 'gedung', 'ruang'])
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
            'id_jenis' => 'required|exists:jenis_extracomptable,id',
            'id_subjenis' => 'required|exists:subjenis_extracomptable,id',
            'tgl_masuk' => 'required|date',
        ]);

        $id_gedung = $req->get('id_gedung');
        $lantai = $req->get('lantai');
        $id_ruang = $req->get('id_ruang');
        $id_jenis = $req->get('id_jenis');
        $id_subjenis = $req->get('id_subjenis');
        $tgl_masuk = $req->get('tgl_masuk');

        $gedung = Gedung::findOrfail($id_gedung);
        $ruang = Ruang::findOrfail($id_ruang);
        $jenis = JenisExtracomptable::findOrfail($id_jenis);
        $subjenis = SubJenisExtracomptable::findOrfail($id_subjenis);

        $kode_asset = AssetExtracomptable::generateKodeAsset(
            $gedung,
            $lantai,
            $ruang,
            $jenis,
            $subjenis,
            new \Datetime($tgl_masuk)
        );

        return [
            'kode_asset' => $kode_asset
        ];
    }

    public function jsonGetQuantity(Request $req)
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

        return [
            'qty' => (int) $qty
        ];
    }

    public function pageArchives(Request $req)
    {
        $perPage = $req->get('limit') ?: 15;

        $query = AssetExtracomptable::archived();

        $data['page_title'] = "Archives Asset Extra Comptable";
        $data['pagination'] = $query->paginate($perPage);
        $data['datagrid'] = $this->datagridArchives($req);

        return view('asset-extracomptable.page-archives', $data);
    }

    public function getJsonArchives(Request $req)
    {
        return $this->datagridArchives($req)->toJson();
    }

    public function restoreArchives(Request $req)
    {
        $ids = (array) $req->get('ids');
        $asset = AssetExtracomptable::archived()->whereIn('id', $ids)->restore();
        return [
            'status' => 'success'
        ];
    }

    public function deleteArchives(Request $req)
    {
        $ids = (array) $req->get('ids');
        $asset = AssetExtracomptable::archived()->whereIn('id', $ids)->forceDelete();
        return [
            'status' => 'success'
        ];
    }

    protected function datagridArchives(Request $req)
    {
        $query = AssetExtracomptable::archived();
        $query->join('gedung', 'gedung.id', '=', 'asset_extracomptable.id_gedung');
        $query->join('ruang', 'ruang.id', '=', 'asset_extracomptable.id_ruang');
        $query->join('jenis_extracomptable as jenis', 'jenis.id', '=', 'asset_extracomptable.id_jenis');
        $query->join('subjenis_extracomptable as subjenis', 'subjenis.id', '=', 'asset_extracomptable.id_subjenis');

        return \Datagrid::make($query, [
            'id' => [
                'real_key' => 'asset_extracomptable.id',
                'display' => false,
            ],
            'no' => [
                'real_key' => 'asset_extracomptable.id',
                'label' => 'No.',
                'width' => 20,
                'th_class' => 'text-center',
                'td_class' => 'text-center',
                'format' => function($val, $row, $i, $res) {
                    return $res['from'] + $i;
                }
            ],
            'kd_asset' => [
                'real_key' => 'asset_extracomptable.kd_asset',
                'label' => 'Kode Asset',
                'sortable' => true,
                'searchable' => true,
                'width' => 140,
            ],
            'gedung' => [
                'real_key' => 'gedung.nama',
                'label' => 'Gedung',
                'sortable' => true,
                'searchable' => true,
                'width' => 200,
            ],
            'lantai' => [
                'real_key' => 'asset_extracomptable.lantai',
                'label' => 'Lantai',
                'sortable' => true,
                'searchable' => true,
                'th_class' => 'text-center',
                'td_class' => 'text-center',
                'width' => 90,
            ],
            'ruang' => [
                'real_key' => 'ruang.nama_ruang',
                'label' => 'Ruang',
                'sortable' => true,
                'searchable' => true,
                'width' => 200,
            ],
            'jenis' => [
                'real_key' => 'jenis.nama',
                'label' => 'Jenis',
                'sortable' => true,
                'searchable' => true,
                'width' => 200,
            ],
            'subjenis' => [
                'real_key' => 'subjenis.nama',
                'label' => 'Sub Jenis',
                'sortable' => true,
                'searchable' => true,
                'width' => 200,
            ],
            'nama_asset' => [
                'real_key' => 'asset_extracomptable.nama_asset',
                'label' => 'Nama Asset',
                'sortable' => true,
                'searchable' => true,
                'width' => null,
            ],
            'aksi' => [
                'real_key' => 'asset_extracomptable.id',
                'label' => 'Aksi',
                'width' => 120,
                'format' => function($val, $row, $i, $results) {
                    return "
                        <a class='btn btn-success btn-xs btn-restore'>Restore</a>
                        <a class='btn btn-danger btn-xs btn-delete'>Delete</a>
                    ";
                }
            ],
        ])
        ->withOptions([
            'per_page' => 15,
            'limit_options' => [15, 30, 50, 100],
            'checkables' => true,
            'primary_key' => 'id',
            'empty_message' => 'Data archive kosong',
            'fetch_url' => route('asset-extracomptable::json-get-archives')
        ]);
    }

}
