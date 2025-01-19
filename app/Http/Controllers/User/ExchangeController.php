<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Facades\ResponseFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CoinExchangeRequest;
use App\Http\Requests\User\ExchangeRateRequest;
use App\Services\ExchangeService\IExchangeService;
use Illuminate\Support\Facades\View as ViewFactory;
use Illuminate\Support\Facades\Response as ResponseFactory;

class ExchangeController extends Controller
{
    public function __construct(private IExchangeService $service){}

    /**
     * View Exchange Page
     * @return \Illuminate\Contracts\View\View
     */
    public function exchangePage(): View
    {
        return ViewFactory::make("user.exchange.index");
    }

    /**
     * Get All Coins
     * @return \Illuminate\Http\JsonResponse
     */
    public function exchangeCoins(): JsonResponse
    {
        $response = $this->service->getAllCoins();
        return ResponseFactory::json($response);
    }

    /**
     * Get Exchange Rate
     * @param \App\Http\Requests\User\ExchangeRateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function exchangeRate(ExchangeRateRequest $request): JsonResponse
    {
        $response = $this->service->getExchangeRate($request);
        return ResponseFactory::json($response);
    }

    /**
     * Exchange Coin Process
     * @param \App\Http\Requests\User\CoinExchangeRequest $request
     * @return mixed
     */
    public function exchangeCoinProcess(CoinExchangeRequest $request): mixed
    {
        $response = $this->service->exchangeCoinProcess($request);
        return ResponseFacade::result($response)
            ->next("exchangePage")
            ->back()->send();
    }
}
