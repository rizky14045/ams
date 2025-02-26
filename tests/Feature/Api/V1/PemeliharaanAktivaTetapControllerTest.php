<?php

namespace Tests\Feature\Api\V1;

use App\Models\AssetAktivaTetap;
use App\Models\PemeliharaanAktivaTetap;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Tests\ApiTestCase;

class PemeliharaanAktivaTetapControllerTest extends ApiTestCase
{

    use DatabaseTransactions;

    protected $endpoint = '/pemeliharaan/aktiva-tetap';

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
        $response = $this->asSuperadmin()->request('GET', '/1');

        // $response->dump();

        $response
        ->assertStatus(200)
        ->assertJson([
            'status' => 'success',
        ])
        ->assertJsonStructure([
            'status',
            'data'
        ]);
    }

    /**
     * Test successful post create
     *
     * @return void
     */
    public function testPostCreate()
    {
        $data = $this->getDummyData();

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
                'pemeliharaan'
            ]
        ]);
    }

    protected function getDummyData()
    {
        $data = factory(PemeliharaanAktivaTetap::class)->make()->toArray();
        $data['items'] = AssetAktivaTetap::select(['id as id_asset'])
        ->take(3)
        ->get()
        ->toArray();

        return $data;
    }
}
