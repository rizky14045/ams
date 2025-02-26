<?php

namespace Tests;

use App\Models\User;

abstract class ApiTestCase extends TestCase
{

    protected $apiVersion = 'v1';
    protected $endpoint = '/';
    protected $token = null;

    public function request($method, $path, array $data = [], array $headers = [])
    {
        $apiVersion = $this->apiVersion;
        $endpoint = trim($this->endpoint, '/');
        $path = trim($path, '/');
        $uri = "/api/{$apiVersion}/{$endpoint}/{$path}";

        if ($this->token) {
            $headers = array_merge($headers, [
                'Authorization' => "Bearer {$this->token}"
            ]);
        }

        return $this->json($method, $uri, $data, $headers);
    }

    public function getAuthCredentials()
    {
        return [
            'username' => 'admin@ditamadigital.co.id',
            'password' => 'jangan-lupa'
        ];
    }

    protected function as(User $user)
    {
        $this->token = $this->getAuthToken($user);
        return $this;
    }

    protected function asSuperadmin()
    {
        $email = $this->getAuthCredentials()['username'];
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new \UnexpectedValueException("User with email '{$email}' that used in api tests doesn't exists. Change that in '".__FILE__."'.");
        }

        return $this->as($user);
    }

    protected function asGuest()
    {
        $this->token = null;
        return $this;
    }

    protected function getAuthToken($user)
    {
        return \JWTAuth::fromUser($user);
    }
}
