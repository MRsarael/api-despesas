<?php

namespace App\Http\Controllers\Expenses;

use App\Services\Expenses\ExpensesService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    private $service;
    private $request;

    /**
     * Create a new ExpensesController instance.
     *
     * @return void
     */
    public function __construct(ExpensesService $expensesService, Request $request)
    {
        $this->service = $expensesService;
        $this->request = $request;
    }

    /**
     * Returns all registered expenses.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $response = ['response' => [], 'error' => false, 'message' => 'Success'];
        $code = 200;
        
        try {
            $response['response'] = $this->service->all();
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = 400;
        }

        return response()->json($response, $code);
    }
}
