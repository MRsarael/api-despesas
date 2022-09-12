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
     * Returns all registered expenses of user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $response = ['response' => [], 'error' => false, 'message' => 'Success'];
        $code = 200;
        
        try {
            $response['response'] = $this->service->index();
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = 404;
        }

        return response()->json($response, $code);
    }

    /**
     * Add a new expense.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $response = ['response' => [], 'error' => false, 'message' => 'Success'];
        $code = 201;
        
        try {
            $response['response'] = $this->service->store($this->request->all());
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = 404;
        }

        return response()->json($response, $code);
    }

    /**
     * Displays specific expense.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($expenseId)
    {
        $response = ['response' => [], 'error' => false, 'message' => 'Success'];
        $code = 200;
        
        try {
            $response['response'] = $this->service->show($expenseId);
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = 404;
        }

        return response()->json($response, $code);
    }

    /**
     * Edit expense.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        $response = ['response' => [], 'error' => false, 'message' => 'Success'];
        $code = 200;
        
        try {
            $response['response'] = $this->service->update($this->request->all());
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = 404;
        }

        return response()->json($response, $code);
    }

    /**
     * Delete expense.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($expenseId)
    {
        $response = ['response' => [], 'error' => false, 'message' => 'Expense successfully deleted'];
        $code = 200;
        
        try {
            $result = $this->service->destroy($expenseId);
            $response['response'] = $result['response'];
            $response['error'] = $result['error'];
            $response['message'] = $result['message'];
            $code = $result['code'];
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = $e->getCode() ? $e->getCode() : 404;
        }
        
        return response()->json($response, $code);
    }
}
