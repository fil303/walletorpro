<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Facades\Auth;
use App\Services\ResponseService\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class SubmitStakeRequest extends FormRequest
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
            'plan'    => 'required',
            'amount'  => 'required|numeric|gt:0',
            'segment' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            "plan.required"    => _t("Invalid stake plan selected"),
            "segment.required" => _t("Stake plan duration not selected"),

            "amount.required" => _t("Enter amount"),
            "amount.numeric"  => _t("Invalid amount entered"),
            "amount.gt"       => _t("Amount should be gather then 0"),
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? _t("Something went wrong with validation");
        Response::throw(failed($error));
    }
}
