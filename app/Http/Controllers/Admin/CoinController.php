<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coin;
use App\Models\CoinOrder;
use App\Facades\FileFacade;
use App\Enums\CoinBuyStatus;
use App\Models\CoinExchange;
use Illuminate\Http\Request;
use App\Enums\FileDestination;
use App\Facades\ResponseFacade;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Services\ResponseService\Response;
use App\Services\CoinService\AppCoinService;
use App\Http\Requests\Admin\AddCurrencyRequest;
use App\Http\Requests\Admin\UpdateCurrencyRequest;
use Illuminate\Support\Facades\View as ViewFactory;
use App\Services\TableActionGeneratorService\CoinActions;

class CoinController extends Controller
{
    public function __construct(protected AppCoinService $coinService)
    {
        //
    }

    /**
     * Get Coin Page
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function coinPage(Request $request): mixed
    {
        if($request->wantsJson()){
            $coins = Coin::query();
            return DataTables::of($coins)
            ->editColumn("name", function($coin){
                return view('admin.coins.crypto.components.name', compact('coin'));
            })
            ->editColumn("rate", function($coin){
                $rate = print_coin($coin->rate, $coin->print_decimal);
                return "$rate USD";
            })
            ->editColumn("status", function($coin){

                $data["items"] = [
                    "onchange" => 'updateStatus(\''.$coin->uid.'\')',
                ];
                if($coin->status) $data["items"]["checked"] = "";
                
                return view("admin.components.toggle", $data);
            })
            ->addColumn("action", function($coin){
                return CoinActions::getInstance($coin)->button();
            })
            ->rawColumns(['name', 'status', 'action'])
            ->make(true);
        }
        return view("admin.coins.crypto.coins");
    }

    /**
     * Get Add Coin Page
     * @param string $uid
     * @return mixed
     */
    public function addCoinPage(string $uid = null): mixed
    {
        if($uid && $coin = Coin::where("uid", $uid)->first()){
            $data['item'] = $coin;
        }
        
        $data['title'] = _t("Add New Crypto");
        return view("admin.coins.crypto.add_crypto", $data);
    }

    /**
     * Get Edit Coin Page
     * @param string $uid
     * @return mixed
     */
    public function editCoinPage(string $uid): mixed
    {
        if($coin = Coin::where("uid", $uid)->first()){
            $data['item'] = $coin;
        }

        if(!(isset($coin) && $coin)) return
        ResponseFacade::failed("Coin Not Found")->send();
        
        $data['title'] = _t("Add New Crypto");
        return view("admin.coins.crypto.edit_crypto", $data);
    }

    /**
     * Save Coin
     * @param \App\Http\Requests\Admin\AddCurrencyRequest $request
     * @return mixed
     */
    public function coinSave(AddCurrencyRequest $request): mixed
    {
        // create new currency array
        $newCurrency = [
            "uid"      => uniqueCode('CC'),
            "type"     => 'c',
            "name"     => $request->name,
            "coin"     => $request->coin,
            "code"     => $request->code,
            "rate"     => $request->rate,
            "provider" => 'coin_payment',
            "decimal"  => $request->decimal,
            "symbol"   => $request->symbol ?? NULL,
            "status"   => $request->status ?? false,
        ];

        if($request->hasFile('icon')){
            /** @var UploadedFile $file */
            $file = $request->file('icon');
            $newCurrency["icon"] = 
                FileFacade::saveImageInPublicStorage(
                    file: $file,
                    destination: FileDestination::COIN_ICON_PATH,
                    prefix: $request->type == 'c'? "CC": "FC", // cc = crypto & fc = fiat currency
                    // name: $request->code,
                );
        }

        /** @var Redirector $redirect */
        $redirect = redirect();

        if($this->coinService->saveNewCurrency($newCurrency)){
            return $redirect->route("coinsPage")->with("success", _t("Crypto Added Successfully."));
        }
        return $redirect->back()->with("error", _t("Failed To Add Crypto."))->withInput();
    }

