<?php

namespace App\Services\TableActionGeneratorService\SupportTicketTableAction;

use App\Models\User;
use App\Models\SupportTicket;
use App\Services\TableActionGeneratorService\Generator;
use App\Services\TableActionGeneratorService\GeneratorService;

class SupportTicketTableAction extends GeneratorService implements Generator
{
    private static ?SupportTicketTableAction $instance = null;

    protected SupportTicket $ticket;

    public static function getInstance(mixed $item): Generator
    {
        if(self::$instance == null)
            self::$instance = new SupportTicketTableAction();
        
        self::$instance->set($item);
        return self::$instance;
    }

    public function set(mixed $item):self
    {
        $this->ticket = $item;
        return $this;
    }
    
    public function render(): GeneratorService
    {
        $goTo = route("adminTicketsShow", ["ticket" => $this->ticket->ticket]);
        return $this
        ->setNode("details", icon:'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-pen"><path d="M12.5 22H18a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v9.5"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M13.378 15.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/></svg>')
            ->attr("class", "tooltip mx-1 btn btn-sm btn-info text-xl")
            ->attr("data-tip", _t("Details"))
            ->attr('href', $goTo);
    }
}
