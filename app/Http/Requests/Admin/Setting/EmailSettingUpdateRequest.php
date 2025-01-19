<?php

namespace App\Http\Requests\Admin\Setting;

use App\Services\ResponseService\Response;
use App\Enums\Smtp_encryption;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EmailSettingUpdateRequest extends FormRequest
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
            "email_host"      => "required",
            "email_port"      => "required|numeric",
            "email_username"  => "required",
            "email_password"  => "required",
            "email_encryption"=> "required|in:".implode(",",array_keys(Smtp_encryption::getAll())),
            "email_from"      => "required|email",
        ];
    }

    public function messages(): array
    {
        return [
            "email_host.required" => _t("SMTP host is required"),
            
            "email_port.required" => _t("SMTP port is required"),
            "email_port.numeric"  => _t("SMTP port is invalid"),

            "email_username.required" => _t("SMTP username is required"),
            "email_password.required" => _t("SMTP password is required"),

            "email_encryption.required"=> _t("SMTP encryption is required"),
            "email_encryption.in"      => _t("SMTP encryption is invalid"),

            "email_from.required" => _t("SMTP from email is required"),
            "email_from.email"    => _t("SMTP from email is invalid"),
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? __("Something went wrong with validation");
        Response::throw(failed($error));
    }
}
