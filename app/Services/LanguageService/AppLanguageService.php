<?php

namespace App\Services\LanguageService;

use App\Http\Requests\Admin\LanguageRequest;

interface AppLanguageService{

    /**
     * Save Language
     * @param \App\Http\Requests\Admin\LanguageRequest $language
     * @return array
     */
    public function saveLanguage(LanguageRequest $language): array;

    /**
     * Language Delete
     * @param string $uid
     * @return array
     */
    public function languageDelete(string $uid): array;

    /**
     * Language Status
     * @param string $uid
     * @return array
     */
    public function languageStatus(string $uid): array;
}