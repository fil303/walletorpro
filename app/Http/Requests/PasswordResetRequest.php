<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use App\Services\ResponseService\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PasswordResetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => "required|email:dns",
            "password_reset_token" => "required|string",
            "password" => "required|confirmed",
        ];
    }

    public function messages(): array
    {
        return [
            "email.required" => _t("Requested user email not found"),
            "email.email" => _t("Requested user email is invalid"),

            "password_reset_token.required" => _t("Password reset token not found"),

            "password.required" => _t("Enter your new password"),
            "password.confirmed" => _t("Confirm password not matched"),
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? __("Something went wrong with validation");
        Response::throw(failed($error));
    }
}
