<?php

namespace App\Http\Requests\Admin\Setting;

use App\Enums\ThemeType;
use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ThemeSettingUpdateRequest extends FormRequest
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
           "type" => "required|in:".implode(",",array_keys(ThemeType::getAll())),
           "theme"=> "required_if:type,pre-build",

           "primary"   => "required_if:type,custom",
           "secondary" => "required_if:type,custom",
           "accent"    => "required_if:type,custom",
           "neutral"   => "required_if:type,custom",
        ];
    }

    /**
     * Validation Failed Message
     * @return array
     */
    public function messages(): array
    {
        return [
            "type.required" => _t("Theme type is required"),
            "type.in"       => _t("Theme type is invalid"),

            "theme.required_if"     => _t("Theme is required"),

            "primary.required_if"   => _t("Primary color code is required"),
            "secondary.required_if" => _t("Secondary color code is required"),
            "accent.required_if"    => _t("Accent color code is required"),
            "neutral.required_if"   => _t("Neutral color code is required"),
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
