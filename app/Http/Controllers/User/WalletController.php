<?php

namespace App\Http\Controllers\User;

use App\Models\Coin;
use App\Enums\Status;
use App\Models\Wallet;
use App\Facades\UserFacade;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\ResponseService\Response;
use App\Services\WalletService\WalletService;
use App\Services\WalletService\AppWalletService;
use App\Http\Requests\User\CryptoWalletWithdrawalRequest;
use Illuminate\Support\Facades\Response as FacadesResponse;

class WalletController extends Controller
{
    public function __construct(protected AppWalletService $walletService){}

    /**
     * View Crypto Wallet Page
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function cryptoWalletPage(Request $request): mixed
    {
        if(IS_API_REQUEST){
            /** @var int $perPage */
            $perPage = (isset($request->per_page) && is_numeric($request->per_page))? $request->per_page: 10;

            $wallets = Wallet::when(isset($request->search), function ($query) use ($request) {
                return $query->where(function($q) use ($request) {
                    $q->where('coin', "LIKE", "%{$request->search}%");
                    //   ->orWhere('name', "LIKE", "%{$request->search}%");
                      // ->orWhere('balance', "LIKE", "%{$request->search}%");
                });
            })
            ->withWhereHas("coin_parent_table",function($q){
                return $q->where('status', 1);
            })
            ->paginate($perPage)
            ->onEachSide(1);

            $wallets->map(function($item){
                $html = view('user.wallets.crypto.components.wallet_row', ['wallet' => $item]);
                
                if ($html instanceof View){
                    $item->html = $html->render();
                }
            });

            return $wallets;
        }

        $data['page'] = $request->query('page') ?? 1;
        UserFacade::updateUserWallets();
        return view('user.wallets.crypto.wallets', $data);
    }

    /**
     * Get Crypto Wallet Balance
     * @param string $coin
     * @return \Illuminate\Http\JsonResponse
     */
    public function cryptoWalletBalance(string $coin): JsonResponse
    {
        $data["wallet"] = WalletService::getAuthUserWallet($coin);

        return FacadesResponse::json(
            success($data)
        );
    }

    /**
     * View Crypto Wallet Deposit Page
     * @param \Illuminate\Http\Request $request
     * @param string $coin
     * @param ?string $uid
     * @return mixed
     */
    public function cryptoWalletDepositPage(Request $request, string $coin, string $uid = null): mixed
    {
        $data["wallet"] = 
        $this->walletService
             ->getCoinDepositDetails($coin, $request->coin_code ?? null, $uid)["data"][0] ?? collect();

        return view("user.wallets.crypto.deposit", $data);
    }

    /**
     * View Fiat Wallet Page
     * @return mixed
     */
    public function fiatWalletPage(): mixed
    {
        return view('user.wallets.fiat.wallets');
    }

    /**
     * View Crypto Wallet Withdrawal Page
     * @param string $coin
     * @param ?string $uid
     * @return mixed
     */
    public function cryptoWalletWithdrawalPage(string $coin, string $uid = null): mixed
    {
        $data =  $this->walletService
                ->getCoinWithdrawalPageData($coin, $uid);

        return view('user.wallets.crypto.withdrawal', $data['data']);
    }

    /**
     * Crypto Wallet Withdrawal
     * @param \App\Http\Requests\User\CryptoWalletWithdrawalRequest $request
     * @return mixed
     */
    public function cryptoWalletWithdrawal(CryptoWalletWithdrawalRequest $request): mixed
    {
        return Response::send(
            $this->walletService->cryptoWithdrawal($request)
        );
    }

    /**
     * CoinPayment Notifier
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function coinPaymentNotifier(Request $request): void
    {
        $this->walletService->coinPaymentNotifier($request);
    }
}
