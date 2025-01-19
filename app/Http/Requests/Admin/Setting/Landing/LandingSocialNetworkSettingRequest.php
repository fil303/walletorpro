<?php

namespace App\Http\Requests\Admin\Setting\Landing;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LandingSocialNetworkSettingRequest extends FormRequest
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
           "social_facebook_url" => "required|string",
           "social_twitter_url"  => "required|string",
           "social_linkedin_url" => "required|string",
        ];
    }

    /**
     * Validation Failed Message
     * @return array
     */
    public function messages(): array
    {
        return [
            "social_facebook_url.required" => __("Facebook url is required"),
            "social_facebook_url.string" => __("Facebook url is invalid"),

            "social_twitter_url.required"  => __("Twitter url is required"),
            "social_twitter_url.string"  => __("Twitter url is invalid"),

            "social_linkedin_url.required" => __("Linkedin url is required"),
            "social_linkedin_url.string" => __("Linkedin url is invalid"),
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
