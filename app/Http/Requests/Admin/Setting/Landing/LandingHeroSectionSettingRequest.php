<?php

namespace App\Http\Requests\Admin\Setting\Landing;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LandingHeroSectionSettingRequest extends FormRequest
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
           "hero_section_badge_text" => "required|string",
           "hero_section_heading"    => "required|string",
           "hero_section_subheading" => "required|string",
           "hero_section_cta_text"   => "required|string",
           "hero_section_image"      => "nullable|image|mimes:png,jpg,jpeg,webp|max:2048",
        ];
    }

    /**
     * Validation Failed Message
     * @return array
     */
    public function messages(): array
    {
        return [
            "hero_section_badge_text.required" => _t("Hero Section Badge Text is required"),
            "hero_section_badge_text.string"   => _t("Hero Section Badge Text is invalid"),
            
            "hero_section_heading.required" => _t("Hero Section Heading is required"),
            "hero_section_heading.string"   => _t("Hero Section Heading is invalid"),
            
            "hero_section_subheading.required" => _t("Hero Section Subheading is required"),
            "hero_section_subheading.string"   => _t("Hero Section Subheading is invalid"),
            
            "hero_section_cta_text.required" => _t("Hero Section Button Text is required"),
            "hero_section_cta_text.string"   => _t("Hero Section Button Text is invalid"),

            "hero_section_image.image" => _t("Hero Section Image is invalid"),
            "hero_section_image.mimes" => _t("Hero Section Image is invalid"),
            "hero_section_image.max"   => _t("Hero Section Image size is too large"),
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
