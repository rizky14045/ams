<?php

namespace App\Reports;

use App\Models\AssetExtracomptable;
use App\Models\Ruang;

class ExcelListAssetExtracomptablePerLokasi extends ExcelReport
{

    protected $ruang;

    public function __construct(Ruang $ruang)
    {
        $this->ruang = $ruang;
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
            'jenis' => [
                'label' => 'Jenis'
            ],
            'subjenis' => [
                'label' => 'Sub Jenis'
            ],
            'status' => [
                'label' => 'Status'
            ],
        ], $rows);
    }

    public function getCollection()
    {
        $query = AssetExtracomptable::querySummaryPerRuang($this->ruang);
        return $query->get();
    }

    public function getDefaultFilename()
    {
        return 'asset-extracomptable-by-lokasi_'.date('ymdhis');
    }

}
