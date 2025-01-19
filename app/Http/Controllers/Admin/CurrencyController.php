<?php

namespace App\Http\Controllers\Admin;

use App\Models\Currency;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Services\ResponseService\Response;
use App\Http\Requests\Admin\CurrencyUpdateRequest;
use App\Services\CurrencyService\AppCurrencyService;
use App\Services\TableActionGeneratorService\CurrencyList\CurrencyList;

class CurrencyController extends Controller
{
    public function __construct(protected AppCurrencyService $currencyService){}

    /**
     * Get Currency Page
     * @return mixed
     */
    public function currencyPage(): mixed
    {
        if(IS_API_REQUEST){
            $currency = Currency::query();

            return DataTables::of($currency)
            ->editColumn("status", function($lang){
                $statusData["items"] = [
                    "onchange" => 'updateCurrencyStatus(\''.$lang->code.'\')',
                ];
                if($lang->status) $statusData["items"]["checked"] = "";
                
                return view("admin.components.toggle", $statusData);
            })
            ->addColumn("action", fn($currency) =>  CurrencyList::getInstance($currency)->button())
            ->make(true);
        }
        return view("admin.currency.currency");
    }

    /**
     * Get Edit Currency Page
     * @param string $code
     * @return mixed
     */
    public function editCurrencyPage(string $code = null): mixed
    {
        $data = [];

        if($code) $data['item'] = Currency::where("code", $code)->first();
        return view("admin.currency.editCurrency", $data);
    }

    /**
     * Save Currency
     * @param \App\Http\Requests\Admin\CurrencyUpdateRequest $request
     * @return mixed
     */
    public function saveCurrency(CurrencyUpdateRequest $request): mixed
    {
       return Response::send(
            $this->currencyService->saveCurrency($request),
            "currencyPage"
       );
    }

    /**
     * Update Currency Status
     * @param string $code
     * @return mixed
     */
    public function updateCurrencyStatus(string $code): mixed
    {
       return Response::send(
            $this->currencyService->currencyStatus($code),
            "currencyPage"
       );
    }
}
