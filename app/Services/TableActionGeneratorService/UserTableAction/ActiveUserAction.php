<?php

namespace App\Services\TableActionGeneratorService\UserTableAction;

use App\Models\User;
use App\Services\TableActionGeneratorService\Generator;
use App\Services\TableActionGeneratorService\GeneratorService;

class ActiveUserAction extends GeneratorService implements Generator
{
    private static ?ActiveUserAction $instance = null;

    protected User $user;

    public static function getInstance(mixed $item): Generator
    {
        if(self::$instance == null)
            self::$instance = new ActiveUserAction();
        
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
        $suspendTo = route("suspendUser", $this->user->uid ?? 'notfound');
        $deleteTo = route("deleteUser", $this->user->uid ?? 'notfound');
        return $this
        ->setNode("suspend", _t("Suspend"))
            ->attr('class', "hover:bg-warning")
            ->attr('onclick', "Notiflix.Confirm.show('"
                   ._t("Active User")
                   ."','"
                   ._t("Are you sure you want to suspend this user ?")
                   ."','"
                   ._t("Yes, Suspend")
                   ."','"
                   ._t("No, Cancel")
                   ."',()=>{ window.location.href = '$suspendTo' })")

        ->setNode("delete", _t("Delete"))
            ->attr('class', "hover:bg-error")
            ->attr('onclick', "Notiflix.Confirm.show('"
                   ._t("Active User")
                   ."','"
                   ._t("Are you sure you want to active this user ?")
                   ."','"
                   ._t("Yes, Active")
                   ."','"
                   ._t("No, Cancel")
                   ."',()=>{ window.location.href = '$deleteTo' })");
    }
}
