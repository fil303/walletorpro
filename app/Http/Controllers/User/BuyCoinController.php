<?php

namespace App\Http\Controllers\User;

use App\Models\Coin;
use App\Enums\Status;
use App\Models\Currency;
use App\Enums\CurrencyType;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Facades\ResponseFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\User\BuyCryptoRequest;
use App\Services\CoinService\AppCoinService;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\User\getCryptoPriceRequest;
use Illuminate\Support\Facades\View as ViewFactory;
use App\Services\UserCoinBuyService\IUserCoinBuyService;
use App\Services\ResponseService\Response as SendResponse;

class BuyCoinController extends Controller
{
    /**
     * BuyCoinController __construct
     * @param \App\Services\UserCoinBuyService\IUserCoinBuyService $service
     */
    public function __construct(private IUserCoinBuyService $service){}

    /**
     * Coin Purchase Page
     * @return \Illuminate\Contracts\View\View
     */
    public function buyPage(): View
    {
        $data = [];
        if($coin = request()->coin)
        $data['selectedCoin'] = $coin;
        return ViewFactory::make("user.buy.buy", $data);
    }

    /**
     * Coin Purchase Page data
     * @return \Illuminate\Http\JsonResponse
     */
    public function buyPageData(): JsonResponse
    {
        $data['coins'] = Coin::activeCoins(CurrencyType::CRYPTO)->get();
        $data['currencies'] = Currency::ActiveCurrency()->get();
        $data['paymentMethods'] = PaymentGateway::getAll()->get();

        return Response::json(success(_t('Success'), $data));
    }

    /**
     * Coin Purchase Page coin list
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function buyCoinList(Request $request): JsonResponse
    {

        $perPage = (isset($request->per_page) && is_numeric($request->per_page))? $request->per_page: 10;

        $wallets = 
        Coin::join('coin_cap_market_prices', 'coin_cap_market_prices.coin_id', '=', 'coins.id')
            ->where("coins.status", Status::ENABLE->value)
            ->where("coins.type", CurrencyType::CRYPTO->value)
            ->when(isset($request->search),function ($query) use($request) {
                return $query->where(function($q)use($request){
                    return $q->where('coins.name', "LIKE", "%$request->search%")
                            ->orWhere('coins.coin', "LIKE", "%$request->search%");
                        //    ->orWhere('balance', "LIKE", "%$request->search%");
                });
            })
            ->select("coins.*", "coin_cap_market_prices.*")
            ->paginate($perPage)->onEachSide(1);

        $wallets->map(function($item){
            $item->html = ViewFactory::make('user.buy.components.coin_details', ['coin' => $item])->render();
        });

        return Response::json( $wallets);
    }

    /**
     * get coin buy model
     * @param string $coin
     * @return \Illuminate\Http\JsonResponse
     */
    public function buyCoinModal(string $coin): JsonResponse
    {
        $response = $this->service->getBuyCoinPageData();

        $responseData = $response['data'];
        $responseData['coin'] = $coin;
        $responseData['selected_crypto'] = $coin;

        $data['html'] = ViewFactory::make('user.buy.components.buyCryptoModal', $responseData)->render();
        $data['modal_id'] = "buyCoinModalId";

        return Response::json($data);
    }

    /**
     * Available payment methods send to user view
     * @param string|null $currency
     * @return \Illuminate\Http\JsonResponse
     */
    public function buyCoinPaymentMethod(?string $currency): JsonResponse
    {
        $response = $this->service->getPaymentMethodByCurrency($currency ?? '');

        if(!($response['status'] ?? false))
            return Response::json([]);

        /** @var Collection<int, PaymentGateway> $paymentMethods*/
        $paymentMethods = $response['data']['paymentMethods'] ?? collect();

        $data['html'] = ViewFactory::make('user.components.select_option', ['items' => $paymentMethods])->render();

        return Response::json($data);
    }


    /**
     * Get coin price here
     * @param \App\Http\Requests\User\getCryptoPriceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBuyCoinPrice(getCryptoPriceRequest $request): JsonResponse
    {
        $response = $this->service->getCryptoPrice($request);
        return Response::json($response);
    }

    /**
     * User coin buy process here
     * @param \App\Http\Requests\User\BuyCryptoRequest $request
     * @return mixed
     */
    public function coinBuyProcess(BuyCryptoRequest $request): mixed
    {
        $response = $this->service->coinBuyProcess($request);
        if(!$response['status'])
            return ResponseFacade::result($response)->send();
        
        if(isset($response["data"]["redirect_on_page"]))
            return ViewFactory::make($response["data"]["view"], $response["data"]);

        return SendResponse::send(
            response: $this->service->coinBuyProcess($request),
            route:    "coinBuyPage"
        );
    }

    /**
     * User will redirect here after cancel a payment
     * @param \Illuminate\Http\Request $request
     * @param mixed $gateway
     * @return mixed
     */
    public function coinBuyCancel(Request $request, $gateway)
    {
        return SendResponse::send(
            response: $this->service->cancelCoinOrder($gateway, $request),
            route   : "coinBuyPage"
        );
    }

    /**
     * User will redirect here after success a payment
     * @param \Illuminate\Http\Request $request
     * @param mixed $gateway
     * @return mixed
     */
    public function coinBuyConfirm(Request $request, $gateway)
    {
        return SendResponse::send(
            response: $this->service->confirmCoinOrder($gateway, $request),
            route   : "coinPurchaseReportPage"
        );
    }

    /**
     * User payment ipn functionality, check and verify user payment
     * @param \Illuminate\Http\Request $request
     * @param mixed $gateway
     * @return void
     */
    public function coinBuyPaymentIpn(Request $request, $gateway)
    {
        $this->service->coinOrderIpn($gateway, $request);
    }
}
