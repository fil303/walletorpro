<?php

namespace App\Http\Requests\Admin;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TestimonialRequest extends FormRequest
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
           "name"     => "required|string",
           "feedback" => "required|string",
           "status"   => "required|in:0,1",
           "image"    => "nullable|image|mimes:png,jpg,jpeg,webp",
        ];
    }

    /**
     * Validation Failed Message
     * @return array
     */
    public function messages(): array
    {
        return [
            "name.required" => _t("Name is required"),
            "name.string"   => _t("Name must be string"),

            "feedback.required" => _t("Feedback is required"),
            "feedback.string"   => _t("Feedback must be string"),

            "image.image" => _t("Image must be an image"),
            "image.mimes" => _t("Image must be png, jpg, jpeg or webp"),

            "status.required" => _t("Status is required"),
            "status.in"       => _t("Invalid status"),
        ];
    }

    /**
     * Throw Response With Validation Failed Message
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? _t("Something went wrong with validation");
        Response::throw(failed($error));
    }
}
