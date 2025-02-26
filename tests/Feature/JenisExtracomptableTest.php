<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class JenisExtracomptableTest extends TestCase
{
    /**
     * Test Json Get Options Jenis Extracomptable
     *
     * @return void
     */
    public function testJsonOptionsJenisExtracomptable()
    {
        $response = $this->json('GET', '/json/jenis-extracomptable/options-jenis');
        $response->assertJsonStructure([
            'list_jenis'
        ]);
        $result = $response->json();
        $this->assertTrue(is_array($result['list_jenis']));
    }

    /**
     * Test Json Get Options Sub Jenis Extracomptable
     *
     * @return void
     */
    public function testJsonOptionsSubJenisExtracomptable()
    {
        $response = $this->json('GET', '/json/jenis-extracomptable/options-subjenis', ['id_jenis' => 1]);
        $response->assertJsonStructure([
            'list_subjenis'
        ]);
        $result = $response->json();
        $this->assertTrue(is_array($result['list_subjenis']));
    }
}
