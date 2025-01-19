<?php

namespace Database\Seeders;

use Exception;
use App\Models\Currency;
use App\Models\GatewayExtra;
use App\Models\PaymentGateway;
use App\Models\GatewayCurrency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gateways = require_once(__DIR__.'/../../app/Services/PaymentGatewayService/FixedPaymentGateway.php');

        try {
            DB::beginTransaction();
            foreach ($gateways as $gateway){
                $this->otherAttribute(
                    PaymentGateway::firstOrCreate([
                        "slug"  => $gateway['slug']
                    ],[
                        "uid"   => uniqueCode("AG"),
                        "title" => $gateway['title'],
                        "icon" => $gateway['icon'],
                    ]),
                    $gateway
                );
            }
            DB::commit();
        } catch (Exception $e) {
            echo 'Error: '.$e->getMessage();
        }
        
    }

    private function otherAttribute(PaymentGateway $gateway, $gatewayInfo)
    {
        foreach($gatewayInfo['attributes'] as $attr){
            GatewayExtra::updateOrCreate([
                "slug" => $attr["slug"],
                "payment_gateway_uid" => $gateway->uid
            ],[
                "title"    => $attr["title"],
                "type"     => $attr["type"],
                "required" => $attr["required"],
                "readonly" => $attr["readonly"],
            ]);
        }

        foreach($gatewayInfo['currency'] as $currency){
            if($currencyData = Currency::where("code", $currency)->first()){
                GatewayCurrency::firstOrCreate([
                    "payment_gateway_uid" => $gateway->uid,
                    "currency_code" => $currency
                ],[
                    "fees" => 0,
                    "fees_type" => 1
                ]);
            }
        }
    }
}
