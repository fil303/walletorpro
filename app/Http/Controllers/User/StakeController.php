<?php

namespace App\Http\Controllers\User;

use App\Models\Coin;
use App\Enums\Status;
use App\Models\Stake;
use App\Models\StakePlan;
use App\Enums\CurrencyType;
use App\Facades\ResponseFacade;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\ResponseService\Response;
use App\Services\WalletService\WalletService;
use App\Http\Requests\User\SubmitStakeRequest;
use App\Services\StakeService\AppStakeService;

class StakeController extends Controller
{
    public function __construct(protected AppStakeService $service){}

    /**
     * View Stake Page
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function userStakePage(Request $request): mixed
    {
        if(IS_API_REQUEST){
            $perPage = (isset($request->per_page) && is_numeric($request->per_page))? $request->per_page: 10;

            $stakePlan =
            StakePlan::where("status", Status::ENABLE->value)
                ->with(['segments', 'plan_coin'])
                ->whereHas('segments', function ($query) use($request) {
                    return $query->when(isset($request->duration),function ($query) use($request) {
                        return $query->where('duration', $request->duration);
                    });
                })
                ->when(isset($request->coin),function ($query) use($request) {
                    return $query->where('coin', $request->coin);
                })
                ->when(isset($request->min) && is_numeric($request->min),function ($query) use($request) {
                    return $query->where('min', ">=", $request->min);
                })
                ->paginate($perPage)->onEachSide(1);

            $stakePlan->map(function($item){
                $html = view('user.stake.components.stake_plan_card', ['plan' => $item]);
                
                if ($html instanceof View){
                    $item->html = $html->render();
                }
            });

            return $stakePlan;
        }

        $data['coins'] = Coin::activeCoins(CurrencyType::CRYPTO)->get();
        $data['coins']->map(function($coin){
            $coin->key   = $coin->coin;
            $coin->value = $coin->coin;
        });
        return view("user.stake.stake", $data);
    }

    /**
     * View Stake History Page
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function stakingHistoryPage(Request $request): mixed
    {
        if(IS_API_REQUEST){
            $perPage = (isset($request->per_page) && is_numeric($request->per_page))? $request->per_page: 10;

            $stakePlan =
            Stake::where('user_id', Auth::id())->with('plan_coin')
                ->when(isset($request->coin),function ($query) use($request) {
                    return $query->where('coin', $request->coin);
                })
                ->when(isset($request->search),function ($query) use($request) {
                    return $query->where(function($q)use($request){
                        return $q->where('amount',   "LIKE", "%$request->search%")
                        ->orWhere('interest', "LIKE", "%$request->search%")
                        ->orWhere('created_at', "LIKE", "%$request->search%")
                        ->orWhere('end_at', "LIKE", "%$request->search%")
                        ->orWhere('status', "LIKE", "%$request->search%");
                    });
                })
                ->orderBy('id', 'DESC')->paginate($perPage)->onEachSide(1);

            $stakePlan->map(function($item){
                $html =  view('user.stake.components.stake_row', ['plan' => $item]);

                if ($html instanceof View){
                    $item->html = $html->render();
                }
            });

            return $stakePlan;
        }
        $data['coins'] = Coin::activeCoins(CurrencyType::CRYPTO)->get();
        $data['coins']->map(function($coin){
            $coin->key   = $coin->coin;
            $coin->value = $coin->coin;
        });
        return view("user.stake.index", $data);
    }

    /**
     * View Stake Details Page
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function userOpenStake(Request $request): mixed
    {
        return Response::send(
            $this->service->getStakePreSubmitDetails($request->id ?? 0)
        );
    }

    /**
     * Submit Stake
     * @param \App\Http\Requests\User\SubmitStakeRequest $request
     * @return mixed
     */
    public function userSubmitStake(SubmitStakeRequest $request): mixed
    {
        return Response::send(
            $this->service->stake($request)
        );
    }

    /**
     * Submit Stake
     * @param \App\Http\Requests\User\SubmitStakeRequest $request
     * @return mixed
     */
    public function stopAutoStake(Request $request): mixed
    {
        return ResponseFacade::result(
            $this->service->stopAutoStake($request)
        )->send();
    }
}