<?php

namespace App\Reports;

use App\Models\AssetExtracomptable;
use App\Models\Ruang;

class ExcelReportExtracomptable extends ExcelReport
{

    protected $id_gedung;
    protected $lantai;
    protected $id_ruang;

    public function __construct($id_gedung, $lantai, $id_ruang)
    {
        $this->id_gedung = $id_gedung;
        $this->lantai = $lantai;
        $this->id_ruang = $id_ruang;
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
            'gedung' => [
                'label' => 'Gedung'
            ],
            'lantai' => [
                'label' => 'Lantai'
            ],
            'ruang' => [
                'label' => 'Ruang'
            ],
            'jenis' => [
                'label' => 'Jenis'
            ],
            'subjenis' => [
                'label' => 'Sub Jenis'
            ],
            'jumlah' => [
                'label' => 'Jumlah'
            ],
        ], $rows);
    }

    public function getCollection()
    {
        $query = AssetExtracomptable::queryReport($this->id_gedung, $this->lantai, $this->id_ruang);
        return $query->get();
    }

    public function getDefaultFilename()
    {
        return 'report-asset-extracomptable_'.date('ymdhis');
    }

}
