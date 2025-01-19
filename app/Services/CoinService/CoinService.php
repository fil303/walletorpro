<?php

namespace App\Services\CoinService;

use Exception;
use App\Models\Coin;
use App\Models\Wallet;
use App\Models\Deposit;
use App\Enums\CurrencyType;
use App\Facades\FileFacade;
use Illuminate\Http\Request;
use App\Models\WalletAddress;
use App\Enums\FileDestination;
use App\Exceptions\CoinNotFound;
use Illuminate\Http\UploadedFile;
use App\Models\CoinCapMarketPrice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Services\ResponseService\Response;
use App\Services\CoinService\AppCoinService;
use App\Services\CoinMarketCap\CoinMarketCap;
use App\Http\Requests\Admin\UpdateCurrencyRequest;

class CoinService implements AppCoinService
{

    public static ?Coin $coin = null;

    public function __construct(){}

    /**
     * Get Coin
     * @return Coin|null
     */
    public static function getCoin(): ?Coin
    {
        return self::$coin ? self::$coin : null;
    }

    /**
     * Get Coin By Uid
     * @param string $uid
     * @throws \Exception
     * @return Coin|null
     */
    public static function getCoinByUid(string $uid): ?Coin
    {
        if(!self::$coin = Coin::where('uid', $uid)->first()){
            throw new Exception(_t("Coin not found"));
        }
        return self::getCoin();
    }

    /**
     * Get Coins By Coin
     * @param string $coin
     * @throws \App\Exceptions\CoinNotFound
     * @return \Illuminate\Support\Collection
     */
    public static function getCoinsByCoin(string $coin): Collection
    {
        /** @var Collection $coins */
        $coins = Coin::where('coin', $coin)->get();
        if(is_countable($coins) && filled($coins)){
            return $coins;
        } throw new CoinNotFound();
    }

    /**
     * Get Coin By Coin
     * @param string $coin
     * @param bool $throw
     * @param string $redirect
     * @return Coin|null
     */
    public static function getCoinByCoin(string $coin, bool $throw = false, string $redirect = null): ?Coin
    {
        if(self::$coin = Coin::where('coin', $coin)->first()){
            return self::getCoin();
        }

        if($throw){
            Response::throw(
                failed(_t("Coin not found")),
                $redirect
            );
        }

        return null;
    }

    /**
     * Save New Currency
     * @param array<string, string> $newCurrency
     * @return ?Coin
     */
    public function saveNewCurrency(array $newCurrency): ?Coin
    {
        try{
            return Coin::create($newCurrency);
        } catch (\Exception $e) {
            logStore("saveNewCurrency", $e->getMessage());
            return null;
        }
    }

    /**
     * Update Coin
     * @param \App\Http\Requests\Admin\UpdateCurrencyRequest $request
     * @return array
     */
    public function updateCoin(UpdateCurrencyRequest $request): array
    {
        if(! self::$coin = Coin::where('uid', $request->uid)->first())
            return failed(_t("Coin Not Found."));

        $updateCoin = [
            "name"   => $request->name,
            "status" => false,
            "exchange_status"   => false,
            "withdrawal_status" => false,
            "buy_status" => false,
        ];

        if(isset($request->rate))               $updateCoin["rate"]             = $request->rate;
        if(isset($request->decimal))            $updateCoin["decimal"]          = $request->decimal;
        if(isset($request->symbol))             $updateCoin["symbol"]           = $request->symbol;
        if(isset($request->status))             $updateCoin["status"]           = true;
        if(isset($request->buy_status))         $updateCoin["buy_status"]       = true;
        if(isset($request->withdrawal_status))  $updateCoin["withdrawal_status"]= true;
        if(isset($request->exchange_status))    $updateCoin["exchange_status"]  = true;
        if(isset($request->print_decimal))      $updateCoin["print_decimal"]    = $request->print_decimal;
        if(isset($request->withdrawal_min))     $updateCoin["withdrawal_min"]   = $request->withdrawal_min;
        if(isset($request->withdrawal_max))     $updateCoin["withdrawal_max"]   = $request->withdrawal_max;
        if(isset($request->withdrawal_fees))    $updateCoin["withdrawal_fees"]  = $request->withdrawal_fees;
        if(isset($request->withdrawal_fees_type)) $updateCoin["withdrawal_fees_type"] = $request->withdrawal_fees_type;
        if(isset($request->exchange_fees))      $updateCoin["exchange_fees"]    = $request->exchange_fees;
        if(isset($request->exchange_fees_type)) $updateCoin["exchange_fees_type"]= $request->exchange_fees_type;

        if($request->hasFile('icon')){
            $removed = FileFacade::removePublicFile(
                self::$coin->icon ?? ""
            );

            /** @var UploadedFile $file */
            $file = $request->file('icon');
            $updateCoin["icon"] = 
                FileFacade::saveImageInPublicStorage(
                    file: $file,
                    destination: FileDestination::COIN_ICON_PATH,
                    prefix: "CC", // cc = crypto & fc = fiat currency
                    name: self::$coin->code,
                );
        }

        $update = $this->updateCoinData($updateCoin);
        if(is_array($update)) return $update;
        if($update) return success(_t("Coin updated successfully"));
        return failed(_t("Coin failed to update."));
    }

