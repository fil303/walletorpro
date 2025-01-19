<?php

namespace App\Services\TableActionGeneratorService\TestimonialList;
use App\Models\Faq;
use App\Models\Testimonial;
use App\Services\TableActionGeneratorService\Generator;
use App\Services\TableActionGeneratorService\GeneratorService;

class TestimonialList extends GeneratorService implements Generator
{
    private static ?TestimonialList $instance = null;

    protected Testimonial $testimonial;
    public function __construct(){}

    public static function getInstance(mixed $testimonial): Generator
    {
        if(self::$instance == null)
            self::$instance = new self();
        
        self::$instance->set($testimonial);
        return self::$instance;
    }

    public function set(mixed $item):self
    {
        $this->testimonial = $item;
        return $this;
    }
    
    public function render(): GeneratorService
    {
        $editTo = route("landingTestimonial", $this->testimonial->id);
        $deleteTo = route("landingTestimonialDelete", $this->testimonial->id);

        return $this
        ->setNode("edit", icon:'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-pen"><path d="M12.5 22H18a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v9.5"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M13.378 15.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/></svg>')
            ->attr("class", "tooltip mx-1 btn btn-sm btn-success text-2xl")
            ->attr("data-tip", _t("Edit"))
            ->attr("href", $editTo)

        ->setNode("delete", icon:'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-octagon-x"><path d="m15 9-6 6"/><path d="M2.586 16.726A2 2 0 0 1 2 15.312V8.688a2 2 0 0 1 .586-1.414l4.688-4.688A2 2 0 0 1 8.688 2h6.624a2 2 0 0 1 1.414.586l4.688 4.688A2 2 0 0 1 22 8.688v6.624a2 2 0 0 1-.586 1.414l-4.688 4.688a2 2 0 0 1-1.414.586H8.688a2 2 0 0 1-1.414-.586z"/><path d="m9 9 6 6"/></svg>')
            ->attr("class", "tooltip mx-1 btn btn-sm btn-error text-2xl")
            ->attr("data-tip", _t("Delete"))
            ->attr('href', '#')
            ->attr('onclick', "Notiflix.Confirm.show('"
                   ._t("Testimonial Delete")
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
