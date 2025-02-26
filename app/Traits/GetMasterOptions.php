<?php

namespace App\Traits;

use App\Models\Gedung;
use App\Models\JenisExtracomptable;
use App\Models\JenisPemeliharaanAktivaTetap;
use App\Models\JenisPemeliharaanExtracomptable;
use App\Models\Karyawan;
use App\Models\KategoriInventory;
use App\Models\ModelAktivaTetap;

trait GetMasterOptions {

    protected function getOptionsKaryawan()
    {
        return Karyawan::orderBy('nama', 'asc')->get()->map(function($karyawan) {
            return [
                'label' => "[{$karyawan->nik}] {$karyawan->nama}",
                'value' => $karyawan->nik,
            ];
        })->toArray();
    }

    protected function getOptionsGedung()
    {
        return Gedung::get()->map(function($gedung) {
            return [
                'label' => $gedung->nama,
                'value' => $gedung->id,
            ];
        })->toArray();
    }

    protected function getOptionsJenis()
    {
        return JenisExtracomptable::get()->map(function($jenis) {
            return [
                'label' => $jenis->nama,
                'value' => $jenis->id,
            ];
        })->toArray();
    }

    protected function getOptionsLantai($id_gedung)
    {
        $gedung = Gedung::find($id_gedung);
        if (!$gedung) return [];

        $list_lantai = $gedung->getListLantai();
        return array_map(function($lantai) {
            return [
                'value' => $lantai,
                'label' => $lantai
            ];
        }, $list_lantai);
    }

    protected function getOptionsRuang($id_gedung, $lantai)
    {
        $gedung = Gedung::find($id_gedung);
        if (!$gedung) return [];

        return $gedung->list_ruang()->lantai($lantai)->orderBy('nama_ruang', 'asc')->get()->map(function($ruang) {
            return [
                'value' => $ruang->id,
                'label' => $ruang->nama_ruang
            ];
        })->toArray();
    }

    protected function getOptionsSubJenis($id_jenis)
    {
        $jenis = JenisExtracomptable::find($id_jenis);
        if (!$jenis) return [];

        return $jenis->list_subjenis()->orderBy('nama', 'asc')->get()->map(function($subjenis) {
            return [
                'value' => $subjenis->id,
                'label' => $subjenis->nama
            ];
        })->toArray();
    }

    protected function getOptionsKategori()
    {
        return KategoriInventory::get()->map(function($kategori) {
            return [
                'label' => $kategori->nama_kategori,
                'value' => $kategori->id,
            ];
        })->toArray();
    }

    protected function getOptionsModel()
    {
        return ModelAktivaTetap::get()->map(function($model) {
            return [
                'label' => $model->nama_model,
                'value' => $model->id,
            ];
        })->toArray();
    }

    protected function getOptionsStatusExtracomptable()
    {
        $list_status = config('asset.status_extracomptable');
        $options = [];
        foreach($list_status as $status) {
            $options[] = [
                'label' => $status['label'],
                'value' => $status['value']
            ];
        }
        return $options;
    }

    protected function getOptionsStatusAktivaTetap()
    {
        $list_status = config('asset.status_aktiva_tetap');
        $options = [];
        foreach($list_status as $status) {
            $options[] = [
                'label' => $status['label'],
                'value' => $status['value']
            ];
        }
        return $options;
    }

    protected function getOptionsJenisPemeliharaanAktivaTetap()
    {
        return JenisPemeliharaanAktivaTetap::orderBy('nama_jenis', 'asc')->get()->map(function($jenis) {
            return [
                'value' => $jenis->id,
                'label' => $jenis->nama_jenis
            ];
        })->toArray();
    }

    protected function getOptionsJenisPemeliharaanExtracomptable()
    {
        return JenisPemeliharaanExtracomptable::orderBy('nama_jenis', 'asc')->get()->map(function($jenis) {
            return [
                'value' => $jenis->id,
                'label' => $jenis->nama_jenis
            ];
        })->toArray();
    }

}