    /**
     * Update Coin
     * @param \App\Http\Requests\Admin\UpdateCurrencyRequest $request
     * @return mixed
     */
    public function coinUpdate(UpdateCurrencyRequest $request): mixed
    {
        return Response::send(
            $this->coinService->updateCoin($request)
        );
    }

    /**
     * Coin Status Update
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function coinStatusUpdate(Request $request): mixed
    {
        return Response::send(
            $this->coinService->updateCoinStatus($request)
        );
    }

    /**
     * Coin Delete
     * @param string $uid
     * @return mixed
     */
    public function coinDelete(string $uid): mixed
    {
        return Response::send(
            $this->coinService->deleteCoin($uid)
        );
    }

    /**
     * Get Coin PPurchase Page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function coinPurchaseReport(Request $request): View|JsonResponse
    {
        if(IS_API_REQUEST){
            $orders = CoinOrder::with(['user', 'payment','coin_table'])
            ->where('status', '<>', CoinBuyStatus::PENDING->value)
            ->where('status', '<>', CoinBuyStatus::CANCELED->value);
            
            return DataTables::of($orders)
            ->addColumn("user", function($order){
                $user = $order->user;
                return view('admin.users.components.name', compact('user'));
            })
            ->editColumn("coin", function($order){
                return view('admin.coins.crypto.components.name', ['coin' => $order->coin_table ?? null]);
            })
            ->editColumn("rate", function($order){
                return trim_number(print_coin($order->rate))." $order->currency_code";
            })
            ->editColumn("amount", function($order){
                return trim_number(print_coin($order->amount, $order?->coin_table?->print_decimal))." $order->coin";
            })
            ->editColumn("fees", function($order){
                return trim_number(print_coin($order->fees))." $order->currency_code";
            })
            ->addColumn("paid", function($order){
                return trim_number(print_coin($order->total_price))." $order->currency_code";
            })
            ->addColumn("paymentBy", function($order){
                return $order->payment?->title;
            })
            ->editColumn("status", function($order){
                $status = CoinBuyStatus::tryFrom($order->status ?? 3);
                $color = match ($status) {
                    CoinBuyStatus::COMPLETED => "primary",
                    CoinBuyStatus::WAITING => "info",
                    default => "primary"
                };
                $status = $status?->status() ?? 'N/A';
                return "<div class=\"badge badge-$color badge-outline\">$status</div>";
            })
            ->editColumn("created_at", function($coin){
                return date("d F, Y h:i A", strtotime($coin->created_at));
            })
            ->rawColumns(['user', 'coin', 'status'])
            ->make(true);
        }
        return ViewFactory::make("admin.coins.crypto.coin-order-report");
    }

    /**
     * Get Coin Exchange Page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function coinExchangeReport(Request $request): View|JsonResponse
    {
        if(IS_API_REQUEST){
            $orders = CoinExchange::with(['user', 'f_coin', 't_coin']);
            return DataTables::of($orders)
            ->addColumn("user", function($exchange){
                $user = $exchange->user;
                return view('admin.users.components.name', compact('user'));
            })
            ->addColumn("from", function($exchange){
                $amount = print_coin($exchange->from_amount, $exchange->f_coin?->print_decimal ?? 8);
                return "$amount $exchange->from_coin";
            })
            ->addColumn("to", function($exchange){
                $amount = print_coin($exchange->to_amount, $exchange->t_coin?->print_decimal ?? 8);
                return "$amount $exchange->to_coin";
            })
            ->editColumn("rate", function($exchange){
                $amount = print_coin($exchange->rate, $exchange->t_coin?->print_decimal ?? 8);
                return "$amount $exchange->to_coin";
            })
            ->editColumn("fees", function($exchange){
                $amount = print_coin($exchange->fee, $exchange->f_coin?->print_decimal ?? 8);
                return "$amount $exchange->from_coin";
            })
            ->editColumn("created_at", function($coin){
                return date("d F, Y h:i A", strtotime($coin->created_at));
            })
            ->rawColumns(['user'])
            ->make(true);
        }
        return ViewFactory::make("admin.coins.crypto.coin-exchange-report");
    }

}
