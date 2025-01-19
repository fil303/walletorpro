<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Facades\Auth;
use App\Services\ResponseService\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BuyCryptoRequest extends FormRequest
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
            "crypto" => "required",
            "currency" => "required",
            "amount" => "required|numeric|gt:0",
            "gateway" => "required"
        ];
    }

    public function messages(): array
    {
        return [
            "crypto.required" => _t("Select a crypto for buy"),
            "currency.required" => _t("Select a currency to pay for crypto"),

            "amount.required" => _t("Enter the amount to buy crypto"),
            "amount.numeric" => _t("Invalid amount entered"),
            "amount.gt" => _t("Amount should be gather then 0"),

            "gateway.required" => _t("Select a gateway to payment")
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? _t("Something went wrong with validation");
        Response::throw(
            failed($error),
            'coinBuyPage'
        );
    }
}
