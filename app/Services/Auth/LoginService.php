<?php

namespace App\Services\Auth;

use Exception;

class LoginService
{
    public function __construct()
    {
        //...
    }

    public function execute(array $credentials)
    {
        $token = auth()->setTTL(6*60)->attempt($credentials);
        
        if(!$token) {
            throw new Exception("Not authorized", 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return Array
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => auth()->factory()->getTTL(),
            'user'         => auth()->user()
        ];
    }
}