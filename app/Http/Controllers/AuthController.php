<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Auth\LoginService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    private $service;
    private $request;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(LoginService $loginService, Request $request)
    {
        $this->service = $loginService;
        $this->request = $request;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        try {
            $credentials = [
                'email'    => $this->request->get('email'),
                'password' => $this->request->get('password')
            ];
    
            $token = $this->service->execute($credentials);
    
            return response()->json($token, 200);
        } catch (\Exception $e) {
            return response()->json([
                'response' => [],
                'error'    => true,
                'message'  => $e->getMessage()
            ], $e->getCode() ? $e->getCode() : 500);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        //...
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        //...
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        //...
    }
}
