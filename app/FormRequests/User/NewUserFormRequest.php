<?php

namespace App\FormRequests\User;

use App\Rules\EmailValidation;
use Illuminate\Foundation\Http\FormRequest;

class NewUserFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => [new EmailValidation()],
            'name'     => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ];
    }
}