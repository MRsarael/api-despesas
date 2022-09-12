<?php

namespace App\Services\Auth;

use App\FormRequests\Auth\LoginFormRequest;

use App\Utils\Util;
use Carbon\Carbon;
use Exception;
use Validator;

class AuthService
{
    public function __construct()
    {
        //...
    }
    
    /**
     * Initialize user token.
     *
     * @return Array
     */
    public function execute(array $requestData)
    {
        $validator = Validator::make($requestData, (new LoginFormRequest)->rules());

        if ($validator->fails()) {
            throw new Exception(Util::convertMessageErrorFormRequest($validator->errors()->messages()));
        }

        $credentials = [
            'password' => $requestData['password'],
            'email'    => $requestData['email']
        ];

        $token = auth()->setTTL(6*60)->attempt($credentials);

        if(!$token) throw new Exception("Not authorized", 401);

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out.
     *
     * @return Bool
     */
    public function logout()
    {
        auth()->logout();
        return true;
    }

    /**
     * Refresh token user logged.
     *
     * @param  string $token
     *
     * @return Array
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * return data of user logged.
     *
     * @param  string $token
     *
     * @return Array
     */
    public function getUserLogged()
    {
        $user = auth()->user();

        if($user != null && $user->count()) {
            $user = $user->toArray();
            $user['id'] = bcrypt($user['id']);
            return $user;
        }

        throw new Exception("User logged out");
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
            'user'         => $this->getUserLogged()
        ];
    }
}