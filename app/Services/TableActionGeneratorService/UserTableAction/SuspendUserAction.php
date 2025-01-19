<?php

namespace App\Services\TableActionGeneratorService\UserTableAction;

use App\Models\User;
use App\Services\TableActionGeneratorService\Generator;
use App\Services\TableActionGeneratorService\GeneratorService;

class SuspendUserAction extends GeneratorService implements Generator
{
    private static ?SuspendUserAction $instance = null;

    protected User $user;

    public static function getInstance(mixed $item): Generator
    {
        if(self::$instance == null)
            self::$instance = new SuspendUserAction();
        
        self::$instance->set($item);
        return self::$instance;
    }

    public function set(mixed $item):self
    {
        $this->user = $item;
        return $this;
    }
    
    public function render(): GeneratorService
    {
        $activeTo = route("activeUser", $this->user->uid ?? "notfound");
        $deleteTo = route("deleteUser", $this->user->uid ?? "notfound");
        return $this
        ->setNode("active", icon:'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg>')
            ->attr("class", "tooltip mx-1 btn btn-sm btn-info")
            ->attr("data-tip", _t("Active"))
            ->attr('href', '#')
            ->attr('onclick', "Notiflix.Confirm.show('"
                   ._t("Active User")
                   ."','"
                   ._t("Are you sure you want to active this user ?")
                   ."','"
                   ._t("Yes, Active")
                   ."','"
                   ._t("No, Cancel")
                   ."',()=>{ window.location.href = '$activeTo' })")
        
        ->setNode("delete", icon:'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-octagon-x"><path d="m15 9-6 6"/><path d="M2.586 16.726A2 2 0 0 1 2 15.312V8.688a2 2 0 0 1 .586-1.414l4.688-4.688A2 2 0 0 1 8.688 2h6.624a2 2 0 0 1 1.414.586l4.688 4.688A2 2 0 0 1 22 8.688v6.624a2 2 0 0 1-.586 1.414l-4.688 4.688a2 2 0 0 1-1.414.586H8.688a2 2 0 0 1-1.414-.586z"/><path d="m9 9 6 6"/></svg>')
            ->attr("class", "tooltip mx-1 btn btn-sm btn-error")
            ->attr("data-tip", _t("Delete"))
            ->attr('href', '#')
            ->attr('onclick', "Notiflix.Confirm.show('"
                   ._t("Delete User")
                   ."','"
                   ._t("Are you sure you want to delete this user ?")
                   ."','"
                   ._t("Yes, Delete")
                   ."','"
                   ._t("No, Cancel")
                   ."',()=>{ window.location.href = '$deleteTo' })");
    }
}
