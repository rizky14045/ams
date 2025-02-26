<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return redirect('admin');
});

Route::get('/maintenance-mode', function () {
    Artisan::call('down');
    return true;
});

Route::group(['middleware' => 'cb-auth'], function() {
    /**
     * ----------------------------------------------------------------------------------------------
     * Route 3 Jenis Asset
     * ----------------------------------------------------------------------------------------------
     */
    Route::prefix('/asset/extracomptable')->name('asset-extracomptable::')->group(function() {
        Route::get('/{id}/histories.json', 'AssetExtracomptableController@getHistories')->name('json-get-histories');

        Route::get('/report', 'AssetExtracomptableController@pageReport')->name('page-report');
        Route::get('/report.json', 'AssetExtracomptableController@getJsonReport')->name('json-get-report');
        Route::get('/download/report.{format}', 'AssetExtracomptableController@downloadReport')->name('download-report')->where('format', '(xlsx|csv)');

        Route::get('/summary', 'AssetExtracomptableController@pageSummary')->name('page-summary');
        Route::get('/summary/jenis.json', 'AssetExtracomptableController@getJsonSummaryByJenis')->name('json-get-summary-by-jenis');
        Route::get('/summary/lokasi.json', 'AssetExtracomptableController@getJsonSummaryByLokasi')->name('json-get-summary-by-lokasi');

        Route::get('/summary/download/jenis.{format}', 'AssetExtracomptableController@downloadSummaryByJenis')->name('download-summary-by-jenis')->where('format', '(xlsx|csv)');
        Route::get('/summary/download/lokasi.{format}', 'AssetExtracomptableController@downloadSummaryByLokasi')->name('download-summary-by-lokasi')->where('format', '(xlsx|csv)');

        Route::get('/list/per-jenis', 'AssetExtracomptableController@pageListPerJenis')->name('page-list-per-jenis');
        Route::get('/list/per-lokasi', 'AssetExtracomptableController@pageListPerLokasi')->name('page-list-per-lokasi');
        Route::get('/list/per-jenis.json', 'AssetExtracomptableController@getJsonListPerJenis')->name('json-get-list-per-jenis');
        Route::get('/list/per-lokasi.json', 'AssetExtracomptableController@getJsonListPerLokasi')->name('json-get-list-per-lokasi');
        Route::get('/list/download/per-jenis.{format}', 'AssetExtracomptableController@downloadListPerJenis')->name('download-list-per-jenis')->where('format', '(xlsx|csv)');
        Route::get('/list/download/per-lokasi.{format}', 'AssetExtracomptableController@downloadListPerLokasi')->name('download-list-per-lokasi')->where('format', '(xlsx|csv)');

        Route::get('/archives', 'AssetExtracomptableController@pageArchives')->name('page-archives');
        Route::get('/archives.json', 'AssetExtracomptableController@getJsonArchives')->name('json-get-archives');
        Route::post('/archives/restore', 'AssetExtracomptableController@restoreArchives')->name('restore-archives');
        Route::post('/archives/delete', 'AssetExtracomptableController@deleteArchives')->name('delete-archives');

        Route::post('/create', 'AssetExtracomptableController@postCreate')->name('post-create');
        Route::post('/edit/{id}', 'AssetExtracomptableController@postEdit')->name('post-edit');
    });

    Route::prefix('/asset/aktiva-tetap')->name('asset-aktiva-tetap::')->group(function() {
        Route::get('/{id}/histories.json', 'AssetAktivaTetapController@getHistories')->name('json-get-histories');
        Route::post('/create', 'AssetAktivaTetapController@postCreate')->name('post-create');
        Route::post('/edit/{id}', 'AssetAktivaTetapController@postEdit')->name('post-edit');
    });

    Route::prefix('/asset/inventory')->name('asset-inventory::')->group(function() {
        Route::get('/{id}/histories.json', 'AssetInventoryController@getHistories')->name('json-get-histories');
        Route::post('/create', 'AssetInventoryController@postCreate')->name('post-create');
        Route::post('/edit/{id}', 'AssetInventoryController@postEdit')->name('post-edit');
    });

    Route::prefix('/asset/inventory/pos')->name('pos-asset-inventory::')->group(function() {
        Route::post('/create', 'PosAssetInventoryController@postCreate')->name('post-create');
        Route::post('/edit/{id}', 'PosAssetInventoryController@postEdit')->name('post-edit');
    });

    /**
     * ----------------------------------------------------------------------------------------------
     * Route Request 3 Jenis Asset
     * ----------------------------------------------------------------------------------------------
     */
    Route::prefix('/request/extracomptable')->name('request-extracomptable::')->group(function() {
        Route::post('/create', 'RequestExtracomptableController@postCreate')->name('post-create');
        Route::post('/edit/{id}', 'RequestExtracomptableController@postEdit')->name('post-edit');
    });

    Route::prefix('/request/aktiva-tetap')->name('request-aktiva-tetap::')->group(function() {
        Route::post('/create', 'RequestAktivaTetapController@postCreate')->name('post-create');
        Route::post('/edit/{id}', 'RequestAktivaTetapController@postEdit')->name('post-edit');
    });

    Route::prefix('/request/inventory')->name('request-inventory::')->group(function() {
        Route::post('/create', 'RequestInventoryController@postCreate')->name('post-create');
        Route::post('/edit/{id}', 'RequestInventoryController@postEdit')->name('post-edit');
    });

    /**
     * ----------------------------------------------------------------------------------------------
     * Route Checkout 3 Jenis Asset
     * ----------------------------------------------------------------------------------------------
     */
    Route::prefix('/checkout/extracomptable')->name('checkout-extracomptable::')->group(function() {
        Route::post('/create', 'CheckoutExtracomptableController@postCreate')->name('post-create');
        Route::post('/edit/{id}', 'CheckoutExtracomptableController@postEdit')->name('post-edit');
        Route::post('/approve/{id}', 'CheckoutExtracomptableController@postApprove')->name('post-approve');
        Route::get('/{id}.json', 'CheckoutExtracomptableController@getJsonDetail')->name('get-json-detail');
    });

    Route::prefix('/checkout/aktiva-tetap')->name('checkout-aktiva-tetap::')->group(function() {
        Route::post('/create', 'CheckoutAktivaTetapController@postCreate')->name('post-create');
        Route::post('/edit/{id}', 'CheckoutAktivaTetapController@postEdit')->name('post-edit');
        Route::post('/approve/{id}', 'CheckoutAktivaTetapController@postApprove')->name('post-approve');
        Route::get('/{id}.json', 'CheckoutAktivaTetapController@getJsonDetail')->name('get-json-detail');
    });

    Route::prefix('/checkout/inventory')->name('checkout-inventory::')->group(function() {
        Route::post('/create', 'CheckoutInventoryController@postCreate')->name('post-create');
        Route::post('/edit/{id}', 'CheckoutInventoryController@postEdit')->name('post-edit');
        Route::post('/approve/{id}', 'CheckoutInventoryController@postApprove')->name('post-approve');
        Route::get('/{id}.json', 'CheckoutInventoryController@getJsonDetail')->name('get-json-detail');
    });

    Route::prefix('/checkout/inventory/pos')->name('pos-checkout-inventory::')->group(function() {
        Route::post('/create', 'PosCheckoutInventoryController@postCreate')->name('post-create');
        Route::post('/edit/{id}', 'PosCheckoutInventoryController@postEdit')->name('post-edit');
        Route::post('/approve/{id}', 'PosCheckoutInventoryController@postApprove')->name('post-approve');
        Route::get('/{id}.json', 'PosCheckoutInventoryController@getJsonDetail')->name('get-json-detail');
    });

    /**
     * ----------------------------------------------------------------------------------------------
     * Route Adjustment 3 Tipe Asset
     * ----------------------------------------------------------------------------------------------
     */
    Route::prefix('/adjustment/extracomptable')->name('adjustment-extracomptable::')->group(function() {
        Route::post('/create', 'AdjustmentExtracomptableController@postCreate')->name('post-create');
        Route::post('/edit/{id}', 'AdjustmentExtracomptableController@postEdit')->name('post-edit');
    });

    Route::prefix('/adjustment/aktiva-tetap')->name('adjustment-aktiva-tetap::')->group(function() {
        Route::post('/create', 'AdjustmentAktivaTetapController@postCreate')->name('post-create');
        Route::post('/edit/{id}', 'AdjustmentAktivaTetapController@postEdit')->name('post-edit');
    });

    Route::prefix('/adjustment/inventory')->name('adjustment-inventory::')->group(function() {
        Route::post('/create', 'AdjustmentInventoryController@postCreate')->name('post-create');
        Route::post('/edit/{id}', 'AdjustmentInventoryController@postEdit')->name('post-edit');
    });

    /**
     * ----------------------------------------------------------------------------------------------
     * Route Pemeliharaan 2 Tipe Asset
     * ----------------------------------------------------------------------------------------------
     */
    Route::prefix('/pemeliharaan/extracomptable')->name('pemeliharaan-extracomptable::')->group(function() {
        Route::post('/create', 'PemeliharaanExtracomptableController@postCreate')->name('post-create');
        Route::post('/edit/{id}', 'PemeliharaanExtracomptableController@postEdit')->name('post-edit');
    });

    Route::prefix('/pemeliharaan/aktiva-tetap')->name('pemeliharaan-aktiva-tetap::')->group(function() {
        Route::post('/create', 'PemeliharaanAktivaTetapController@postCreate')->name('post-create');
        Route::post('/edit/{id}', 'PemeliharaanAktivaTetapController@postEdit')->name('post-edit');
    });

    /**
     * ----------------------------------------------------------------------------------------------
     * Route CRUD user group
     * ----------------------------------------------------------------------------------------------
     */
    Route::prefix('/user-group')->name('user-group::')->group(function() {
        Route::get('/', 'UserGroupController@index')->name('index');
        Route::get('list.json', 'UserGroupController@getJsonList')->name('json-list');
        Route::get('/create', 'UserGroupController@formCreate')->name('form-create');
        Route::post('/create', 'UserGroupController@postCreate')->name('post-create');
        Route::get('/edit/{id}', 'UserGroupController@formEdit')->name('form-edit');
        Route::post('/edit/{id}', 'UserGroupController@postEdit')->name('post-edit');
        Route::post('/deletes', 'UserGroupController@deletes')->name('deletes');
    });

});

