<?php

namespace App\FormRequests\Expenses;

use App\Rules\EmailValidation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'expenseId'          => ['required', 'string'],
            'descriptionExpense' => ['required', 'string'],
            'dateExpense'        => ['required', 'date_format:Y-m-d'],
            'valueExpense'       => ['required', 'numeric', 'between:0,99999.99']
        ];
    }
}
