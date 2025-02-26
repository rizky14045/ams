<?php

namespace App\Traits;

use App\Models\AssetAktivaTetap;
use App\Models\AssetExtracomptable;
use App\Models\AssetInventory;
use App\Models\Gedung;
use App\Models\JenisExtracomptable;
use App\Models\KategoriInventory;
use App\Models\ModelAktivaTetap;
use App\Models\Ruang;
use App\Models\SubJenisExtracomptable;
use App\Models\User;
use DB;
use Datetime;

trait AssetLogger
{

    public function log($type, $idUser = null, array $data = [])
    {
        $log['type'] = $type;
        $log['id_asset'] = $this->getKey();
        $log['id_user'] = $idUser;
        $log['message'] = "";
        $log['ip_address'] = array_get($_SERVER, 'REMOTE_ADDR') ?: '';
        $log['user_agent'] = array_get($_SERVER, 'HTTP_USER_AGENT') ?: '';
        $log['data'] = json_encode($data);
        $log['id'] = DB::table($this->getLogTable())->insertGetId($log);

        return $log;
    }

    public function logCreate($idUser = null, array $data = [])
    {
        $data = array_merge($data, [
            'asset' => $this->toArray()
        ]);
        return $this->log('create', $idUser, $data);
    }

    public function logUpdate($idUser = null, array $data = [])
    {
        $data = array_merge($data, [
            'asset' => $this->toArray()
        ]);
        return $this->log('update', $idUser, $data);
    }

    public function logDelete($idUser = null, array $data = [])
    {
        $data = array_merge($data, [
            'asset' => $this->toArray()
        ]);
        return $this->log('delete', $idUser, $data);
    }

    public function logCheckout($idUser = null, array $data = [])
    {
        $data = array_merge($data, [
            'asset' => $this->toArray()
        ]);
        return $this->log('checkout', $idUser, $data);
    }

    public function logPemeliharaan($idUser = null, array $data = [])
    {
        return $this->log('pemeliharaan', $idUser, $data);
    }

    public function getLogTable()
    {
        return $this->logTable ?: 'log_'.$this->getTable();
    }

    public function queryLogs()
    {
        return DB::table($this->getLogTable())->where('id_asset', $this->getKey());
    }

    public function getResolvedLogs(array $options = [])
    {
        $logs = $this->getLogs($options);
        $table = $this->getTable();

        $resolvers = [
            'asset_extracomptable' => 'resolveLogsExtracomptable',
            'asset_aktiva_tetap' => 'resolveLogsAktivaTetap',
            'asset_inventory' => 'resolveLogsInventory',
        ];

        if (!isset($resolvers[$table])) {
            throw new \Exception("Unable to resolve logs '{$table}'.");
        }

        $logs->items = $this->{$resolvers[$table]}($logs->items);

        return $logs;
    }

    public function resolveLog($log)
    {
        $log->data = json_decode($log->data) ?: null;
        if ($log->data && $log->data->asset) {
            $log->asset = $this->resolveAssetLog($log->data->asset);
        }
        return $log;
    }

    protected function resolveLogsExtracomptable($logs)
    {
        $gedungIds = [];
        $ruangIds = [];
        $jenisIds = [];
        $subjenisIds = [];
        $userIds = [];

        foreach ($logs as $log) {
            $userIds[] = $log->id_user;
            $log->data = json_decode($log->data) ?: null;
            if ($log->data && property_exists($log->data, 'asset')) {
                $gedungIds[] = $log->data->asset->id_gedung ?: 0;
                $ruangIds[] = $log->data->asset->id_ruang ?: 0;
                $jenisIds[] = $log->data->asset->id_jenis ?: 0;
                $subjenisIds[] = $log->data->asset->id_subjenis ?: 0;
            }
        }

        $listGedung = Gedung::withTrashed()->whereIn('id', $gedungIds)->get()->keyBy('id');
        $listRuang = Ruang::withTrashed()->whereIn('id', $ruangIds)->get()->keyBy('id');
        $listJenis = JenisExtracomptable::withTrashed()->whereIn('id', $jenisIds)->get()->keyBy('id');
        $listSubjenis = SubJenisExtracomptable::withTrashed()->whereIn('id', $subjenisIds)->get()->keyBy('id');
        $listUsers = User::withTrashed()->whereIn('id', $userIds)->get()->keyBy('id');

        return $logs->map(function($log) use (&$listGedung, &$listRuang, &$listJenis, &$listSubjenis, &$listUsers) {
            $log->asset = ($log->data && property_exists($log->data, 'asset')) ? $log->data->asset : null;
            $log->user = isset($listUsers[$log->id_user]) ? (object) $listUsers[$log->id_user]->toArray() : null;

            if ($log->asset) {
                $asset = (new AssetExtracomptable)->forceFill((array) $log->asset);
                $log->asset->url_image = $asset->urlGambar();
                $log->asset->gedung = ($obj = array_get($listGedung, $log->asset->id_gedung)) ? (object) $obj->toArray() : null;
                $log->asset->ruang = ($obj = array_get($listRuang, $log->asset->id_ruang)) ? (object) $obj->toArray() : null;
                $log->asset->jenis = ($obj = array_get($listJenis, $log->asset->id_jenis)) ? (object) $obj->toArray() : null;
                $log->asset->subjenis = ($obj = array_get($listSubjenis, $log->asset->id_subjenis)) ? (object) $obj->toArray() : null;
                unset($log->data->asset);
            }

            return $log;
        });
    }

