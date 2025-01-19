<?php
namespace App\Services\CurrencyService;

use Exception;
use App\Models\Currency;
use App\Services\ResponseService\Response;
use App\Services\CoinMarketCap\CoinMarketCap;
use App\Http\Requests\Admin\CurrencyUpdateRequest;
use App\Services\CurrencyService\AppCurrencyService;

class CurrencyService implements AppCurrencyService
{
    public static Currency $currency;
    public function __construct(){}

    /**
     * Get Currency By Code
     * @param string $code
     * @param bool $throw
     * @param string $redirect
     * @return Currency|null
     */
    public static function getCurrencyByCode(string $code, bool $throw = false, string $redirect = null): ?Currency
    {
        if(self::$currency = Currency::where('code', $code)->first()){
            return self::$currency;
        }

        if($throw){
            Response::throw(
                failed(_t("Currency not found")),
                $redirect
            );
        }

        return null;
    }

    /**
     * @param CurrencyUpdateRequest $currency
     * @return mixed[]
     */
    public function saveCurrency(CurrencyUpdateRequest $currency): array
    {
        $successResponse = _t("Language added successfully");
        $successUpdateResponse = _t("Language updated successfully");

        $failedResponse = _t("Failed to add new language");
        $failedUpdateResponse = _t("Failed to update language");

        if(!Currency::where("code", $currency->code)->first())
            return failed(_t("This currency already exists"));

        $finder = ["code" => isset($currency->code)? $currency->code: uniqueCode("FC")];

        $currencyData = [
            "name"   => $currency->name,
            "code"   => $currency->code,
            "symbol" => $currency->symbol,
            "rate"   => $currency->rate,
            "status" => $currency->status == true,
        ];

        try {
            if($lang = Currency::updateOrCreate($finder, $currencyData)){
                if(isset($currency->code)) return success($successUpdateResponse);
                return success($successResponse);
            }
            if(isset($currency->code)) return success($failedUpdateResponse);
            return success($failedResponse);
        } catch (Exception $e) {
            logStore("saveCurrency", $e->getMessage());
            return failed($e->getMessage());
        }
    }

    /**
     * Currency Status
     * @param mixed $code
     * @return array
     */
    public function currencyStatus($code): array
    {
        if(! $currency = Currency::where("code", $code)->first())
            return failed(_t("Currency not found"));

        $currency->status = !$currency->status;
        
        if($currency->save())
            return success(_t("Currency status update successfully"));

        return failed(_t("Currency failed to update status"));
    }

    /**
     * cron job method to get price from CapMarketWidget and update currency price
     * @return void
     */
    public function updateCurrencyPriceFromCoinCapMarketWidget(): void
    {
        $from = 'USDT';
        $currencies = Currency::activeCurrency()->get();
        if(isset($currencies[0])){
            $currenciesArray = $currencies->pluck("code");
            $coinMarketCap = new CoinMarketCap;
            foreach($currencies as $currency){
                $response = $coinMarketCap->get3rdPartyCoinPrice($from, $currency->code);

                if($response['status'] ?? false){
                    $price = $response['data']['coin_price'] ?? 0;
                    $currency->update([
                        "rate"    => $price, //to_decimal($price, $coin->decimal),
                    ]);
                }
            }
        }
    }
}