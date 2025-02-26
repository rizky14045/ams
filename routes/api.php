<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->name('api.v1::')->namespace('V1')->group(function() {

    Route::prefix('auth')->name('auth.')->group(function() {
        Route::post('signin', 'AuthController@signin')->name('signin');
        Route::post('signout', 'AuthController@signout')->name('signout');
        Route::middleware(['jwt.auth'])->get('user', 'AuthController@user')->name('user');
    });

    Route::middleware(['jwt.auth'])->group(function() {

        /**
         * ----------------------------------------------------------------------------------------------
         * Route Data Master
         * ----------------------------------------------------------------------------------------------
         */
        Route::prefix('/gedung')->name('gedung::')->group(function() {
            Route::get('/', 'GedungController@getList')->name('get-list');
        });

        Route::prefix('/ruang')->name('ruang::')->group(function() {
            Route::get('/', 'RuangController@getList')->name('get-list');
        });

        Route::prefix('/jenis-extracomptable')->name('jenis-extracomptable::')->group(function() {
            Route::get('/', 'JenisExtracomptableController@getList')->name('get-list');
        });

        Route::prefix('/subjenis-extracomptable')->name('subjenis-extracomptable::')->group(function() {
            Route::get('/', 'SubJenisExtracomptableController@getList')->name('get-list');
        });

        Route::prefix('/model-aktiva-tetap')->name('model-aktiva-tetap::')->group(function() {
            Route::get('/', 'ModelAktivaTetapController@getList')->name('get-list');
        });

        Route::prefix('/kategori-inventory')->name('kategori-inventory::')->group(function() {
            Route::get('/', 'KategoriInventoryController@getList')->name('get-list');
        });

        /**
         * ----------------------------------------------------------------------------------------------
         * Route 3 Jenis Asset
         * ----------------------------------------------------------------------------------------------
         */
        Route::prefix('/asset/extracomptable')->name('asset-extracomptable::')->group(function() {
            Route::get('/', 'AssetExtracomptableController@getList')->name('get-list');
            Route::post('/', 'AssetExtracomptableController@postCreate')->name('post-create');
            Route::get('/qty', 'AssetExtracomptableController@getQuantity')->name('get-qty');
            Route::get('/{id}', 'AssetExtracomptableController@getDetail')->name('get-detail');
            Route::get('/{id}/histories', 'AssetExtracomptableController@getHistories')->name('get-histories');
            // Route::put('/{id}', 'AssetExtracomptableController@postEdit')->name('post-edit');
            Route::get('/history/checkout/{kd_asset}', 'AssetExtracomptableController@getHistoryCheckout')->name('get-history-checkout');
            // Route::get('/history/adjustment/{kd_asset}', 'AssetExtracomptableController@getHistoryAdjustment')->name('get-history-adjustment');
        });

        Route::prefix('/asset/aktiva-tetap')->name('asset-aktiva-tetap::')->group(function() {
            Route::get('/', 'AssetAktivaTetapController@getList')->name('get-list');
            Route::post('/', 'AssetAktivaTetapController@postCreate')->name('post-create');
            Route::get('/qty', 'AssetAktivaTetapController@getQuantity')->name('get-qty');
            Route::get('/{id}', 'AssetAktivaTetapController@getDetail')->name('get-detail');
            Route::get('/{id}/histories', 'AssetAktivaTetapController@getHistories')->name('get-histories');
            // Route::put('/{id}', 'AssetAktivaTetapController@postEdit')->name('post-edit');
            Route::get('/history/checkout/{kd_asset}', 'AssetAktivaTetapController@getHistoryCheckout')->name('get-history-checkout');
            // Route::get('/history/adjustment/{kd_asset}', 'AssetAktivaTetapController@getHistoryAdjustment')->name('get-history-adjustment');
        });

        Route::prefix('/asset/inventory')->name('asset-inventory::')->group(function() {
            Route::get('/', 'AssetInventoryController@getList')->name('get-list');
            Route::post('/', 'AssetInventoryController@postCreate')->name('post-create');
            Route::get('/qty', 'AssetInventoryController@getQuantity')->name('get-qty');
            Route::get('/{id}', 'AssetInventoryController@getDetail')->name('get-detail');
            Route::get('/{id}/histories', 'AssetInventoryController@getHistories')->name('get-histories');
            // Route::put('/{id}', 'AssetInventoryController@postEdit')->name('post-edit');
            Route::get('/history/checkout/{kd_asset}', 'AssetInventoryController@getHistoryCheckout')->name('get-history-checkout');
            // Route::get('/history/adjustment/{kd_asset}', 'AssetInventoryController@getHistoryAdjustment')->name('get-history-adjustment');
        });

        /**
         * ----------------------------------------------------------------------------------------------
         * Route Request 3 Jenis Asset
         * ----------------------------------------------------------------------------------------------
         */
        Route::prefix('/request/extracomptable')->name('request-extracomptable::')->group(function() {
            Route::get('/', 'RequestExtracomptableController@getList')->name('get-list');
            Route::post('/', 'RequestExtracomptableController@postCreate')->name('post-create');
            Route::get('/{id}', 'RequestExtracomptableController@getDetail')->name('get-detail');
            // Route::put('/{id}', 'RequestExtracomptableController@postEdit')->name('post-edit');
        });

        Route::prefix('/request/aktiva-tetap')->name('request-aktiva-tetap::')->group(function() {
            Route::get('/', 'RequestAktivaTetapController@getList')->name('get-list');
            Route::post('/', 'RequestAktivaTetapController@postCreate')->name('post-create');
            Route::get('/{id}', 'RequestAktivaTetapController@getDetail')->name('get-detail');
            // Route::put('/{id}', 'RequestAktivaTetapController@postEdit')->name('post-edit');
        });

        Route::prefix('/request/inventory')->name('request-inventory::')->group(function() {
            Route::get('/', 'RequestInventoryController@getList')->name('get-list');
            Route::post('/', 'RequestInventoryController@postCreate')->name('post-create');
            Route::get('/{id}', 'RequestInventoryController@getDetail')->name('get-detail');
            // Route::put('/{id}', 'RequestInventoryController@postEdit')->name('post-edit');
        });

        /**
         * ----------------------------------------------------------------------------------------------
         * Route Checkout 3 Jenis Asset
         * ----------------------------------------------------------------------------------------------
         */
        Route::prefix('/checkout/extracomptable')->name('checkout-extracomptable::')->group(function() {
            Route::get('/', 'CheckoutExtracomptableController@getList')->name('get-list');
            Route::post('/', 'CheckoutExtracomptableController@postCreate')->name('post-create');
            Route::get('/{id}', 'CheckoutExtracomptableController@getDetail')->name('get-detail');
            // Route::put('/{id}', 'CheckoutExtracomptableController@postEdit')->name('post-edit');
        });

        Route::prefix('/checkout/aktiva-tetap')->name('checkout-aktiva-tetap::')->group(function() {
            Route::get('/', 'CheckoutAktivaTetapController@getList')->name('get-list');
            Route::post('/', 'CheckoutAktivaTetapController@postCreate')->name('post-create');
            Route::get('/{id}', 'CheckoutAktivaTetapController@getDetail')->name('get-detail');
            // Route::put('/{id}', 'CheckoutAktivaTetapController@postEdit')->name('post-edit');
        });

        Route::prefix('/checkout/inventory')->name('checkout-inventory::')->group(function() {
            Route::get('/', 'CheckoutInventoryController@getList')->name('get-list');
            Route::post('/', 'CheckoutInventoryController@postCreate')->name('post-create');
            Route::get('/{id}', 'CheckoutInventoryController@getDetail')->name('get-detail');
            // Route::put('/{id}', 'CheckoutInventoryController@postEdit')->name('post-edit');
        });

        /**
         * ----------------------------------------------------------------------------------------------
         * Route Adjustment 3 Tipe Asset
         * ----------------------------------------------------------------------------------------------
         */
        Route::prefix('/adjustment/extracomptable')->name('adjustment-extracomptable::')->group(function() {
            Route::get('/', 'AdjustmentExtracomptableController@getList')->name('get-list');
            Route::post('/', 'AdjustmentExtracomptableController@postCreate')->name('post-create');
            Route::get('/{id}', 'AdjustmentExtracomptableController@getDetail')->name('get-detail');
            // Route::put('/{id}', 'AdjustmentExtracomptableController@postEdit')->name('post-edit');
        });

        Route::prefix('/adjustment/aktiva-tetap')->name('adjustment-aktiva-tetap::')->group(function() {
            Route::get('/', 'AdjustmentAktivaTetapController@getList')->name('get-list');
            Route::post('/', 'AdjustmentAktivaTetapController@postCreate')->name('post-create');
            Route::get('/{id}', 'AdjustmentAktivaTetapController@getDetail')->name('get-detail');
            // Route::put('/{id}', 'AdjustmentAktivaTetapController@postEdit')->name('post-edit');
        });

        Route::prefix('/adjustment/inventory')->name('adjustment-inventory::')->group(function() {
            Route::get('/', 'AdjustmentInventoryController@getList')->name('get-list');
            Route::post('/', 'AdjustmentInventoryController@postCreate')->name('post-create');
            Route::get('/{id}', 'AdjustmentInventoryController@getDetail')->name('get-detail');
            // Route::put('/{id}', 'AdjustmentInventoryController@postEdit')->name('post-edit');
        });

        /**
         * ----------------------------------------------------------------------------------------------
         * Route Pemeliharaan 2 Tipe Asset
         * ----------------------------------------------------------------------------------------------
         */
        Route::prefix('/pemeliharaan/extracomptable')->name('pemeliharaan-extracomptable::')->group(function() {
            Route::get('/', 'PemeliharaanExtracomptableController@getList')->name('get-list');
            Route::post('/', 'PemeliharaanExtracomptableController@postCreate')->name('post-create');
            Route::get('/{id}', 'PemeliharaanExtracomptableController@getDetail')->name('get-detail');
            // Route::put('/{id}', 'PemeliharaanExtracomptableController@postEdit')->name('post-edit');
        });

        Route::prefix('/jenis-pemeliharaan')->name('jenis-pemeliharaan::')->group(function() {
            Route::get('/extracomptable', 'JenisPemeliharaanController@extracomptable')->name('extracomptable');
            Route::get('/aktiva-tetap', 'JenisPemeliharaanController@aktivaTetap')->name('aktiva-tetap');
        });

        Route::prefix('/status-asset')->name('status-asset::')->group(function() {
            Route::get('/extracomptable', 'StatusAssetController@extracomptable')->name('extracomptable');
            Route::get('/aktiva-tetap', 'StatusAssetController@aktivaTetap')->name('aktiva-tetap');
        });

        Route::prefix('/pemeliharaan/aktiva-tetap')->name('pemeliharaan-aktiva-tetap::')->group(function() {
            Route::get('/', 'PemeliharaanAktivaTetapController@getList')->name('get-list');
            Route::post('/', 'PemeliharaanAktivaTetapController@postCreate')->name('post-create');
            Route::get('/{id}', 'PemeliharaanAktivaTetapController@getDetail')->name('get-detail');
            // Route::put('/{id}', 'PemeliharaanAktivaTetapController@postEdit')->name('post-edit');
        });

    });

});
