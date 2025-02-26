<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LokasiTest extends TestCase
{
    /**
     * Test Json Get Options Gedung
     *
     * @return void
     */
    public function testJsonGetOptionsGedung()
    {
        $response = $this->json('GET', '/json/lokasi/options-gedung');
        $response->assertJsonStructure([
            'list_gedung'
        ]);
        $result = $response->json();
        $this->assertTrue(is_array($result['list_gedung']));
    }

    /**
     * Test Json Get Options Lantai
     *
     * @return void
     */
    public function testJsonGetOptionsLantai()
    {
        $response = $this->json('GET', '/json/lokasi/options-lantai', ['id_gedung' => 1]);
        $response->assertJsonStructure([
            'list_lantai'
        ]);
        $result = $response->json();
        $this->assertTrue(is_array($result['list_lantai']));
    }

    /**
     * Test Json Get Options Ruang
     *
     * @return void
     */
    public function testJsonGetOptionsRuang()
    {
        $response = $this->json('GET', '/json/lokasi/options-ruang', ['id_gedung' => 1, 'lantai' => 1]);
        $response->assertJsonStructure([
            'list_ruang'
        ]);
        $result = $response->json();
        $this->assertTrue(is_array($result['list_ruang']));
    }
}
