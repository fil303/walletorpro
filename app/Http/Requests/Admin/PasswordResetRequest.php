<?php

namespace App\Http\Requests\Admin;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PasswordResetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           "current_password" => "required|string",
           "password" => 'required|string|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            "current_password.required" => _t("Enter your current password."),
            "current_password.string"   => _t("Current Password is invalid."),

            "password.required" => _t("Enter your password."),
            "password.confirmed"=> _t("Password confirmation not match."),
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? __("Something went wrong with validation");
        Response::throw(failed($error));
    }
}
