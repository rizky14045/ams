<?php

namespace Tests\Feature\Api\V1;

use App\Models\AssetAktivaTetap;
use App\Models\AdjustmentAktivaTetap;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Tests\ApiTestCase;

class AdjustmentAktivaTetapControllerTest extends ApiTestCase
{

    use DatabaseTransactions;

    protected $endpoint = '/adjustment/aktiva-tetap';

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

        $response
        ->assertStatus(200)
        ->assertJson([
            'status' => 'success',
        ])
        ->assertJsonStructure([
            'status',
            'data' => [
                'adjustment'
            ]
        ]);
    }

    protected function getDummyData()
    {
        $data = factory(AdjustmentAktivaTetap::class)->make()->toArray();
        $data['items'] = AssetAktivaTetap::select([
            'id_model',
            \DB::raw('3 as new_qty'),
            \DB::raw('"lorem ipsum" as description')
        ])
        ->take(3)
        ->get()
        ->toArray();

        return $data;
    }
}
