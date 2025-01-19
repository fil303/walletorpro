<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "first_name" => 'required',
            "last_name" => 'required',
            "username" => 'required',
            "email" => 'required|email:dns',
            "country" => 'required',
            // "phone" => 'required',
            "password" => 'required|string|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            "first_name.required" => _t("Enter your first name."),
            "last_name.required"  => _t("Enter your last name."),

            "username.required" => _t("Enter your username."),
            "username.unique"    => _t("This username not available."), 

            "email.required"    => _t("Enter your email address."),
            "email.email"       => _t("This email is invalid."),

            "country.required"  => _t("Select your country."),

            "phone.required"    => _t("Enter your phone number."),

            "password.required" => _t("Enter your password."),
            "password.confirmed"=> _t("Password confirmation not match."),
        ];
    }
}
