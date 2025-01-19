<?php

namespace App\Services\TableActionGeneratorService\CurrencyList;
use App\Models\Faq;
use App\Models\Currency;
use App\Services\TableActionGeneratorService\Generator;
use App\Services\TableActionGeneratorService\GeneratorService;

class CurrencyList extends GeneratorService implements Generator
{
    private static ?CurrencyList $instance = null;

    protected Currency $currency;
    public function __construct(){}

    public static function getInstance(mixed $currency): Generator
    {
        if(self::$instance == null)
            self::$instance = new self();
        
        self::$instance->set($currency);
        return self::$instance;
    }

    public function set(mixed $item):self
    {
        $this->currency = $item;
        return $this;
    }
    
    public function render(): GeneratorService
    {
        $editTo = route("editCurrencyPage", $this->currency->code);
        return $this
        ->setNode("edit", icon:'<span class="icon-[teenyicons--edit-circle-outline]" style="color: black;"></span>')
            ->attr("class", "tooltip p-1 bg-success text-2xl rounded")
            ->attr("data-tip", _t("Edit"))
            ->attr("href", $editTo)

        ;
    }
}
