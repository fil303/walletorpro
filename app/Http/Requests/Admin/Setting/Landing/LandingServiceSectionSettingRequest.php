<?php

namespace App\Http\Requests\Admin\Setting\Landing;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LandingServiceSectionSettingRequest extends FormRequest
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
            "service_section_badge_text"  => "required|string",
            "service_section_title"       => "required|string",
            "service_section_description" => "required|string",

            // Feature 1
            "service_section_feature1_title"       => "required|string",
            "service_section_feature1_description" => "required|string",

            // Feature 2
            "service_section_feature2_title"       => "required|string",
            "service_section_feature2_description" => "required|string",

            // Feature 3
            "service_section_feature3_title"       => "required|string",
            "service_section_feature3_description" => "required|string",

            "service_section_image" => "nullable|image|mimes:png,jpg,jpeg,webp|max:2048",
        ];
    }

    /**
     * Validation Failed Message
     * @return array
     */
    public function messages(): array
    {
        return [
            "service_section_badge_text.required"  => _t("Badge text is required"),
            "service_section_badge_text.string"    => _t("Badge text must be string"),

            "service_section_title.required"       => _t("Title is required"),
            "service_section_title.string"         => _t("Title must be string"),

            "service_section_description.required" => _t("Description is required"),
            "service_section_description.string"   => _t("Description must be string"),

            // Feature 1
            "service_section_feature1_title.required"       => _t("Feature 1 title is required"),
            "service_section_feature1_title.string"         => _t("Feature 1 title must be string"),
            "service_section_feature1_description.required" => _t("Feature 1 description is required"),
            "service_section_feature1_description.string"   => _t("Feature 1 description must be string"),
            // Feature 2
            "service_section_feature2_title.required"       => _t("Feature 2 title is required"),
            "service_section_feature2_title.string"         => _t("Feature 2 title must be string"),
            "service_section_feature2_description.required" => _t("Feature 2 description is required"),
            "service_section_feature2_description.string"   => _t("Feature 2 description must be string"),
            // Feature 3
            "service_section_feature3_title.required"       => _t("Feature 3 title is required"),
            "service_section_feature3_title.string"         => _t("Feature 3 title must be string"),
            "service_section_feature3_description.required" => _t("Feature 3 description is required"),
            "service_section_feature3_description.string"   => _t("Feature 3 description must be string"),

            "service_section_image.image" => _t("Service Section Image is invalid"),
            "service_section_image.mimes" => _t("Service Section Image is invalid"),
            "service_section_image.max"   => _t("Service Section Image size is too large"),
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
