<?php

namespace App\Http\Requests\Admin\Setting\Landing;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LandingHowSectionSettingRequest extends FormRequest
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
            "how_section_badge_text"        => "required|string",

            // Coin Purchase
            "how_section_step1_title"       => "required|string",
            "how_section_step1_description" => "required|string",

            "how_section_step2_title" => "required|string",
            "how_section_step2_description" => "required|string",

            "how_section_step3_title" => "required|string",
            "how_section_step3_description" => "required|string",

            //staking
            "how_section_staking_step1_title" => "required|string",
            "how_section_staking_step1_description" => "required|string",

            "how_section_staking_step2_title" => "required|string",
            "how_section_staking_step2_description" => "required|string",

            "how_section_staking_step3_title" => "required|string",
            "how_section_staking_step3_description" => "required|string",

            //exchange
            "how_section_exchange_step1_title" => "required|string",
            "how_section_exchange_step1_description" => "required|string",

            "how_section_exchange_step2_title" => "required|string",
            "how_section_exchange_step2_description" => "required|string",

            "how_section_exchange_step3_title" => "required|string",
            "how_section_exchange_step3_description" => "required|string",
        ];
    }

    /**
     * Validation Failed Message
     * @return array
     */
    public function messages(): array
    {
        return [
            "how_section_badge_text.required" => _t("How Section Badge Text is required"),
            "how_section_badge_text.string"   => _t("How Section Badge Text is invalid"),

            // Coin Purchase
            "how_section_step1_title.required" => _t("How Section Step 1 Title is required"),
            "how_section_step1_title.string"   => _t("How Section Step 1 Title is invalid"),

            "how_section_step1_description.required" => _t("How Section Step 1 Description is required"),
            "how_section_step1_description.string"   => _t("How Section Step 1 Description is invalid"),

            "how_section_step2_title.required" => _t("How Section Step 2 Title is required"),
            "how_section_step2_title.string"   => _t("How Section Step 2 Title is invalid"),

            "how_section_step2_description.required" => _t("How Section Step 2 Description is required"),
            "how_section_step2_description.string"   => _t("How Section Step 2 Description is invalid"),

            "how_section_step3_title.required" => _t("How Section Step 3 Title is required"),
            "how_section_step3_title.string"   => _t("How Section Step 3 Title is invalid"),

            "how_section_step3_description.required" => _t("How Section Step 3 Description is required"),
            "how_section_step3_description.string"   => _t("How Section Step 3 Description is invalid"),

            //staking
            "how_section_staking_step1_title.required" => _t("How Section Staking Step 1 Title is required"),
            "how_section_staking_step1_title.string"   => _t("How Section Staking Step 1 Title is invalid"),

            "how_section_staking_step1_description.required" => _t("How Section Staking Step 1 Description is required"),
            "how_section_staking_step1_description.string"   => _t("How Section Staking Step 1 Description is invalid"),

            "how_section_staking_step2_title.required" => _t("How Section Staking Step 2 Title is required"),
            "how_section_staking_step2_title.string"   => _t("How Section Staking Step 2 Title is invalid"),

            "how_section_staking_step2_description.required" => _t("How Section Staking Step 2 Description is required"),
            "how_section_staking_step2_description.string"   => _t("How Section Staking Step 2 Description is invalid"),

            "how_section_staking_step3_title.required" => _t("How Section Staking Step 3 Title is required"),
            "how_section_staking_step3_title.string"   => _t("How Section Staking Step 3 Title is invalid"),

            "how_section_staking_step3_description.required" => _t("How Section Staking Step 3 Description is required"),
            "how_section_staking_step3_description.string"   => _t("How Section Staking Step 3 Description is invalid"),

            //exchange
            "how_section_exchange_step1_title.required" => _t("How Section Exchange Step 1 Title is required"),
            "how_section_exchange_step1_title.string"   => _t("How Section Exchange Step 1 Title is invalid"),

            "how_section_exchange_step1_description.required" => _t("How Section Exchange Step 1 Description is required"),
            "how_section_exchange_step1_description.string"   => _t("How Section Exchange Step 1 Description is invalid"),

            "how_section_exchange_step2_title.required" => _t("How Section Exchange Step 2 Title is required"),
            "how_section_exchange_step2_title.string"   => _t("How Section Exchange Step 2 Title is invalid"),

            "how_section_exchange_step2_description.required" => _t("How Section Exchange Step 2 Description is required"),
            "how_section_exchange_step2_description.string"   => _t("How Section Exchange Step 2 Description is invalid"),

            "how_section_exchange_step3_title.required" => _t("How Section Exchange Step 3 Title is required"),
            "how_section_exchange_step3_title.string"   => _t("How Section Exchange Step 3 Title is invalid"),

            "how_section_exchange_step3_description.required" => _t("How Section Exchange Step 3 Description is required"),
            "how_section_exchange_step3_description.string"   => _t("How Section Exchange Step 3 Description is invalid"),
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
