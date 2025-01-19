<?php

namespace App\Services\CurrencyService;

use App\Models\Currency;
use App\Http\Requests\Admin\CurrencyUpdateRequest;

interface AppCurrencyService{

    /**
     * Get Currency By Code
     * @param string $code
     * @param bool $throw
     * @param string $redirect
     * @return Currency|null
     */
    public static function getCurrencyByCode(string $code, bool $throw = false, string $redirect = null): ?Currency;

    /**
     * Save Currency
     * @param \App\Http\Requests\Admin\CurrencyUpdateRequest $currency
     * @return array
     */
    public function saveCurrency(CurrencyUpdateRequest $currency): array;

    /**
     * Save Currency Status
     * @param string $uid
     * @return array
     */
    public function currencyStatus(string $uid): array;
}