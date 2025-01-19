<?php

namespace App\Services\FaqService;

use App\Http\Requests\Admin\FaqRequest;

interface AppFaqService {
    /**
     * Save Faq
     * @param \App\Http\Requests\Admin\FaqRequest $faq
     * @return array
     */
    public function saveFaq(FaqRequest $faq): array;

    /**
     * Faq Delete
     * @param string $uid
     * @return array
     */
    public function faqDelete(string $uid): array;

    /**
     * Faq Status
     * @param string $uid
     * @return array
     */
    public function faqStatus(string $uid): array;
}