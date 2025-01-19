<?php

namespace App\Http\Controllers\User;

use App\Models\Faq;
use App\Models\Coin;
use App\Enums\Status;
use App\Models\Currency;
use App\Enums\CurrencyType;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\BuyCryptoTransaction;
use App\Services\ResponseService\Response;
use App\Http\Requests\User\BuyCryptoRequest;
use App\Http\Requests\User\getCryptoPriceRequest;
use Illuminate\Support\Facades\View as ViewFactory;
use App\Services\CoinTransactionService\AppCoinTransactionService;

class TransactionController extends Controller
{
    public function __construct(private AppCoinTransactionService $service){}

    /**
     * View Buy Crypto Page
     * @return mixed
     */
    public function buyCryptoPage(): mixed
    {
        $coins = Coin::activeCoins()->get();
        $coins->map(function(Coin $coin){
            $coin->key   = $coin->coin;
            $coin->value = $coin->coin;
        });

        $paymentMethods = PaymentGateway::get();
        $paymentMethods->map(function(PaymentGateway $gateway){
            $gateway->key   = $gateway->uid;
            $gateway->value = $gateway->title;
        });
        
        $currencies = Currency::get();
        $currencies->map(function(Currency $currency){
            $currency->key   = $currency->code;
            $currency->value = $currency->code;
        });

        $faqs = Faq::activecoinBuyPage();
        
        
        $data["coins"]      = $coins;
        $data["currencies"] = $currencies;
        $data["gateways"]   = $paymentMethods;
        $data["faqs"]       = $faqs;

        return view("user.buy.buy", $data);
    }

    /**
     * Confirm Buy Crypto
     * @param \App\Http\Requests\User\BuyCryptoRequest $request
     * @return mixed
     */
    public function confirmBuyCrypto(BuyCryptoRequest $request): mixed
    {
        if(!$crypto = Coin::where(["coin"=> $request->crypto, "status" => enum(Status::ENABLE)])->first())
            return Response::send(failed(_t("Crypto coin not found")));
        
        if(!$currency = Coin::where(["coin"=> $request->currency, "status" => enum(Status::ENABLE)])->first())
            return Response::send(failed(_t("Currency not found")));
        
        $data["amount"] = $request->amount;
        $data["crypto"] = $crypto->coin;
        $data["currency"] = $currency->coin;

        return view('user.buy.confirm', $data);
    }

    /**
     * Get Crypto Price
     * @param \App\Http\Requests\User\getCryptoPriceRequest $request
     * @return mixed
     */
    public function cryptoPrice(getCryptoPriceRequest $request): mixed
    {
        return Response::send(
            $this->service->getCryptoPrice($request)
        );
    }

    /**
     * Crypto Buy Process
     * @param \App\Http\Requests\User\BuyCryptoRequest $request
     * @return mixed
     */
    public function cryptoBuyProcess(BuyCryptoRequest $request): mixed
    {
        return Response::send(
            $response = $this->service->cryptoBuyProcess($request),
            ($response['status'] ?? false) ? "cryptoPurchasedComplete" : "coinBuyPage"
        );
    }

    /**
     * Crypto Purchased Complete
     * @return mixed
     */
    public function cryptoPurchasedComplete(): mixed
    {
        return view('user.buy.done');
    }

    /**
     * Crypto Buy History
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function cryptoTransactions(Request $request): mixed
    {
        if(IS_API_REQUEST){
            $perPage = (isset($request->per_page) && is_numeric($request->per_page))? $request->per_page: 10;

            $wallets = 
            BuyCryptoTransaction::where("status", enum(Status::ENABLE))
                ->when(isset($request->search),function ($query) use($request) {
                    return $query->where(function($q)use($request){
                        return $q->where('spend_coin',   "LIKE", "%$request->search%")
                        ->orWhere('receive_coin', "LIKE", "%$request->search%")
                        ->orWhere('amount',    "LIKE", "%$request->search%")
                        ->orWhere('fees',      "LIKE", "%$request->search%")
                        ->orWhere('rate',      "LIKE", "%$request->search%");
                    });
                })
                ->paginate($perPage)->onEachSide(1);

            $wallets->map(function($item){
                $html = view('user.transactions.components.buy-crypto', ['history' => $item]);
                
                if ($html instanceof View){
                    $item->html = $html->render();
                }
            });

            return $wallets;
        }
        return view("user.transactions.buy-crypto");
    }
}
