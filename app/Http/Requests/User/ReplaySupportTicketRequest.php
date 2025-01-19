<?php

namespace App\Http\Requests\User;

use App\Services\ResponseService\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReplaySupportTicketRequest extends FormRequest
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
           "ticket"       => "required",
           "message"      => "required_without:attachment",
           "attachment.*" => "nullable|mimes:png,pdf,docx,jpg,jpeg"
        ];
    }

    public function messages(): array
    {
        return [
            "ticket.required"    => _t("Support ticket invalid"),
            "message.required_without" => _t("Support message required"),
            "attachment.*.mimes" => _t("Only PDF, DOCX, JPG, JPEG, and PNG files are allowed for attachments."),
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? _t("Something went wrong with validation");
        Response::throw(failed($error));
    }
}
