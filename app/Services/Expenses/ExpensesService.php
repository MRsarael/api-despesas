<?php

namespace app\Services\Expenses;

use App\Repositories\ExpensesRepository;

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

    public function all()
    {
        return $this->expensesRepository->getAll();
    }
}