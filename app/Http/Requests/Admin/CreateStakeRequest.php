<?php

namespace App\Http\Requests\Admin;

use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreateStakeRequest extends FormRequest
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
            "coin"     => "required",
            "status"   => "required|in:0,1",
            "min"      => "required|gt:0",
            "max"      => "required|gt:min",
            "duration.*" => "required|gt:0",
            "interest.*" => "required|gt:0",
        ];
    }

    public function messages(): array
    {
        return [
            "coin.required"     => _t("Select a coin"), 

            "min.required"      => _t("Set minimum amount for this plan"), 
            "min.gt"            => _t("Minimum amount must be gether then zero"), 

            "max.required"      => _t("Set maximum amount for this plan"), 
            "max.gt"            => _t("Maximum amount must be gether then maximum amount"), 

            "duration.*.required" => _t("Set duration for this plan"), 
            "duration.*.gt"       => _t("Duration must be gether then zero"), 

            "interest.*.required" => _t("Set interest for this plan"), 
            "interest.*.gt"       => _t("interest must be gether then zero"),
            
            "status.required"   => _t("Status is missing"), 
            "status.in"         => _t("Status is invalid"),
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? _t("Something went wrong with validation");

        /** @var Redirector $redirect */
        $redirect = redirect();
        
        $redirect->back()
            ->withErrors($validator->errors())
            ->with("error", $error)->throwResponse();
    }
}
