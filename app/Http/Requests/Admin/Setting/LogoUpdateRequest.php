<?php

namespace App\Http\Requests\Admin\Setting;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LogoUpdateRequest extends FormRequest
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
           "logo" => "mimes:png,jpg,jpeg,svg,webp",
           "fav"  => "mimes:ico,png,jpg,jpeg,gif"
        ];
    }

    /**
     * Validation Failed Message
     * @return array
     */
    public function messages(): array
    {
        return [
            "logo.mimes" => _t("Supported file types").": png,jpg,jpeg,svg,webp",
            "fav.mimes"  => _t("Supported file types").": ico,png,jpg,jpeg,gif",
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
