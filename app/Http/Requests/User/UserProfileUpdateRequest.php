<?php

namespace App\Http\Requests\User;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role->isUser();
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
            "country" => 'required|min:2|max:2',
            "phone" => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            "first_name.required" => _t("Enter your first name."),
            "last_name.required"  => _t("Enter your last name."),

            "username.required" => _t("Enter your username."),
            "username.unique"   => _t("This username not available."), 

            "country.required" => _t("Select your country."),
            "country.min"      => _t("Selected country is invalid."),
            "country.max"      => _t("Selected country is invalid."),

            "phone.required" => _t("Enter your phone number."),
            "phone.numeric " => _t("Enter your valid phone number."),
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? __("Something went wrong with validation");
        Response::throw(failed($error));
    }
}
