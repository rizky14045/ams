<?php

namespace App\Http\Controllers\Concerns;

use App\Models\User;

trait Authenticator
{

    protected $columnId = 'email';
    protected $columnPassword = 'password';

    public function findUserByAuthCredential($id, $password)
    {
        $user = User::where($this->columnId, $id)->first();
        if (!$user) return null;

        if (!password_verify($password, $user->{$this->columnPassword})) {
            return null;
        } else {
            return $user;
        }
    }

}
