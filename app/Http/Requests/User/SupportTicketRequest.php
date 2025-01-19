<?php

namespace App\Http\Requests\User;

use App\Enums\SupportTicketPriority;
use Illuminate\Support\Facades\Auth;
use App\Services\ResponseService\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class SupportTicketRequest extends FormRequest
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
            'subject'  => 'required|string',
            'priority' => 'required|in:' . implode(',', array_keys(SupportTicketPriority::getAll())),
            'message'  => 'required|string',
            'attachment.*' => 'nullable|mimes:png,pdf,docx,jpg,jpeg'
        ];
    }

    public function messages()
    {
        return [
            "subject.required" => _t("Subject field is required"),
            "subject.string"   => _t("Subject is invalid"),
            
            "priority.required" => _t("priority is required"),
            "priority.in"       => _t("priority is invalid"),

            "message.required" => _t("Message field is required"),
            "message.string"   => _t("Message is invalid"),

            "attachment.*.mimes" => _t("Only PDF, DOCX, JPG, JPEG, and PNG files are allowed for attachments."),
        ];
    }


    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? _t("Something went wrong with validation");
        Response::throw(failed($error));
    }
}
