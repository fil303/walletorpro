<?php

namespace App\Http\Requests\Admin\Setting;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BasicSettingUpdateRequest extends FormRequest
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
           "app_name" => "required",
           "record_per_page" => "required",
           "app_timezone" => "required",
           "app_language" => "required",
           "app_address" => "required",
           "app_email" => "required",
           "app_phone" => "required",
           "app_footer_text" => "required",
        ];
    }

    public function messages(): array
    {
        return [
            
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? __("Something went wrong with validation");
        Response::throw(failed($error));
    }
}
