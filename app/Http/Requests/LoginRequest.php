<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Services\ResponseService\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guest();
    }

    protected function failedAuthorization()
    {
        Redirect::route('loginPage')
                ->with('error', _t("Already auth user"))
                ->throwResponse();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            "email"=> "required",
            "password"=> "required",
        ];

        if(get_settings('app_recaptcha_status') ?? '0'){
            $rules['g-recaptcha-response'] = "required|captcha";
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            "email.required" => _t("Enter your email address"),
            "password.required" => _t("Enter your password"),

            "g-recaptcha-response.required" => _t("Google reCaptcha not verified"),
            "g-recaptcha-response.captcha"  => _t("Google reCaptcha verification failed"),
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? _t("Something went wrong with validation");
        Response::throw(failed($error));
    }
}
