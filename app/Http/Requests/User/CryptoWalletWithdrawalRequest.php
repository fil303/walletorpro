<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Facades\Auth;
use App\Services\ResponseService\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CryptoWalletWithdrawalRequest extends FormRequest
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
            "wallet"  => "required|string",
            "coin_code"=> "required|string",
            "amount"  => "required|numeric|gt:0",
            "address" => "required|string",
            "memo"    => "nullable|string|numeric|gt:0",
        ];
    }

    public function messages(): array
    {
        return [
            "amount.required"  => _t("Amount is required, cannot be empty"),
            "amount.numeric"   => _t("Amount must be numeric"),
            "amount.gt"        => _t("Amount is invalid"),

            "address.required" => _t("Address is required, cannot be empty"),
            "address.string"   => _t("Address is invalid"),
            "address.min"      => _t("Address must be at least 32 characters"),

            "memo.string"      => _t("Memo is invalid"),
            "memo.numeric"     => _t("Memo is invalid"),
            "memo.gt"          => _t("Memo is invalid"),

            "wallet.string"    => _t("Wallet should be string"),
            "wallet.required"  => _t("Wallet is required"),
           
            "coin_code.string"    => _t("Coin should be string"),
            "coin_code.required"  => _t("Coin is required"),
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? _t("Something went wrong with validation");
        Response::throw(failed($error));
    }
}
