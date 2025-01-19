<?php

namespace App\Http\Requests\Admin\Setting\Landing;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LandingAboutSectionSettingRequest extends FormRequest
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
           "about_section_badge_text"  => "required|string",
           "about_section_title"       => "required|string",
           "about_section_description" => "required|string",
           "about_section_image"       => "nullable|image|mimes:png,jpg,jpeg,webp|max:2048",
        ];
    }

    /**
     * Validation Failed Message
     * @return array
     */
    public function messages(): array
    {
        return [
            "about_section_badge_text.required" => _t("About Section Badge Text is required"),
            "about_section_badge_text.string"   => _t("About Section Badge Text is invalid"),

            "about_section_title.required" => _t("About Section Title is required"),
            "about_section_title.string"   => _t("About Section Title is invalid"),

            "about_section_description.required" => _t("About Section Description is required"),
            "about_section_description.string"   => _t("About Section Description is invalid"),

            "about_section_image.image" => _t("About Section Image is invalid"),
            "about_section_image.mimes" => _t("About Section Image is invalid"),
            "about_section_image.max"   => _t("About Section Image size is too large"),
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
