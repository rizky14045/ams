<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\ApiTestCase;

class AuthControllerTest extends ApiTestCase
{

    protected $endpoint = '/auth';

    /**
     * Test successful sign in
     *
     * @return void
     */
    public function testSuccessSignIn()
    {
        $credentials = $this->getAuthCredentials();
        $response = $this->asGuest()->request('POST', 'signin', $credentials);

        // $response->dump();

        $response
        ->assertStatus(200)
        ->assertJson([
            'status' => 'success',
        ])
        ->assertJsonStructure([
            'status',
            'data' => [
                'token'
            ]
        ]);
    }

    /**
     * Test failed sign in
     *
     * @return void
     */
    public function testFailedSignIn()
    {
        $response = $this->asGuest()->request('POST', 'signin', [
            'username' => 'random@mail.com',
            'password' => 'foobar'
        ]);

        // $response->dump();

        $response->assertStatus(401)
        ->assertJson([
            'status' => 'error',
            'error' => 'invalid_credentials'
        ]);
    }

    /**
     * Test get user data
     */
    public function testMe()
    {
        $response = $this->asSuperadmin()->request('GET', 'user');

        // $response->dump()

        $response
        ->assertStatus(200)
        ->assertJson([
            'status' => 'success',
        ])
        ->assertJsonStructure([
            'status',
            'data' => [
                'user' => [
                    'id',
                    'email',
                    'name',
                    'photo' => [
                        'path',
                        'url'
                    ],
                    'created_at',
                    'updated_at',
                    'permissions',
                    'status',
                ]
            ]
        ]);
    }

    /**
     * Test signout
     */
    public function testSignout()
    {
        $response = $this->asSuperadmin()->request('POST', 'signout');

        $response
        ->assertStatus(200)
        ->assertJson([
            'status' => 'success',
        ])
        ->assertJsonStructure([
            'status',
        ]);
    }
}