    protected function resolveLogsInventory($logs)
    {
        $gedungIds = [];
        $ruangIds = [];
        $kategoriIds = [];
        $userIds = [];

        foreach ($logs as $log) {
            $log->data = json_decode($log->data) ?: null;
            $userIds[] = $log->id_user;
            if ($log->data && property_exists($log->data, 'asset')) {
                $gedungIds[] = $log->data->asset->id_gedung ?: 0;
                $ruangIds[] = $log->data->asset->id_ruang ?: 0;
                $kategoriIds[] = $log->data->asset->id_kategori ?: 0;
            }
        }

        $listGedung = Gedung::withTrashed()->whereIn('id', $gedungIds)->get()->keyBy('id');
        $listRuang = Ruang::withTrashed()->whereIn('id', $ruangIds)->get()->keyBy('id');
        $listKategori = KategoriInventory::withTrashed()->whereIn('id', $kategoriIds)->get()->keyBy('id');
        $listUsers = User::withTrashed()->whereIn('id', $userIds)->get()->keyBy('id');

        return $logs->map(function($log) use (&$listGedung, &$listRuang, &$listKategori, &$listUsers) {
            $log->asset = ($log->data && property_exists($log->data, 'asset')) ? $log->data->asset : null;
            $log->user = isset($listUsers[$log->id_user]) ? (object) $listUsers[$log->id_user]->toArray() : null;

            if ($log->asset) {
                $asset = (new AssetInventory)->forceFill((array) $log->asset);
                $log->asset->url_image = $asset->urlGambar();
                $log->asset->gedung = ($obj = array_get($listGedung, $log->asset->id_gedung)) ? (object) $obj->toArray() : null;
                $log->asset->ruang = ($obj = array_get($listRuang, $log->asset->id_ruang)) ? (object) $obj->toArray() : null;
                $log->asset->kategori = ($obj = array_get($listKategori, $log->asset->id_kategori)) ? (object) $obj->toArray() : null;
            }

            return $log;
        });
    }

    protected function resolveLogsAktivaTetap($logs)
    {
        $modelIds = [];
        $userIds = [];

        foreach ($logs as $log) {
            $log->data = json_decode($log->data) ?: null;
            $userIds[] = $log->id_user;
            if ($log->data && property_exists($log->data, 'asset')) {
                $modelIds[] = $log->data->asset->id_model ?: 0;
            }
        }

        $listModel = ModelAktivaTetap::withTrashed()->whereIn('id', $modelIds)->get()->keyBy('id');
        $listUsers = User::withTrashed()->whereIn('id', $userIds)->get()->keyBy('id');

        return $logs->map(function($log) use (&$listModel, &$listUsers) {
            $log->asset = ($log->data && property_exists($log->data, 'asset')) ? $log->data->asset : null;
            $log->user = isset($listUsers[$log->id_user]) ? (object) $listUsers[$log->id_user]->toArray() : null;

            if ($log->asset) {
                $asset = (new AssetAktivaTetap)->forceFill((array) $log->asset);
                $log->asset->url_image = $asset->urlGambar();
                $log->asset->model = ($obj = array_get($listModel, $log->asset->id_model)) ? (object) $obj->toArray() : null;
            }

            return $log;
        });
    }

    public function getLogs(array $options = [])
    {
        $options = array_merge([
            'limit' => 15,
            'offset' => 0,
            'type' => null,
            'id_user' => null,
            'time_from' => null,
            'time_to' => null,
            'ip_address' => null,
            'user_agent' => null,
            'sort' => 'desc'
        ], $options);

        $query = $this->queryLogs();

        // Filters
        if ($options['type']) {
            if (is_array($options['type'])) {
                $query->whereIn('type', $options['type']);
            } else {
                $query->where('type', $options['type']);
            }
        }

        if ($options['id_user']) {
            $query->where('id_user', $options['id_user']);
        }

        if ($options['time_from'] && $options['time_from'] instanceof Datetime) {
            $query->where('time', '>=', $options['time_from']->format('Y-m-d H:i:s'));
        }

        if ($options['time_to'] && $options['time_to'] instanceof Datetime) {
            $query->where('time', '<=', $options['time_to']->format('Y-m-d H:i:s'));
        }

        if ($options['user_agent']) {
            $query->where('user_agent', 'like', "%{$options['user_agent']}%");
        }

        if ($options['ip_address']) {
            $query->where('ip_address', $options['ip_address']);
        }

        $count = $query->count();

        // Limiting
        if ($options['offset']) {
            $query->skip($options['offset']);
        }

        if ($options['limit']) {
            $query->take($options['limit']);
        }

        // Sorting
        $query->orderBy('time', $options['sort']);

        $logs = $query->get();

        return (object) [
            'options' => $options,
            'total' => $count,
            'items' => $logs
        ];
    }

}
