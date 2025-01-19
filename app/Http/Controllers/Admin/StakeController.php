<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CurrencyType;
use App\Models\Coin;
use App\Models\Stake;
use App\Models\StakePlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Services\ResponseService\Response;
use App\Services\StakeService\AppStakeService;
use App\Http\Requests\Admin\CreateStakeRequest;
use App\Services\TableActionGeneratorService\StakePlanList\StakePlanList;

class StakeController extends Controller
{
    public function __construct(protected AppStakeService $service){}

    /**
     * Get Stake Page
     * @return mixed
     */
    public function stakePage(): mixed
    {
        if(IS_API_REQUEST){
            $GLOBALS['stake_status_scope'] = null;
            $stakePlan = StakePlan::activePlanWithSegment()->with('plan_coin')->get();

            return DataTables::of($stakePlan)
            ->editColumn("coin", function($coin){
                return view('admin.coins.crypto.components.name', ['coin' => $coin->plan_coin ?? null]);
            })
            ->editColumn("min", function($plan){
                return "$plan->min $plan->coin";
            })
            ->editColumn("max", function($plan){
                return "$plan->max $plan->coin";
            })
            ->editColumn("interest", function($plan){
                $data['segments'] = $plan->segments ?? collect();
                $data['interest'] = true;
                return view("admin.stake.components.badge", $data);
            })
            ->editColumn("duration", function($plan){
                $data['segments'] = $plan->segments ?? collect();
                $data['plan'] = $plan;
                return view("admin.stake.components.duration_and_interest_modal", $data);
            })
            ->editColumn("created_at", function($plan){
                return date('Y-m-d', strtotime($plan->created_at));
            })
            ->editColumn("status", function($plan){
                $data["items"] = [
                    "onchange" => 'changeStatusStakePlan(\''.$plan->id.'\')',
                ];
                if($plan->status) $data["items"]["checked"] = "";
                
                return view("admin.components.toggle", $data);
            })
            ->addColumn("action", function($plan){
                return StakePlanList::getInstance($plan)->button();
            })
            ->rawColumns(['coin','interest', 'duration', 'status', 'action'])
            ->make(true);
        }
        return view('admin.stake.stake');
    }

    /**
     * View Stake Report Page
     * @return mixed
     */
    public function stakeReportPage(): mixed
    {
        if(IS_API_REQUEST){
            $GLOBALS['stake_status_scope'] = null;
            $stake = Stake::with('user')->orderBy("id", "desc")->get();

            return DataTables::of($stake)
            ->addColumn("user", function($stake){
                return $stake->user->name ."<br>@".$stake->user->username;
            })
            ->editColumn("amount", function($stake){
                return trim_number($stake->amount) . " $stake->coin";
            })
            ->editColumn("interest", function($stake){
                return trim_number($stake->interest_amount) . " $stake->coin"."<br>"."$stake->interest%";
            })
            ->addColumn("return", function($stake){
                return trim_number(number_format((float)($stake->amount + $stake->interest_amount), 8, ".", "")). " $stake->coin";
            })
            ->editColumn("created_at", function($plan){
                return $plan->created_at;
            })
            ->editColumn("end_at", function($stake){
                return $stake->end_at;
            })
            ->rawColumns(['user', 'interest'])
            ->make(true);
        }
        return view('admin.stake.stake-report');
    }

    /**
     * Create Stake Page
     * @return mixed
     */
    public function createStakePage(): mixed
    {
        $data['coins'] = Coin::activeCoins(CurrencyType::CRYPTO)->get();
        $data['coins']->map(function($coin){
            $coin->key   = $coin->uid;
            $coin->value = $coin->name;
        });
        return view('admin.stake.create-stake', $data);
    }

    /**
     * Save Stake Plan
     * @param \App\Http\Requests\Admin\CreateStakeRequest $request
     * @return mixed
     */
    public function saveStakePlan(CreateStakeRequest $request): mixed
    {
        return Response::send(
            $response = $this->service->saveStakePlan($request),
            ($response['status'] ?? false)? 'stakePage': null
        );
    }

    /**
     * Create Stake Page
     * @param \App\Http\Requests\Admin\CreateStakeRequest $request
     * @return mixed
     */
    public function updateStakePlan(CreateStakeRequest $request): mixed
    {
        return Response::send(
            $response = $this->service->updateStakePlanById($request),
            ($response['status'] ?? false)? 'stakePage': null
        );
    }

    /**
     * Edit Stake Plan Page
     * @param string $id
     * @return mixed
     */
    public function editStakePlanPage(string $id): mixed
    {
        if(!is_numeric($id))
            return Response::send(
                response: success(_t("Stake plan is invalid"))
            );

        $data['item'] = $this->service->getFullStakePlanById((int)$id, throw: true);
        $data['coins'] = Coin::activeCoins(CurrencyType::CRYPTO)->get();
        $data['coins']->map(function($coin){
            $coin->key   = $coin->uid;
            $coin->value = $coin->name;
        });
        return view('admin.stake.create-stake', $data);
    }

    /**
     * Edit Stake Plan
     * @param \App\Http\Requests\Admin\CreateStakeRequest $request
     * @return mixed
     */
    public function editStakePlan(CreateStakeRequest $request): mixed
    {
        return Response::send(
            $this->service->updateStakePlanById($request)
        );
    }

    /**
     * Delete Stake Plan
     * @param string $id
     * @return mixed
     */
    public function deleteStakePlan(string $id): mixed
    {
        return Response::send(
            $this->service->deleteStakePlan($id)
        );
    }
 
    /**
     * Change Stake Plan Status
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function changeStatusStakePlan(Request $request): mixed
    {
        return Response::send(
            $this->service->changeStatusStakePlan($request->id ?? 0)
        );
    }
}
