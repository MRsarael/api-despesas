<?php

namespace App\FormRequests\Expenses;

use App\Rules\EmailValidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'descriptionExpense' => ['required', 'string'],
            'dateExpense'        => ['required', 'date_format:Y-m-d'],
            'valueExpense'       => ['required', 'numeric', 'between:0,99999.99']
        ];
    }
}
