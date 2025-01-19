<?php

namespace App\Http\Requests\Admin\Setting;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TwilioSmsSettingUpdateRequest extends FormRequest
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
            "sms_twilio_sid"   => "required",
            "sms_twilio_token" => "required",
            "sms_twilio_phone" => "required",
        ];
    }

    public function messages(): array
    {
        return [
            "sms_twilio_sid.required"   => _t("Twilio account SID is required"),
            "sms_twilio_token.required" => _t("Twilio account auth token is required"),
            "sms_twilio_phone.required" => _t("Twilio sender phone number is required"),
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? __("Something went wrong with validation");
        Response::throw(failed($error));
    }
}
