<?php

namespace App\Reports;

use App\Models\AssetExtracomptable;

class ExcelListAssetExtracomptableByLokasi extends ExcelReport
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
            'gedung' => [
                'label' => 'Gedung'
            ],
            'lantai' => [
                'label' => 'Lantai'
            ],
            'ruang' => [
                'label' => 'Ruang'
            ],
            'jumlah' => [
                'label' => 'Jumlah'
            ]
        ], $rows);
    }

    public function getCollection()
    {
        $query = AssetExtracomptable::querySummaryByLokasi();

        return $query->get();
    }

    public function getDefaultFilename()
    {
        return 'asset-extracomptable-by-lokasi_'.date('ymdhis');
    }

}
