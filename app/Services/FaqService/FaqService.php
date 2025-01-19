<?php

namespace App\Services\FaqService;

use Exception;
use App\Models\Faq;
use App\Enums\FaqPages;
use App\Http\Requests\Admin\FaqRequest;

class FaqService implements AppFaqService {

    public function __construct(){}

    /**
     * Save Faq
     * @param \App\Http\Requests\Admin\FaqRequest $faq
     * @return array
     */
    public function saveFaq(FaqRequest $faq): array
    {
        $successResponse = _t("FAQ added successfully");
        $successUpdateResponse = _t("FAQ updated successfully");
        
        $failedResponse = _t("Failed to add new FAQ");
        $failedUpdateResponse = _t("Failed to update FAQ");

        $finder = ["uid" => isset($faq->uid)? $faq->uid: uniqueCode("FAQ")];

        $faqData = [
            "question" => $faq->question,
            "answer" => $faq->answer,
            "page" => $faq->page ?? FaqPages::HOME->value,
            "lang" => $faq->lang ?? 'en',
            "status" => $faq->status == true,
        ];

        try {
            if($Faq = Faq::updateOrCreate($finder, $faqData)){
                if(isset($faq->uid)) return success($successUpdateResponse);
                return success($successResponse);
            }
            if(isset($faq->uid)) return success($failedUpdateResponse);
            return success($failedResponse);
        } catch (Exception $e) {
            logStore("saveFaq Line", $e->getLine());
            logStore("saveFaq", $e->getMessage());
            return failed($e->getMessage());
        }
    }

    /**
     * Faq Delete
     * @param string $uid
     * @return array
     */
    public function faqDelete(string $uid): array
    {
        if(! $faq = Faq::where("uid", $uid)->first())
            return failed(_t("Faq not found"));

        if($faq->delete())
            return success(_t("Faq deleted successfully"));

        return failed(_t("Faq failed to delete"));
    }

    /**
     * Faq Status
     * @param string $uid
     * @return array
     */
    public function faqStatus(string $uid): array
    {
        if(! $faq = Faq::where("uid", $uid)->first())
            return failed(_t("FAQ not found"));

        $faq->status = !$faq->status->value;
        
        if($faq->save())
            return success(_t("FAQ status update successfully"));

        return failed(_t("FAQ failed to update status"));
    }

}