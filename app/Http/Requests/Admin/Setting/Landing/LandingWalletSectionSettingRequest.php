<?php

namespace App\Http\Requests\Admin\Setting\Landing;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LandingWalletSectionSettingRequest extends FormRequest
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
            "wallet_section_badge_text" => "required|string",
            "wallet_section_title" => "required|string",

            "wallet_section_feature1_title" => "required|string",
            "wallet_section_feature1_description" => "required|string",

            "wallet_section_feature2_title" => "required|string",
            "wallet_section_feature2_description" => "required|string",

            "wallet_section_feature3_title" => "required|string",
            "wallet_section_feature3_description" => "required|string",

            "wallet_section_feature4_title" => "required|string",
            "wallet_section_feature4_description" => "required|string",

            "wallet_section_feature5_title" => "required|string",
            "wallet_section_feature5_description" => "required|string",

            "wallet_section_feature6_title" => "required|string",
            "wallet_section_feature6_description" => "required|string",
        ];
    }

    /**
     * Validation Failed Message
     * @return array
     */
    public function messages(): array
    {
        return [
            "wallet_section_badge_text.required" => _t("Wallet Section Badge Text is required"),
            "wallet_section_badge_text.string"   => _t("Wallet Section Badge Text is invalid"),

            "wallet_section_title.required" => _t("Wallet Section Title is required"),
            "wallet_section_title.string"   => _t("Wallet Section Title is invalid"),

            "wallet_section_feature1_title.required" => _t("Wallet Section Feature 1 Title is required"),
            "wallet_section_feature1_title.string"   => _t("Wallet Section Feature 1 Title is invalid"),

            "wallet_section_feature1_description.required" => _t("Wallet Section Feature 1 Description is required"),
            "wallet_section_feature1_description.string"   => _t("Wallet Section Feature 1 Description is invalid"),

            "wallet_section_feature2_title.required" => _t("Wallet Section Feature 2 Title is required"),
            "wallet_section_feature2_title.string"   => _t("Wallet Section Feature 2 Title is invalid"),

            "wallet_section_feature2_description.required" => _t("Wallet Section Feature 2 Description is required"),
            "wallet_section_feature2_description.string"   => _t("Wallet Section Feature 2 Description is invalid"),

            "wallet_section_feature3_title.required" => _t("Wallet Section Feature 3 Title is required"),
            "wallet_section_feature3_title.string"   => _t("Wallet Section Feature 3 Title is invalid"),

            "wallet_section_feature3_description.required" => _t("Wallet Section Feature 3 Description is required"),
            "wallet_section_feature3_description.string"   => _t("Wallet Section Feature 3 Description is invalid"),

            "wallet_section_feature4_title.required" => _t("Wallet Section Feature 4 Title is required"),
            "wallet_section_feature4_title.string"   => _t("Wallet Section Feature 4 Title is invalid"),

            "wallet_section_feature4_description.required" => _t("Wallet Section Feature 4 Description is required"),
            "wallet_section_feature4_description.string"   => _t("Wallet Section Feature 4 Description is invalid"),

            "wallet_section_feature5_title.required" => _t("Wallet Section Feature 5 Title is required"),
            "wallet_section_feature5_title.string"   => _t("Wallet Section Feature 5 Title is invalid"),

            "wallet_section_feature5_description.required" => _t("Wallet Section Feature 5 Description is required"),
            "wallet_section_feature5_description.string"   => _t("Wallet Section Feature 5 Description is invalid"),

            "wallet_section_feature6_title.required" => _t("Wallet Section Feature 6 Title is required"),
            "wallet_section_feature6_title.string"   => _t("Wallet Section Feature 6 Title is invalid"),
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
