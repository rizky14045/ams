<?php

use App\Libraries\QrcodeAsset;
use App\Libraries\QrcodeRuang;
use App\Models\Ruang;
use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('dg', function() {
    $table = 'ruang'; // $this->argument('table');
    $query = DB::table($table)->join('gedung', 'gedung.id', '=', 'ruang.id_gedung');
    $dg = Datagrid::make($query, [
        'no' => [
            'real_key' => 'ruang.id',
            'format' => function($val, $row, $i) {
                return $i + 1;
            }
        ],
        'aksi' => [
            'real_key' => 'ruang.id',
            'format' => function($val, $row, $i) {
                return "Aksi $val";
            }
        ],
        'nama_gedung' => [
            'real_key' => 'gedung.nama',
        ],
        'nama_ruang' => []
    ])
    ->orderBy('nama_gedung', 'asc');

    dd($dg->getResults());
});

Artisan::command('test-qrcode-asset', function() {
    $path = QrcodeAsset::make('C0B4.C0B4.4J4.LAH', [
        'name' => "Testing Asset",
        'location' => 'Gedung G1, Ruang XXX, Lt.1.',
        'directory' => 'test',
        'texts' => [
            'Ruang ABCD',
            'Gedung XYZ',
        ],
    ])->generate()->getFilePath();

    dd($path);
});

Artisan::command('test-qrcode-ruang', function() {
    $ruang = Ruang::first();
    $path = QrcodeRuang::make($ruang->getKode(), [
        'name' => $ruang->nama_ruang,
        'directory' => 'test',
    ])->generate()->getFilePath();

    dd($path);
});
