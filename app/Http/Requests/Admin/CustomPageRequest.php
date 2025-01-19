<?php

namespace App\Http\Requests\Admin;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CustomPageRequest extends FormRequest
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
           "name"   => "required|string",
           "title"   => "required|string",
           "content_body" => "required|string",
           "status"  => "required|in:0,1",
        ];
    }

    /**
     * Validation Failed Message
     * @return array
     */
    public function messages(): array
    {
        return [
            "name.required" => __("Name is required"),
            "name.string"   => __("Name must be string"),
            
            "title.required" => __("Title is required"),
            "title.string"   => __("Title must be string"),

            "content_body.required" => __("Content is required"),
            "content_body.string"   => __("Content must be string"),

            "status.required" => __("Status is required"),
            "status.in"       => __("Status is invalid"),
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
