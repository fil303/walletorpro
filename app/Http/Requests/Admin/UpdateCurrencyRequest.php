<?php

namespace App\Http\Requests\Admin;

use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateCurrencyRequest extends FormRequest
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
            // "type"      => "required|in:c,f",
            "uid"       => "required|string",
            "name"      => "required|string|max:50",
            "provider"  => "required_if:type,c|string|max:20",
            "code"      => "exclude_unless:type,f|required_if:type,c|max:15",
            "coin"      => "exclude_unless:type,f|required_if:type,c|max:15",
            "currency"  => "required_if:type,f|",
            "rate"      => "numeric|gt:0",
            "fee"       => "numeric|gt:0",
            "withdrawal_min" => "numeric|gt:0",
            "withdrawal_max" => "numeric|gt:0",
        ];
    }

    public function messages()
    {
        return [
            "uid.required" => _t("Crypto id is required"),
            "uid.string"   => _t("Crypto id should be 'string' type"),

            "name.required" => _t("Crypto name is required"),
            "name.string"   => _t("Crypto name should be 'string' type"),
            "name.max"      => _t("Crypto name should be 50 characters"),
                                    
            "code.required_if" => _t("Currency code is required"),
            "code.string"      => _t("Currency code should be 'string' type"),
            "code.max"         => _t("Currency code should be 15 characters"),

            "coin.required_if" => _t("Currency coin is required"),
            "coin.string"      => _t("Currency coin should be 'string' type"),
            "coin.max"         => _t("Currency coin should be 15 characters"),

            "provider.required_if" => _t("Currency provider is required"),
            "provider.string"      => _t("Currency provider should be 'string' type"),
            "provider.max"         => _t("Currency provider should be 20 characters"),
            
            "symbol.required" => _t("Crypto symbol is required"),
            "symbol.string"   => _t("Crypto symbol should be 'string' type"),
            "symbol.max"      => _t("Crypto symbol should be 5 characters"),
            
            "icon.image"   => _t("Crypto icon invalid. expected image file"),
            "icon.mimes"   => _t("Crypto icon invalid, expected mime types 'png,jpg,jpeg,webp'"),
            // "icon.max"      => _t("Crypto icon should be 5 characters"),

            "status.required" => _t("Crypto status is required"),
            "currency.required_if" => _t("Currency code is required"),

            "rate.numeric"  => _t("Crypto rate should be a number"),
            "rate.gt"       => _t("Crypto rate should be greater than zero"),
            
            "fee.numeric"  => _t("Crypto fee should be a number"),
            "fee.gt"       => _t("Crypto fee should be greater than zero"),
            
            "withdrawal_min.numeric"  => _t("Crypto withdrawal minimum limit should be a number"),
            "withdrawal_min.gt"       => _t("Crypto withdrawal minimum limit should be greater than zero"),
            
            "withdrawal_max.numeric"  => _t("Crypto withdrawal maximum should be a number"),
            "withdrawal_max.gt"       => _t("Crypto withdrawal maximum should be greater than zero"),

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