/**
 * ----------------------------------------------------------------------------------------------
 * Route API Khusus Web
 * ----------------------------------------------------------------------------------------------
 */
Route::prefix('/json')->group(function() {

    Route::name('lokasi::')->prefix('/lokasi')->group(function() {
        Route::get('/options-gedung', 'LokasiController@jsonGetOptionsGedung')->name('json-options-gedung');
        Route::get('/options-lantai', 'LokasiController@jsonGetOptionsLantai')->name('json-options-lantai');
        Route::get('/options-ruang', 'LokasiController@jsonGetOptionsRuang')->name('json-options-ruang');
    });

    Route::name('jenis-extracomptable::')->prefix('/jenis-extracomptable')->group(function() {
        Route::get('/options-jenis', 'JenisExtracomptableController@jsonGetOptionsJenis')->name('json-options-jenis');
        Route::get('/options-subjenis', 'JenisExtracomptableController@jsonGetOptionsSubJenis')->name('json-options-subjenis');
    });

    Route::name('asset-extracomptable::')->prefix('/asset-extracomptable')->group(function() {
        Route::get('/quantity', 'AssetExtracomptableController@jsonGetQuantity')->name('json-get-quantity');
        Route::get('/detail/{kd_asset}', 'AssetExtracomptableController@jsonGetDetailAsset')->name('json-get-detail-asset');
        Route::get('/kode-asset', 'AssetExtracomptableController@jsonGetKodeAsset')->name('json-get-kode-asset');
    });

    Route::name('asset-aktiva-tetap::')->prefix('/asset-aktiva-tetap')->group(function() {
        Route::get('/quantity', 'AssetAktivaTetapController@jsonGetQuantity')->name('json-get-quantity');
        Route::get('/detail/{kd_asset}', 'AssetAktivaTetapController@jsonGetDetailAsset')->name('json-get-detail-asset');
        Route::get('/kode-asset', 'AssetAktivaTetapController@jsonGetKodeAsset')->name('json-get-kode-asset');
    });

    Route::name('asset-inventory::')->prefix('/asset-inventory')->group(function() {
        Route::get('/quantity', 'AssetInventoryController@jsonGetQuantity')->name('json-get-quantity');
        Route::get('/detail/{kd_asset}', 'AssetInventoryController@jsonGetDetailAsset')->name('json-get-detail-asset');
        Route::get('/kode-asset', 'AssetInventoryController@jsonGetKodeAsset')->name('json-get-kode-asset');
    });

    Route::name('pos-asset-inventory::')->prefix('/asset-inventory/pos')->group(function() {
        Route::get('/quantity', 'PosAssetInventoryController@jsonGetQuantity')->name('json-get-quantity');
        Route::get('/detail/{kd_asset}', 'PosAssetInventoryController@jsonGetDetailAsset')->name('json-get-detail-asset');
        Route::get('/kode-asset', 'PosAssetInventoryController@jsonGetKodeAsset')->name('json-get-kode-asset');
    });
    
    

});
