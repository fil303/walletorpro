<?php

namespace App\Http\Requests;

use App\Enums\TwoFactor;
use Illuminate\Support\Facades\Auth;
use App\Services\ResponseService\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class TwoFactorVerifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "type" => "required|in:".implode(",",array_keys(TwoFactor::getAll())),
            "code" => "required|numeric",
        ];
    }

    public function messages(): array
    {
        return [
            "code.required" => _t("PIN code is required"),
            "code.numeric"  => _t("PIN code is invalid"),

            "type.required" => _t("Authentication type is required"),
            "type.in"       => _t("Authentication type is invalid"),
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? __("Something went wrong with validation");
        Response::throw(failed($error));
    }
}
