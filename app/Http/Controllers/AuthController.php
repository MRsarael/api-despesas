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
        $response = ['response' => [], 'error' => false, 'message' => 'Success'];
        $code = 200;

        try {
            $response['response'] = $this->service->execute($this->request->all());
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = $e->getCode() ? $e->getCode() : 404;
        }

        return response()->json($response, $code);
    }

    /**
     * Check if the user is logged in.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyLogin()
    {
        return $this->login();
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $response = ['response' => [], 'error' => false, 'message' => 'Success'];
        $code = 200;

        try {
            $response['response'] = auth()->user();
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = $e->getCode() ? $e->getCode() : 404;
        }

        return response()->json($response, $code);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $response = ['response' => [], 'error' => false, 'message' => 'Successfully logged out'];
        $code = 200;

        try {
            $this->service->logout();
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = $e->getCode() ? $e->getCode() : 404;
        }

        return response()->json($response, $code);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $response = ['response' => [], 'error' => false, 'message' => 'Success'];
        $code = 200;

        try {
            $response['response'] = $this->service->refresh();
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = $e->getCode() ? $e->getCode() : 404;
        }

        return response()->json($response, $code);
    }
}
