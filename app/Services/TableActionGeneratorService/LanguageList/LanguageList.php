<?php

namespace App\Services\TableActionGeneratorService\LanguageList;
use App\Models\Language;
use App\Services\TableActionGeneratorService\Generator;
use App\Services\TableActionGeneratorService\GeneratorService;

class LanguageList extends GeneratorService implements Generator
{
    private static ?LanguageList $instance = null;

    protected Language $language;
    public function __construct(){}

    public static function getInstance(mixed $language): Generator
    {
        if(self::$instance == null)
            self::$instance = new self();
        
        self::$instance->set($language);
        return self::$instance;
    }

    public function set(mixed $item):self
    {
        $this->language = $item;
        return $this;
    }
    
    public function render(): GeneratorService
    {
        $editTo = route("addEditLanguagePage", $this->language->uid);
        $deleteTo = route("languageDelete", $this->language->uid);

        return $this
        ->setNode("edit", icon:'<span class="icon-[teenyicons--edit-circle-outline]" style="color: black;"></span>')
            ->attr("class", "tooltip mx-1 btn btn-sm btn-success text-2xl")
            ->attr("data-tip", _t("Edit"))
            ->attr("href", $editTo)

        ->setNode("delete", icon:'<span class="icon-[pepicons-pop--trash-circle]" style="color: black;"></span>')
            ->attr("class", "tooltip mx-1 btn btn-sm btn-error text-2xl")
            ->attr("data-tip", _t("Delete"))
            ->attr('href', '#')
            ->attr('onclick', "Notiflix.Confirm.show('"
                   ._t("Language Delete")
                   ."','"
                   ._t("Are you sure you want to delete ?")
                   ."','"
                   ._t("Yes, Delete")
                   ."','"
                   ._t("No, Cancel")
                   ."',()=>{ window.location.href = '$deleteTo' })")
        ;
    }
}
