<?php

use App\Models\JenisPemeliharaanAktivaTetap;
use App\Models\JenisPemeliharaanExtracomptable;
use App\Models\Karyawan;
use App\Models\KategoriInventory;
use App\Models\ModelAktivaTetap;
use App\Models\Ruang;
use App\Models\SubJenisExtracomptable;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\AssetExtracomptable::class, function (Faker\Generator $faker) {
    static $optionsSubjenis;
    static $optionsRuang;
    static $optionsStatus;

    if (!$optionsRuang) $optionsRuang = Ruang::all()->toArray();
    if (!$optionsSubjenis) $optionsSubjenis = SubJenisExtracomptable::all()->toArray();
    if (!$optionsStatus) $optionsStatus = config('asset.status_extracomptable');

    $ruang = $faker->randomElement($optionsRuang);
    $subjenis = $faker->randomElement($optionsSubjenis);
    $status = $faker->randomElement($optionsStatus);

    return [
        'id_gedung' => $ruang['id_gedung'],
        'lantai' => $ruang['lantai'],
        'id_ruang' => $ruang['id'],
        'id_jenis' => $subjenis['id_jenis'],
        'id_subjenis' => $subjenis['id'],
        'kd_asset' => 'dummy.'.str_random('8'),
        'nama_asset' => $faker->text(60),
        'tgl_masuk' => $faker->dateTimeBetween('-6 month', 'now')->format('Y-m-d'),
        'status' => $status['value'],
        'gambar' => '',
    ];
});

$factory->define(App\Models\AssetAktivaTetap::class, function (Faker\Generator $faker) {
    static $optionsModel;
    static $optionsStatus;

    if (!$optionsModel) $optionsModel = ModelAktivaTetap::all()->toArray();
    if (!$optionsStatus) $optionsStatus = config('asset.status_extracomptable');

    $model = $faker->randomElement($optionsModel);
    $status = $faker->randomElement($optionsStatus);

    return [
        'lokasi' => $faker->address,
        'id_model' => $model['id'],
        'kd_asset' => 'dummy.'.str_random('8'),
        'nama_asset' => $faker->text(60),
        'tgl_masuk' => $faker->dateTimeBetween('-6 month', 'now')->format('Y-m-d'),
        'status' => $status['value'],
        'gambar' => '',
    ];
});

$factory->define(App\Models\AssetInventory::class, function (Faker\Generator $faker) {
    static $optionsKategori;
    static $optionsRuang;
    static $optionsStatus;

    if (!$optionsRuang) $optionsRuang = Ruang::all()->toArray();
    if (!$optionsKategori) $optionsKategori = KategoriInventory::all()->toArray();
    if (!$optionsStatus) $optionsStatus = config('asset.status_extracomptable');

    $ruang = $faker->randomElement($optionsRuang);
    $kategori = $faker->randomElement($optionsKategori);
    $status = $faker->randomElement($optionsStatus);

    return [
        'id_gedung' => $ruang['id_gedung'],
        'lantai' => $ruang['lantai'],
        'id_ruang' => $ruang['id'],
        'id_kategori' => $kategori['id'],
        'kd_asset' => 'dummy.'.str_random('8'),
        'nama_asset' => $faker->text(60),
        'jumlah' => rand(1, 100),
        'jumlah_minimum' => rand(1, 100),
        'gambar' => '',
    ];
});

$factory->define(App\Models\CheckoutExtracomptable::class, function (Faker\Generator $faker) {
    static $optionsKaryawan;
    static $optionsRuang;

    if (!$optionsRuang) $optionsRuang = Ruang::all()->toArray();
    if (!$optionsKaryawan) $optionsKaryawan = Karyawan::all()->toArray();

    $ruang = $faker->randomElement($optionsRuang);
    $karyawan = $faker->randomElement($optionsKaryawan);

    return [
        'kd_checkout' => 'dummy.'.str_random(6),
        'nik_karyawan' => $karyawan['nik'],
        'id_gedung' => $ruang['id_gedung'],
        'tanggal' => date('Y-m-d'),
        'lantai' => $ruang['lantai'],
        'note' => $faker->text,
        'id_ruang' => $ruang['id'],
    ];
});

$factory->define(App\Models\CheckoutInventory::class, function (Faker\Generator $faker) {
    static $optionsKaryawan;
    static $optionsRuang;

    if (!$optionsRuang) $optionsRuang = Ruang::all()->toArray();
    if (!$optionsKaryawan) $optionsKaryawan = Karyawan::all()->toArray();

    $ruang = $faker->randomElement($optionsRuang);
    $karyawan = $faker->randomElement($optionsKaryawan);

    return [
        'kd_checkout' => 'dummy.'.str_random(6),
        'nik_karyawan' => $karyawan['nik'],
        'id_gedung' => $ruang['id_gedung'],
        'tanggal' => date('Y-m-d'),
        'lantai' => $ruang['lantai'],
        'note' => $faker->text,
        'id_ruang' => $ruang['id'],
    ];
});

