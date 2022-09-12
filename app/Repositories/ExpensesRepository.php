<?php

namespace App\Repositories;

use App\Expenses;

class ExpensesRepository
{
    private $model;

    public function __construct(Expenses $expenses)
    {
        $this->model = $expenses;
    }

    public function insertExpense($idUser, $descriptionExpense, $dateExpense, $valueExpense)
    {
        return $this->model->create([
            'user_id'      => $idUser,
            'description'  => $descriptionExpense,
            'expense_date' => $dateExpense,
            'value'        => $valueExpense
        ]);
    }

    public function updateExpense($expenseId, $descriptionExpense, $dateExpense, $valueExpense)
    {
        $this->model->find($expenseId)->update([
            'description'  => $descriptionExpense,
            'expense_date' => $dateExpense,
            'value'        => $valueExpense
        ]);
        
        return $this->getExpenses($expenseId);
    }

    public function deleteExpense($expenseId)
    {
        return $this->model->find($expenseId)->delete();
    }

    public function getExpensesUser($idUser)
    {
        return $this->model->select(
            'expenses.id AS expenseId',
            'expenses.user_id AS userId',
            'expenses.description AS descriptionExpense',
            'expenses.expense_date AS dateExpense',
            'expenses.value AS valueExpense',
            'expenses.created_at AS createdExpense',
	        'users.name AS nameUser',
            'users.email AS emailUser'
        )
        ->join('users', 'users.id', '=', 'expenses.user_id')
        ->where('expenses.user_id', $idUser)->get();
    }

    public function getExpenses($expenseId)
    {
        return $this->model->select(
            'expenses.id AS expenseId',
            'expenses.user_id AS userId',
            'expenses.description AS descriptionExpense',
            'expenses.expense_date AS dateExpense',
            'expenses.value AS valueExpense',
            'expenses.created_at AS createdExpense',
	        'users.name AS nameUser',
            'users.email AS emailUser'
        )
        ->join('users', 'users.id', '=', 'expenses.user_id')
        ->where('expenses.id', $expenseId)->get();
    }
}
