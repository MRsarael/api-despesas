<?php

namespace App\Http\Controllers\User;

use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{
    private $service;
    private $request;

    /**
     * Create a new UserController instance.
     *
     * @return void
     */
    public function __construct(UserService $userService, Request $request)
    {
        $this->service = $userService;
        $this->request = $request;
    }

    /**
     * Create a new User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function newUser()
    {
        $response = ['response' => [], 'error' => false, 'message' => 'Success'];
        $code = 200;

        try {
            $response['response'] = $this->service->newUser($this->request->all());
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = 404;
        }

        return response()->json($response, $code);
    }
}
