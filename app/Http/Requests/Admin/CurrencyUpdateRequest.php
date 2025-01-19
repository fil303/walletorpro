<?php

namespace App\Http\Requests\Admin;

use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CurrencyUpdateRequest extends FormRequest
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
            "name" => "required|string",
            "symbol" => "required|string",
            "code" => "required|string|max:5",
            "status" => "required|in:0,1",
            "rate" => "required|numeric|gt:0",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => _t("Name is required"),
            "name.string"   => _t("Name is invalid"),
            
            "symbol.required" => _t("Symbol is required"),
            "symbol.string"   => _t("Symbol is invalid"),
            
            "status.required" => _t("Status is required"),
            "status.in"       => _t("Status is invalid"),
           
            "rate.required" => _t("Currency rate is required"),
            "rate.numeric"  => _t("Currency rate is invalid"),
            "rate.gt"       => _t("Currency rate must be gather then zero"),

            "code.required" => _t("Code is required"),
            "code.string"   => _t("Code is invalid"),
            "code.max"      => _t("Code can not be more than 5 characters"),
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? _t("Something went wrong with validation");
        /** @var Redirector $redirect */
        $redirect = redirect();
        $redirect->back()->with("error", $error)->throwResponse();
    }
}
