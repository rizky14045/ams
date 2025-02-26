<?php

namespace App\Reports;

use App\Models\AssetExtracomptable;
use App\Models\SubJenisExtracomptable;

class ExcelListAssetExtracomptablePerJenis extends ExcelReport
{

    protected $subjenis;

    public function __construct(SubJenisExtracomptable $subjenis)
    {
        $this->subjenis = $subjenis;
    }

    public function generate($filename = null)
    {
        if (!$filename) {
            $filename = $this->getDefaultFilename();
        }

        $rows = $this->getCollection()->toArray();
        return $this->generateExcel($filename, [
            'no' => [
                'label' => 'No.',
                'format' => function($val, $row, $i) {
                    return $i+1;
                }
            ],
            'kd_asset' => [
                'label' => 'Kode Asset'
            ],
            'nama_asset' => [
                'label' => 'Nama Asset'
            ],
            'gedung' => [
                'label' => 'Gedung'
            ],
            'lantai' => [
                'label' => 'Lantai'
            ],
            'ruang' => [
                'label' => 'Ruang'
            ],
            'status' => [
                'label' => 'Status'
            ],
        ], $rows);
    }

    public function getCollection()
    {
        $query = AssetExtracomptable::querySummaryPerSubJenis($this->subjenis);
        return $query->get();
    }

    public function getDefaultFilename()
    {
        return 'asset-extracomptable-per-jenis_'.date('ymdhis');
    }

}
