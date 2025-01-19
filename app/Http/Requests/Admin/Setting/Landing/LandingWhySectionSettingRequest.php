<?php

namespace App\Http\Requests\Admin\Setting\Landing;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LandingWhySectionSettingRequest extends FormRequest
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
           "why_section_badge"       => "required|string",
           "why_section_title"       => "required|string",
           "why_section_description" => "required|string",
        ];
    }

    /**
     * Validation Failed Message
     * @return array
     */
    public function messages(): array
    {
        return [
            "why_section_badge.required" => _t("Why Section Badge is required"),
            "why_section_badge.string"   => _t("Why Section Badge is invalid"),

            "why_section_title.required" => _t("Why Section Title is required"),
            "why_section_title.string"   => _t("Why Section Title is invalid"),

            "why_section_description.required" => _t("Why Section Description is required"),
            "why_section_description.string"   => _t("Why Section Description is invalid"),
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
