<?php

namespace App\Http\Requests\Admin;

use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class FaqRequest extends FormRequest
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
            "question" => "required|string",
            "answer"   => "required|string",
            // "page"     => "required|string",
            // "lang"     => "required|string|max:5",
            "status"   => "required|string|max:5",
        ];
    }

    public function messages()
    {
        return [
            "question.required" => _t("Question is required"),
            "question.string"   => _t("Question is invalid"),
            
            "answer.required" => _t("Answer is required"),
            "answer.string"   => _t("Answer is invalid"),
            
            "page.required" => _t("Page is required"),
            "page.string"   => _t("Page is invalid"),
            
            "lang.required" => _t("Language is required"),
            "lang.string"   => _t("Language is invalid"),
            "lang.max"      => _t("Language must be 5 character's"),
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? _t("Something went wrong with validation");
        /** @var Redirector $redirect */
        $redirect = redirect();
        $redirect->back()->with("error", $error)->throwResponse();
    }
}
