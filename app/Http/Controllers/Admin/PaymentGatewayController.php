<?php

namespace App\Http\Controllers\Admin;

use App\Models\GatewayExtra;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Facades\ResponseFacade;
use App\Models\GatewayCurrency;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Services\ResponseService\Response;
use App\Http\Requests\Admin\UpdateGatewayRequest;
use App\Http\Requests\Admin\AddGatewayCurrencyRequest;
use App\Services\PaymentGatewayService\AppPaymentGatewayService;
use App\Services\TableActionGeneratorService\GatewayList\GatewayList;

class PaymentGatewayController extends Controller
{
    public function __construct(protected AppPaymentGatewayService $service){}

    /**
     * Get Payment Gateway Page
     * @return mixed
     */
    public function autoGatewayList(): mixed
    {
        if(IS_API_REQUEST){
            $gateways = PaymentGateway::query();
            
            return DataTables::of($gateways)
            ->addColumn("gateway", function($gateway){
                return view('admin.gateway.components.gateway', compact('gateway'));
            })
            ->editColumn("status", function($gateway){
                $toggle["items"] = [
                    "onchange" => "updateGatewayStatus('$gateway->uid')"
                ];
                if($gateway->status) $toggle["items"]['checked'] = "";
                return view('admin.components.toggle', $toggle);
            })
            ->addColumn("action", function($gateway){
                return GatewayList::getInstance($gateway)->button();
            })
            ->rawColumns(['status', 'action'])
            ->make();
        }
        return view("admin.gateway.automated_gateway_list");
    }

    /**
     * Get Automated Gateway Details
     * @param string $uid
     * @return mixed
     */
    public function autoGatewayDetails(string $uid): mixed
    {
        if( !$gateway = PaymentGateway::where("uid", $uid)->first())
            ResponseFacade::failed(_t("Gateway not found"))->throw();

        $gateway_attr     = GatewayExtra::where("payment_gateway_uid", $gateway->uid)->get();
        $gateway_currency = GatewayCurrency::where("payment_gateway_uid", $gateway->uid)->with('currency')->get();

        return view("admin.gateway.automated_gateway", compact('gateway', 'gateway_attr', 'gateway_currency'));
    }

    /**
     * Update Automated Gateway
     * @param \App\Http\Requests\Admin\UpdateGatewayRequest $request
     * @return mixed
     */
    public function updateAutomatedGateway(UpdateGatewayRequest $request): mixed
    {
        return Response::send(
            $this->service->updatePaymentGateway($request)
        );
    }

    /**
     * Update Automated Gateway Status
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function updateGatewayStatus(Request $request): mixed
    {
        return Response::send(
            ($gateway = $this->service->getPaymentGatewayByUid($request->uid ?? ""))?
            $this->service->changeGatewayStatus($gateway):
            failed(_t("Gateway status failed to update"))
        );
    }

    /**
     * Add Gateway Currency
     * @param \App\Http\Requests\Admin\AddGatewayCurrencyRequest $request
     * @return mixed
     */
    public function addGatewayCurrency(AddGatewayCurrencyRequest $request): mixed
    {
        $response = $this->service->addGatewayCurrency($request);
        return ResponseFacade::result($response)->send(); 
    }

    /**
     * Delete Gateway Currency
     * @param string $uid
     * @param string $currency_code
     * @return mixed
     */
    public function autoGatewayCurrencyDelete(string $uid, string $currency_code): mixed
    {
        $response = $this->service->deleteGatewayCurrency($uid, $currency_code);
        return ResponseFacade::result($response)->send(); 
    }
}
