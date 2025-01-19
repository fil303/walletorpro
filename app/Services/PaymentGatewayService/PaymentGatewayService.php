<?php
namespace App\Services\PaymentGatewayService;

use Exception;
use App\Models\Currency;
use App\Models\GatewayExtra;
use App\Models\PaymentGateway;
use App\Models\GatewayCurrency;
use Illuminate\Support\Facades\Log;
use App\Services\ResponseService\Response;
use App\Http\Requests\Admin\UpdateGatewayRequest;
use App\Http\Requests\Admin\AddGatewayCurrencyRequest;

class PaymentGatewayService implements AppPaymentGatewayService
{
    public function __construct(){}

    /**
     * Update Payment Gateway
     * @param \App\Http\Requests\Admin\UpdateGatewayRequest $request
     * @return array
     */
    public function updatePaymentGateway(UpdateGatewayRequest $request): array
    {
        if(! isset($request->uid))
            return failed(_t("Invalid payment gateway"));

        try {
            foreach ($request->all() as $key => $value){
                if(
                    $gateway = GatewayExtra::where([
                        "payment_gateway_uid" => $request->uid,
                        "slug" => $key
                    ])->first()
                )   $gateway->update([ "value" => $value ]);
            }

            if(isset($request->currency[0])){
                foreach($request->currency as  $index => $currency){
                    if(
                        $gateway_currency = GatewayCurrency::where([
                            "payment_gateway_uid" => $request->uid,
                            "currency_code"       => $currency
                        ])->first()
                    ){
                        $gateway_currency->update([
                            "fees"       => $request->fees[$index],
                            "fees_type"  => $request->fees_type[$index],
                        ]);
                    }   
                    
                }
            }

            return success(_t("Gateway updated successfully"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return failed($e->getMessage());
        }
    }


    /**
     * Get Payment Gateway By Uid And Currency
     * @param string $uid
     * @param string $currency
     * @param bool $throw
     * @param string $redirect
     * @return PaymentGateway|null
     */
    public function getPaymentGatewayByUidAndCurrency(string $uid, string $currency, bool $throw = false, string $redirect = null): ?PaymentGateway
    {
        if($gateway = PaymentGateway::firstByUidAndCurrency($uid, $currency)->first()){
            return $gateway;
        }

        if($throw){
            Response::throw(
                failed(_t("Payment gateway not found")),
                $redirect
            );
        }

        return null;
    }

    /**
     * Get Payment Gateway By Uid
     * @param string $uid
     * @param bool $throw
     * @param string $redirect
     * @return PaymentGateway|null
     */
    public function getPaymentGatewayByUid(string $uid, bool $throw = false, string $redirect = null): ?PaymentGateway
    {
        if($gateway = PaymentGateway::FirstByUid($uid)->first()){
            return $gateway;
        }

        if($throw){
            Response::throw(
                failed(_t("Payment gateway not found")),
                $redirect
            );
        }

        return null;
    }

    /**
     * Update Payment Gateway Status
     * @param \App\Models\PaymentGateway $gateway
     * @return array
     */
    public function changeGatewayStatus(PaymentGateway $gateway): array
    {
        $gateway->status = !$gateway->status;

        try {
            if($gateway->save()){
                return success(_t("Gateway status updated successfully"));
            }
            return failed(_t("Gateway status failed to update"));
        } catch (Exception $e) {
            Log::error("changeGatewayStatus : ".$e->getMessage());
            return failed($e->getMessage());
        }
    }

    /**
     * Add new currency to a payment gateway
     * @param \App\Http\Requests\Admin\AddGatewayCurrencyRequest $request
     * @return array
     */
    public function addGatewayCurrency(AddGatewayCurrencyRequest $request): array
    {
        $gateway = $this->getPaymentGatewayByUid(
            uid  : $request->uid,
            throw: true
        );

        $currency = Currency::where('code', strtoupper($request->currency_code))->first();
        if(!$currency) return failed(_t("Invalid currency provided"));

        $gatewayCurrency = GatewayCurrency::where([
            'payment_gateway_uid' => $request->uid,
            "currency_code" => strtoupper($request->currency_code)
        ])->first();
        if($gatewayCurrency) return failed(_t("This currency already exist"));

        $data = [
            "payment_gateway_uid" => $request->uid,
            "currency_code" => strtoupper($request->currency_code),
            "fees" => $request->fees,
            "fees_type" => $request->fees_type,
        ];

        try {
            if(GatewayCurrency::create($data))
            return success(_t("Currency added successfully"));
            return failed(_t("Failed to add currency"));
        } catch (Exception $e) {
            logStore("addGatewayCurrency", $e->getMessage());
            return failed(_t("Failed to add currency"));
        }
    }

    /**
     * Remove a currency from payment gateway
     * @param string $uid
     * @param string $currency_code
     * @return array
     */
    public function deleteGatewayCurrency(string $uid, string $currency_code): array
    {
        $gateway = $this->getPaymentGatewayByUid(
            uid  : $uid,
            throw: true
        );

        $gatewayCurrency = GatewayCurrency::where([
            'payment_gateway_uid' => $uid,
            "currency_code" => strtoupper($currency_code)
        ])->first();
        if(!$gatewayCurrency) return failed(_t("This currency not exist"));

        if($gatewayCurrency->delete())
        return success(_t("Currency removed successfully"));
        return failed(_t("This currency failed to remove"));
    }
}