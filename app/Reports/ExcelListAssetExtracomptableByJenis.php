<?php

namespace App\Reports;

use App\Models\AssetExtracomptable;

class ExcelListAssetExtracomptableByJenis extends ExcelReport
{

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
            'jenis' => [
                'label' => 'Jenis'
            ],
            'subjenis' => [
                'label' => 'Sub Jenis'
            ],
            'jumlah' => [
                'label' => 'Jumlah'
            ]
        ], $rows);
    }

    public function getCollection()
    {
        $query = AssetExtracomptable::querySummaryByJenis();

        return $query->get();
    }

    public function getDefaultFilename()
    {
        return 'asset-extracomptable-by-lokasi_'.date('ymdhis');
    }

}
