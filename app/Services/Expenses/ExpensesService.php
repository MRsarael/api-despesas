<?php

namespace app\Services\Expenses;

use App\Repositories\ExpensesRepository;

use App\FormRequests\Expenses\StoreFormRequest;
use App\FormRequests\Expenses\UpdateFormRequest;

use Illuminate\Support\Facades\Crypt;

use App\Events\StoreExpense;

use App\Utils\Util;
use Carbon\Carbon;
use Exception;
use Validator;

class ExpensesService
{
    private $expensesRepository;

    public function __construct(ExpensesRepository $expensesRepository)
    {
        $this->expensesRepository = $expensesRepository;
    }

    /**
     * Returns all registered expenses of user.
     *
     * @return Array
     */
    public function index()
    {
        $response = array();
        $expenses = $this->expensesRepository->getExpensesUser(auth()->user()->id);
        
        if($expenses != null && $expenses->count()) {
            foreach ($expenses as $key => $expense) {
                $response[] = [
                    'expenseId'          => base64_encode($expense['expenseId']),
                    'userId'             => bcrypt($expense['userId']),
                    'descriptionExpense' => $expense['descriptionExpense'],
                    'dateExpense'        => $expense['dateExpense'],
                    'valueExpense'       => $expense['valueExpense'],
                    'createdExpense'     => $expense['createdExpense'],
                    'nameUser'           => $expense['nameUser'],
                    'emailUser'          => $expense['emailUser']
                ];
            }
        }
        
        return $response;
    }

    /**
     * Add a new expense.
     *
     * @return Array
     */
    public function store(array $storeData)
    {
        $validator = Validator::make($storeData, (new StoreFormRequest)->rules());

        if ($validator->fails()) {
            throw new Exception(Util::convertMessageErrorFormRequest($validator->errors()->messages()));
        }

        $expense = $this->expensesRepository->insertExpense(
            auth()->user()->id,
            $storeData['descriptionExpense'],
            $storeData['dateExpense'],
            $storeData['valueExpense']
        );

        event(new StoreExpense(auth()->user(), $expense));
        
        return [
            'expenseId'          => base64_encode($expense->id),
            'descriptionExpense' => $expense->description,
            'dateExpense'        => $expense->expense_date,
            'valueExpense'       => $expense->value,
            'createdExpense'     => $expense->created_at
        ];
    }

    /**
     * Display expense data.
     *
     * @return Array
     */
    public function show($expenseId)
    {
        $response = array();
        $expenses = $this->expensesRepository->getExpenses(base64_decode($expenseId));

        if($expenses != null && $expenses->count()) {
            $expense = $expenses[0];

            $response[] = [
                'expenseId'          => base64_encode($expense['expenseId']),
                'userId'             => bcrypt($expense['userId']),
                'descriptionExpense' => $expense['descriptionExpense'],
                'dateExpense'        => $expense['dateExpense'],
                'valueExpense'       => $expense['valueExpense'],
                'createdExpense'     => $expense['createdExpense'],
                'nameUser'           => $expense['nameUser'],
                'emailUser'          => $expense['emailUser']
            ];
        }

        return $response;
    }

    /**
     * Edit expense.
     *
     * @return Array
     */
    public function update(array $updateData)
    {
        $response = array();
        $validator = Validator::make($updateData, (new UpdateFormRequest)->rules());

        if ($validator->fails()) {
            throw new Exception(Util::convertMessageErrorFormRequest($validator->errors()->messages()));
        }

        $expense = $this->expensesRepository->updateExpense(
            base64_decode($updateData['expenseId']),
            $updateData['descriptionExpense'],
            $updateData['dateExpense'],
            $updateData['valueExpense']
        );

        if($expense != null && $expense->count()) {
            $expense = $expense[0];

            $response[] = [
                'expenseId'          => base64_encode($expense['expenseId']),
                'userId'             => bcrypt($expense['userId']),
                'descriptionExpense' => $expense['descriptionExpense'],
                'dateExpense'        => $expense['dateExpense'],
                'valueExpense'       => $expense['valueExpense'],
                'createdExpense'     => $expense['createdExpense'],
                'nameUser'           => $expense['nameUser'],
                'emailUser'          => $expense['emailUser']
            ];
        }

        return $response;
    }

    /**
     * Delete expense.
     *
     * @return Array
     */
    public function destroy($expenseId)
    {
        $expenseIdDecript = base64_decode($expenseId);
        $response = ['response' => [], 'error' => false, 'message' => 'Expense successfully deleted', 'code' => 200];
        $expenses = $this->expensesRepository->getExpenses($expenseIdDecript);

        if($expenses == null || !$expenses->count()) {
            $response['response'] = array();
            $response['error'] = true;
            $response['message'] = "Expense not found";
            return $response;
        }
        
        $this->expensesRepository->deleteExpense($expenseIdDecript);
        return $response;
    }
}