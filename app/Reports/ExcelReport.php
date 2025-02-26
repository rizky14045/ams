<?php

namespace App\Reports;

abstract class ExcelReport
{

    public function generateExcel($filename, array $columns, array $rows)
    {
        return \Excel::create($filename, function($excel) use ($columns, $rows) {
            $excel->sheet('Sheet 1', function($sheet) use ($columns, $rows) {
                $x = 'A';
                $y = 1;

                foreach ($columns as $key => $opts) {
                    $cell = ($x++).($y);
                    $sheet->setCellValue($cell, $opts['label']);
                }

                foreach ($rows as $i => $row) {
                    $x = 'A';
                    foreach ($columns as $key => $opts) {
                        $value = (isset($row[$key])) ? $row[$key] : '';
                        if (isset($opts['format']) && is_callable($opts['format'])) {
                            $value = call_user_func_array($opts['format'], [$value, $row, $i]);
                        }
                        $cell = ($x++).($y+$i+1);
                        $sheet->setCellValue($cell, $value);
                    }
                }
            });

        });
    }

}
