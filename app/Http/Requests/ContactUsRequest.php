<?php

namespace App\Http\Requests;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ContactUsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = $this->isMethod('get') ? [] : [
           'name'    => 'required|string',
           'email'   => 'required|email',
           'subject' => 'required|string',
           'message' => 'required|string',
        ];

        if(
            $this->isMethod('post') && 
            (get_settings('app_recaptcha_status') ?? '0')
        ){
            $rules['g-recaptcha-response'] = "required|captcha";
        }

        return $rules;
    }

    /**
     * Validation Failed Message
     * @return array
     */
    public function messages(): array
    {
        return [
            "name.required"    => _t("Name is required"),
            "name.string"      => _t("Name must be a string"),

            "email.required"   => _t("Email is required"),
            "email.email"      => _t("Email must be a valid email address"),

            "subject.required" => _t("Subject is required"),
            "subject.string"   => _t("Subject must be a string"),

            "message.required" => _t("Message is required"),
            "message.string"   => _t("Message must be a string"),

            "g-recaptcha-response.required" => _t("Google reCaptcha not verified"),
            "g-recaptcha-response.captcha"  => _t("Google reCaptcha verification failed"),
        ];
    }

    /**
     * Throw Response With Validation Failed Message
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? __("Something went wrong with validation");
        Response::throw(failed($error));
    }
}
