<?php

namespace Tests\Feature\Api\V1;

use App\Models\Gedung;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Tests\ApiTestCase;

class GedungControllerTest extends ApiTestCase
{

    use DatabaseTransactions;

    protected $endpoint = '/gedung';

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
}
