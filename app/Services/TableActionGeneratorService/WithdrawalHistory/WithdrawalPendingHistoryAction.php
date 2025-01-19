<?php

namespace App\Services\TableActionGeneratorService\WithdrawalHistory;

use App\Models\Withdrawal;
use App\Services\TableActionGeneratorService\Generator;
use App\Services\TableActionGeneratorService\GeneratorService;

class WithdrawalPendingHistoryAction extends GeneratorService implements Generator
{
    private static ?WithdrawalPendingHistoryAction $instance = null;

    protected Withdrawal $withdrawal;
    public function __construct(){}

    public static function getInstance(mixed $withdrawal): Generator
    {
        if(self::$instance == null)
            self::$instance = new WithdrawalPendingHistoryAction();
        
        self::$instance->set($withdrawal);
        return self::$instance;
    }

    public function set(mixed $item):self
    {
        $this->withdrawal = $item;
        return $this;
    }
    
    public function render(): GeneratorService
    {
        $accept = route("withdrawalAccept", $this->withdrawal->id);
        $reject = route("withdrawalReject", $this->withdrawal->id);
        return $this
        ->setNode("accept", icon:'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg>')
            ->attr("class", "tooltip mx-1 btn btn-sm btn-success text-2xl rounded-full")
            ->attr("data-tip", _t("Accept"))
            ->attr("href", '#')
            ->attr('onclick', "Notiflix.Confirm.show('"
                   ._t("Accept Withdrawal Request")
                   ."','"
                   ._t("Are you sure you want to Accept this withdrawal request ?")
                   ."','"
                   ._t("Yes, Accept")
                   ."','"
                   ._t("No, Cancel")
                   ."',()=>{ window.location.href = '$accept' })")

        ->setNode("reject", icon:'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-octagon-x"><path d="m15 9-6 6"/><path d="M2.586 16.726A2 2 0 0 1 2 15.312V8.688a2 2 0 0 1 .586-1.414l4.688-4.688A2 2 0 0 1 8.688 2h6.624a2 2 0 0 1 1.414.586l4.688 4.688A2 2 0 0 1 22 8.688v6.624a2 2 0 0 1-.586 1.414l-4.688 4.688a2 2 0 0 1-1.414.586H8.688a2 2 0 0 1-1.414-.586z"/><path d="m9 9 6 6"/></svg>')
            ->attr("class", "tooltip mx-1 btn btn-sm btn-error text-2xl rounded-full")
            ->attr("data-tip", _t("Reject"))
            ->attr('href', '#')
            ->attr('onclick', "Notiflix.Confirm.show('"
                   ._t("Reject Withdrawal Request")
                   ."','"
                   ._t("Are you sure you want to reject this withdrawal request ?")
                   ."','"
                   ._t("Yes, Reject")
                   ."','"
                   ._t("No, Cancel")
                   ."',()=>{ window.location.href = '$reject' })")
        ;
    }
}
