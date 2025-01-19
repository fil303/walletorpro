<?php

namespace App\Http\Requests\Admin\Setting\Landing;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LandingFaqSectionSettingRequest extends FormRequest
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
            "faq_section_badge_text" => "required|string",
            "faq_section_title"      => "required|string",
            "faq_section_description"=> "required|string",
            "faq_section_image" => "nullable|image|mimes:png,jpg,jpeg,webp|max:2048",
        ];
    }

    /**
     * Validation Failed Message
     * @return array
     */
    public function messages(): array
    {
        return [
            "faq_section_badge_text.required" => __("Faq section badge text is required"),
            "faq_section_badge_text.string"  => __("Faq section badge text must be a string"),

            "faq_section_title.required"      => __("Faq section title is required"),
            "faq_section_title.string"       => __("Faq section title must be a string"),

            "faq_section_description.required" => __("Faq section description is required"),
            "faq_section_description.string"  => __("Faq section description must be a string"),

            "faq_section_image.image" => __("Faq section image must be an image"),
            "faq_section_image.mimes" => __("Faq section image must be a png, jpg, jpeg, webp"),
            "faq_section_image.max"   => __("Faq section image must be less than 2MB"),
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
