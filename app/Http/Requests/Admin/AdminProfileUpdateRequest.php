<?php

namespace App\Http\Requests\Admin;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminProfileUpdateRequest extends FormRequest
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
           "first_name" => "required",
           "last_name"  => "required",
           "email"      => "required|email",
           "image"      => "image|mimes:jpg,png,jpeg"
        ];
    }

    public function messages(): array
    {
        return [
            "first_name.required" => _t("First name is required"),
            "last_name.required"  => _t("Last name is required"),

            "email.required" => _t("Email is required"),
            "email.email"    => _t("Email is invalid"),

            "image.image" => _t("Profile image is invalid"),
            "image.mimes" => _t("Supported profile image type is jpg,png,jpeg"),
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? __("Something went wrong with validation");
        Response::throw(failed($error));
    }
}
