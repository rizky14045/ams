<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AssetExtracomptableControllerTest extends TestCase
{
    /**
     * Test Json Get Kode Asset
     *
     * @return void
     */
    public function testJsonGetKodeAsset()
    {
        $response = $this->json('GET', '/json/asset-extracomptable/kode-asset', [
            'id_gedung' => 1,
            'lantai' => 1,
            'id_ruang' => 1,
            'id_jenis' => 1,
            'id_subjenis' => 1
        ]);

        $response->assertJsonStructure([
            'kode_asset'
        ]);

        $result = $response->json();
        $this->assertTrue(is_string($result['kode_asset']));
    }
}
