<?php

namespace App\Http\Requests\Admin;

use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class AddCurrencyRequest extends FormRequest
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
            "name"      => "required|string|max:50",
            "code"      => "exclude_unless:type,f|required_if:type,c|max:15",
            "coin"      => "exclude_unless:type,f|required_if:type,c|max:15",
            "rate"      => "required|numeric|gt:0",
            // "symbol"    => "required|string|max:5",
            "icon"      => "image|mimes:png,jpg,jpeg,webp",
            "decimal"   => "required|gt:0",
        ];
    }

    public function messages()
    {
        return [
            "type.required" => _t("Currency type is required"),
            "type.in"       => _t("Currency type is invalid"),

            "name.required" => _t("Currency name is required"),
            "name.string"   => _t("Currency name should be 'string' type"),
            "name.max"      => _t("Currency name should be 50 characters"),
            
            "provider.required_if" => _t("Currency provider is required"),
            "provider.string"      => _t("Currency provider should be 'string' type"),
            "provider.max"         => _t("Currency provider should be 20 characters"),
            
            "currency.required_if" => _t("Currency code is required"),
            
            "code.required_if" => _t("Currency code is required"),
            "code.string"      => _t("Currency code should be 'string' type"),
            "code.max"         => _t("Currency code should be 15 characters"),
            
            "coin.required_if" => _t("Currency coin is required"),
            "coin.string"      => _t("Currency coin should be 'string' type"),
            "coin.max"         => _t("Currency coin should be 15 characters"),
            
            "symbol.required" => _t("Currency symbol is required"),
            "symbol.string"   => _t("Currency symbol should be 'string' type"),
            "symbol.max"      => _t("Currency symbol should be 5 characters"),
            
            "icon.image" => _t("Currency icon invalid. expected image file"),
            "icon.mimes" => _t("Currency icon invalid, expected mime types 'png,jpg,jpeg,webp'"),

            "rate.required" => _t("Currency rate is required"),
            "rate.numeric"  => _t("Currency rate should be a number"),
            "rate.gt"       => _t("Currency rate should be greater than zero"),
            
            "decimal.required" => _t("Currency decimal is required"),
            "decimal.gt"       => _t("Currency decimal should be greater than zero"),
            
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
