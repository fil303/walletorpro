<?php

namespace App\Http\Requests\Admin;

use App\Models\GatewayExtra;
use App\Models\PaymentGateway;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateGatewayRequest extends FormRequest
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
     * @return array<int|string, string>
     */
    public function rules(): array
    {
        if(! isset($this->uid))
            return [ "no_uid" => "required" ];

        if(! $gateway = PaymentGateway::where("uid", $this->uid)->first())
            return [ "no_method" => "required" ];
        
        $attr = GatewayExtra::where("payment_gateway_uid", $this->uid)->get();
        if(!(count($attr) > 0)) return [ "no_attribute" => "required" ];

        $rules = [];
        $attr->map(function($attribute) use(&$rules) {
            if(!$attribute->readonly){
                $rules[$attribute->slug] = "";

                if($attribute->required) 
                    $rules[$attribute->slug] .= "required|";
                
                if($attribute->type == "file") 
                    $rules[$attribute->slug] .= "image|";
            }
        });
        define("GATEWAY", $gateway);
        define("GATEWAY_EXTRA", $attr);

        return $rules;
    }

    public function messages()
    {
        return [
            "no.required" => _t("Payment method is invalid"),
            "no_uid.required" => _t("Payment method is required"),
            "no_method.required" => _t("Payment method not found"),
            "no_attribute.required" => _t("Payment method has not attribute"),
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        $error = $validator->errors()->all()[0] ?? _t("Something went wrong with validation");
        /** @var Redirector $redirect */
        $redirect = redirect();
        $redirect->back()->with("error", $error)->throwResponse();
    }
}
