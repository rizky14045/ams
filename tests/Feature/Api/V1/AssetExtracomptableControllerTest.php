<?php

namespace Tests\Feature\Api\V1;

use App\Models\AssetExtracomptable;
use App\Models\ItemCheckoutExtracomptable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Tests\ApiTestCase;

class AssetExtracomptableControllerTest extends ApiTestCase
{

    use DatabaseTransactions;

    protected $endpoint = '/asset/extracomptable';

    /**
     * Test get list
     *
     * @return void
     */
    public function testGetList()
    {
        $response = $this->asSuperadmin()->request('GET', '/');

        // $response->dump();

        $response
        ->assertStatus(200)
        ->assertJson([
            'status' => 'success',
        ])
        ->assertJsonStructure([
            'status',
            'meta' => [
                'limit',
                'offset',
                'q',
                'count_records',
                'fields'
            ],
            'data'
        ]);
    }

    /**
     * Test get detail
     *
     * @return void
     */
    public function testGetDetail()
    {
        $asset = AssetExtracomptable::first();
        $response = $this->asSuperadmin()->request('GET', '/'.$asset->getKey());

        // $response->dump();

        $response
        ->assertStatus(200)
        ->assertJson([
            'status' => 'success',
        ])
        ->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'kd_asset',
                'nama_asset',
            ]
        ]);
    }

    /**
     * Test get histories
     *
     * @return void
     */
    public function testGetHistories()
    {
        $log = \DB::table('log_asset_extracomptable')->first();
        $response = $this->asSuperadmin()->request('GET', "/{$log->id_asset}/histories");

        // $response->dump();

        $response
        ->assertStatus(200)
        ->assertJson([
            'status' => 'success',
        ])
        ->assertJsonStructure([
            'status',
            'data',
            'meta'
        ]);
    }

    /**
     * Test successful post create
     *
     * @return void
     */
    public function testPostCreate()
    {
        $data = factory(AssetExtracomptable::class)->make()->toArray();
        $data['gambar'] = UploadedFile::fake()->image('dummy.jpg');

        $response = $this->asSuperadmin()->request('POST', '/', $data);

        // $response->dump();

        $response
        ->assertStatus(200)
        ->assertJson([
            'status' => 'success',
        ])
        ->assertJsonStructure([
            'status',
            'data' => [
                'asset'
            ]
        ]);
    }

    /**
     * Test get history checkout
     *
     * @return void
     */
    public function testGetHistoryCheckout()
    {
        $asset = ItemCheckoutExtracomptable::has('asset')->first()->asset;
        $response = $this->asSuperadmin()->request('GET', "/history/checkout/{$asset->kd_asset}");

        // $response->dump();

        $response
        ->assertStatus(200)
        ->assertJson([
            'status' => 'success',
        ])
        ->assertJsonStructure([
            'status',
            'data' => [
                'asset' => [
                    'url_gambar'
                ],
                'history_checkout'
            ]
        ]);
    }

    /**
     * Test get quantity
     *
     * @return void
     */
    public function testGetQuantity()
    {
        $asset = AssetExtracomptable::first();
        $response = $this->asSuperadmin()->request('GET', "/qty", [
            'id_ruang' => $asset->id_ruang,
            'id_subjenis' => $asset->id_subjenis,
        ]);

        // $response->dump();

        $response
        ->assertStatus(200)
        ->assertJson([
            'status' => 'success',
        ])
        ->assertJsonStructure([
            'status',
            'data' => [
                'qty'
            ]
        ]);
    }

}
