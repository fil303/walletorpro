<?php

namespace App\Http\Requests\Admin\Setting\Landing;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LandingTestimonialSectionSettingRequest extends FormRequest
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
            "testimonial_section_badge_text" => "required|string",
            "testimonial_section_title" => "required|string",
            "testimonial_section_description" => "required|string",
        ];
    }

    /**
     * Validation Failed Message
     * @return array
     */
    public function messages(): array
    {
        return [
            "testimonial_section_badge_text.required" => __("Testimonial section badge text is required"),
            "testimonial_section_badge_text.string" => __("Testimonial section badge text must be string"),

            "testimonial_section_title.required" => __("Testimonial section title is required"),
            "testimonial_section_title.string" => __("Testimonial section title must be string"),

            "testimonial_section_description.required" => __("Testimonial section description is required"),
            "testimonial_section_description.string" => __("Testimonial section description must be string"),
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
