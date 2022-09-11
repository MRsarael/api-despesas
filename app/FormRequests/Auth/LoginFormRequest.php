<?php

namespace App\FormRequests\Auth;

use App\Rules\EmailValidation;
use Illuminate\Foundation\Http\FormRequest;

class LoginFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => [new EmailValidation()],
            'password' => ['required', 'string', 'max:255'],
        ];
    }
}
