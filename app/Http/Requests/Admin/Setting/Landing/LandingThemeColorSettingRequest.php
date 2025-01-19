<?php

namespace App\Http\Requests\Admin\Setting\Landing;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LandingThemeColorSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           "primary_color"   => "required|string",
           "secondary_color" => "required|string",
           "success_color"   => "required|string",
           "info_color"      => "required|string",
        ];
    }

    /**
     * Validation Failed Message
     * @return array
     */
    public function messages(): array
    {
        return [
            "primary_color.required" => _t("Primary Color is required"),
            "primary_color.string"   => _t("Primary Color is invalid"),
            
            "secondary_color.required" => _t("Secondary Color is required"),
            "secondary_color.string"   => _t("Secondary Color is invalid"),
            
            "success_color.required" => _t("Success Color is required"),
            "success_color.string"   => _t("Success Color is invalid"),
            
            "info_color.required" => _t("Info Color is required"),
            "info_color.string"   => _t("Info Color is invalid"),
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
