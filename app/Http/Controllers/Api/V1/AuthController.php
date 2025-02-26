<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Concerns\Authenticator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends ApiController
{

    use Authenticator;

    public function signin(Request $req)
    {
        $user = $this->findUserByAuthCredential($req->get('username'), $req->get('password'));

        if (!$user) {
            return $this->apiError('invalid_credentials', 401);
        }

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->apiError('could_not_create_token', 500);
        }

        // all good so return the token
        return $this->apiSuccess(compact('token'));
    }

    public function signout(Request $req)
    {
        $token = JWTAuth::getToken();
        if ($token) {
            JWTAuth::invalidate($token);
        }

        return $this->apiSuccess();
    }

    public function user(Request $req)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return $this->apiError('user_not_found', 404);
            }
        } catch (TokenExpiredException $e) {
            return $this->apiError('token_expired', $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return $this->apiError('token_invalid', $e->getStatusCode());
        } catch (JWTException $e) {
            return $this->apiError('token_absent', $e->getStatusCode());
        }

        // the token is valid and we have found the user via the sub claim
        return $this->apiSuccess([
            'user' => [
                'id' => $user->getKey(),
                'email' => $user->email,
                'name' => $user->name,
                'karyawan' => $user->karyawan? $user->karyawan->toArray() : null,
                'photo' => [
                    'path' => $user->photo,
                    'url' => asset($user->photo)
                ],
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => ($user->updated_at ?: $user->created_at)->format('Y-m-d H:i:s'),
                'permissions' => $user->getMobilePermissions(),
                'status' => $user->status,
            ]
        ]);
    }

}
