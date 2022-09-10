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

    public function getAll()
    {
        return $this->model->all();
    }
}