    /**
     * Udate Coin Data
     * @param array<string> $coinData
     * @return bool|array
     */
    public function updateCoinData(array $coinData): bool|array
    {
        try {
            if(! $coin = self::getCoin())
                return failed(_t("Coin not found."));

            return $coin->update($coinData);
        } catch (\Throwable $th) {
            logStore("updateCoin", $th->getMessage());
            return false;
        }
    }

    /**
     * Delete Coin
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function updateCoinStatus(Request $request):array
    {
        if(! self::$coin = Coin::where('uid', $request->uid ?? "")->first())
            return failed(_t("Coin not found."));
        
        $updateCoin = [
            "status"   => !self::$coin->status
        ];

        $update = self::$coin->update($updateCoin);
        if($update) return success(_t("Coin status updated successfully"));
        return failed(_t("Coin status failed to update."));
    }

    /**
     * Delete Coin
     * @param string $uid
     * @return array
     */
    public function deleteCoin(string $uid):array
    {
        if(! self::$coin = Coin::where('uid', $uid)->first())
            return failed(_t("Coin not found."));

        $wallet = Wallet::where(['user_id' => Auth::id(), 'coin' => self::$coin->coin])->first();
        $address= WalletAddress::where(['user_id' => Auth::id(), 'wallet_id' => $wallet->id ?? 0])->first();
        $deposit= Deposit::where(['user_id' => Auth::id(), 'coin_id' => self::$coin->id ?? 0])->first();

        if(
            ($deposit->amount  ?? 0   ) > 0 ||
            ($wallet ->balance ?? 0   ) > 0 ||
            ($address->address ?? null) != null
        ) return failed(_t("Coin can't be deleted. Already in use."));

        $removed = FileFacade::removePublicFile(
            self::$coin->icon ?? ""
        );
        
        if(self::$coin->delete()) return success(_t("Coin successfully deleted."));
        return failed(_t("Coin failed to delete."));
    }

    /**
     * Update Active Coin Price
     * @return void
     */
    public function updateActiveCoinPrice(): void
    {
        $convert_to = "USD";
        $coins = Coin::activeCoins(CurrencyType::CRYPTO)->get();
        if(isset($coins[0])){
            $coinArray = $coins->pluck("coin");
            $coinMarketCap = new CoinMarketCap;
            foreach($coins as $coin){
                $response = $coinMarketCap->getPriceConversion($coin->coin, $convert_to);
                if(
                    $response 
                    && isset($response['status']['error_code']) 
                    && $response['status']['error_code'] == 0
                    && isset($response['data'][0])
                ){
                    $responseData = $response['data'][0];
                    $quoteData = $responseData['quote'];
                    $price = $quoteData[$convert_to]['price'] ?? 0;

                    if($price){
                        Coin::where("coin", $coin->coin)->update([
                            "rate"    => to_decimal($price, $coin->decimal),
                        ]);
                    }
                }
            }
        }
    }

    /**
     * cron job method to get price from CapMarketWidget and update coin price
     * @return void
     */
    public function updateCoinPriceFromCoinCapMarketWidget(): void
    {
        $convert_to = 'USDT';
        $coins = Coin::activeCoins(CurrencyType::CRYPTO)->get();
        if(isset($coins[0])){
            $coinArray = $coins->pluck("coin");
            $coinMarketCap = new CoinMarketCap;
            foreach($coins as $coin){
                $response = $coinMarketCap->get3rdPartyCoinPrice($coin->coin, $convert_to);

                if($response['status'] ?? false){
                    Coin::find( $coin->id)->update([
                        "rate" => $response['data']['coin_price'] ?? 0,
                    ]);

                    CoinCapMarketPrice::updateOrCreate(
                        [ "coin_id" => $coin->id ],
                        $response['data']
                    );
                }
            }
        }
    }

}