$factory->define(App\Models\CheckoutAktivaTetap::class, function (Faker\Generator $faker) {
    static $optionsKaryawan;

    if (!$optionsKaryawan) $optionsKaryawan = Karyawan::all()->toArray();

    $karyawan = $faker->randomElement($optionsKaryawan);

    return [
        'kd_checkout' => 'dummy.'.str_random(6),
        'nik_karyawan' => $karyawan['nik'],
        'tanggal' => date('Y-m-d'),
        'note' => $faker->text,
        'lokasi' => $faker->address,
    ];
});

$factory->define(App\Models\AdjustmentInventory::class, function (Faker\Generator $faker) {
    static $optionsKaryawan;
    static $optionsRuang;

    if (!$optionsRuang) $optionsRuang = Ruang::all()->toArray();
    if (!$optionsKaryawan) $optionsKaryawan = Karyawan::all()->toArray();

    $ruang = $faker->randomElement($optionsRuang);
    $karyawan = $faker->randomElement($optionsKaryawan);

    return [
        'kd_adjustment' => 'dummy.'.str_random(6),
        'id_gedung' => $ruang['id_gedung'],
        'lantai' => $ruang['lantai'],
        'id_ruang' => $ruang['id'],
        'tanggal' => date('Y-m-d'),
    ];
});

$factory->define(App\Models\AdjustmentExtracomptable::class, function (Faker\Generator $faker) {
    static $optionsKaryawan;
    static $optionsRuang;

    if (!$optionsRuang) $optionsRuang = Ruang::all()->toArray();
    if (!$optionsKaryawan) $optionsKaryawan = Karyawan::all()->toArray();

    $ruang = $faker->randomElement($optionsRuang);
    $karyawan = $faker->randomElement($optionsKaryawan);

    return [
        'kd_adjustment' => 'dummy.'.str_random(6),
        'id_gedung' => $ruang['id_gedung'],
        'lantai' => $ruang['lantai'],
        'id_ruang' => $ruang['id'],
        'tanggal' => date('Y-m-d'),
    ];
});

$factory->define(App\Models\AdjustmentAktivaTetap::class, function (Faker\Generator $faker) {
    return [
        'kd_adjustment' => 'dummy.'.str_random(6),
        'lokasi' => $faker->address,
        'tanggal' => date('Y-m-d'),
    ];
});

$factory->define(App\Models\PemeliharaanExtracomptable::class, function (Faker\Generator $faker) {
    static $optionsKaryawan;
    static $optionsRuang;
    static $optionsJenis;

    if (!$optionsRuang) $optionsRuang = Ruang::all()->toArray();
    if (!$optionsKaryawan) $optionsKaryawan = Karyawan::all()->toArray();
    if (!$optionsJenis) $optionsJenis = JenisPemeliharaanExtracomptable::all()->toArray();

    $ruang = $faker->randomElement($optionsRuang);
    $karyawan = $faker->randomElement($optionsKaryawan);
    $jenisPemeliharaan = $faker->randomElement($optionsJenis);

    return [
        'kd_pemeliharaan' => 'dummy.'.str_random(6),
        'nik_karyawan' => $karyawan['nik'],
        'id_jenis_pemeliharaan' => $jenisPemeliharaan['id'],
        'id_gedung' => $ruang['id_gedung'],
        'lantai' => $ruang['lantai'],
        'id_ruang' => $ruang['id'],
        'tgl_mulai' => date('Y-m-d'),
        'tgl_selesai' => date('Y-m-d'),
        'note' => $faker->text,
    ];
});

$factory->define(App\Models\PemeliharaanAktivaTetap::class, function (Faker\Generator $faker) {
    static $optionsKaryawan;
    static $optionsJenis;

    if (!$optionsKaryawan) $optionsKaryawan = Karyawan::all()->toArray();
    if (!$optionsJenis) $optionsJenis = JenisPemeliharaanAktivaTetap::all()->toArray();

    $karyawan = $faker->randomElement($optionsKaryawan);
    $jenisPemeliharaan = $faker->randomElement($optionsJenis);

    return [
        'kd_pemeliharaan' => 'dummy.'.str_random(6),
        'nik_karyawan' => $karyawan['nik'],
        'id_jenis_pemeliharaan' => $jenisPemeliharaan['id'],
        'lokasi' => $faker->address,
        'tgl_mulai' => date('Y-m-d'),
        'tgl_selesai' => date('Y-m-d'),
        'note' => $faker->text,
    ];
});

$factory->define(App\Models\RequestInventory::class, function (Faker\Generator $faker) {
    static $optionsRuang;

    if (!$optionsRuang) $optionsRuang = Ruang::all()->toArray();

    $ruang = $faker->randomElement($optionsRuang);

    return [
        'kd_request' => 'dummy.'.str_random(6),
        'id_gedung' => $ruang['id_gedung'],
        'lantai' => $ruang['lantai'],
        'id_ruang' => $ruang['id'],
    ];
});
