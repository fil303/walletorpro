<?php

namespace App\Services\TableActionGeneratorService\GatewayList;
use App\Models\Language;
use App\Models\PaymentGateway;
use App\Services\TableActionGeneratorService\Generator;
use App\Services\TableActionGeneratorService\GeneratorService;

class GatewayList extends GeneratorService implements Generator
{
    private static ?GatewayList $instance = null;

    protected PaymentGateway $gateway;
    public function __construct(){}

    public static function getInstance(mixed $gateway): Generator
    {
        if(self::$instance == null)
            self::$instance = new self();
        
        self::$instance->set($gateway);
        return self::$instance;
    }

    public function set(mixed $item):self
    {
        $this->gateway = $item;
        return $this;
    }
    
    public function render(): GeneratorService
    {
        $viewTo = route("autoGatewayDetails", $this->gateway->uid);
        $icon   = asset_bind('assets/lucide/eye.svg');

        return $this
        ->setNode("view", icon:'<img src="'.$icon.'" />')
            ->attr("class", "tooltip mx-1 bg-success rounded text-2xl p-1")
            ->attr("data-tip", _t("View"))
            ->attr("href", $viewTo);
    }
}
