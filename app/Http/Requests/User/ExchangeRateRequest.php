<?php

namespace App\Http\Requests\User;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ExchangeRateRequest extends FormRequest
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
           "from_coin" => "required",
           "to_coin"   => "required",
           "amount"    => "required|numeric|gt:0"
        ];
    }

    public function messages(): array
    {
        return [
            "from_coin.required" => _t("Select exchange from coin"),
            "to_coin.required"   => _t("Select exchange to coin"),
            
            "amount.required" => _t("Exchange amount can not be empty"),
            "amount.numeric"  => _t("Exchange amount should be valid number"),
            "amount.gt"       => _t("Exchange amount should be more then zero"),
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? __("Something went wrong with validation");
        Response::throw(failed($error));
    }
}
