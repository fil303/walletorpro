<?php
namespace App\Services\StakeService;

use Exception;
use App\Models\Coin;
use App\Models\User;
use App\Models\Stake;
use App\Models\StakePlan;
use App\Enums\StakingStatus;
use App\Jobs\AutoStakingJob;
use App\Models\StakeSegment;
use Illuminate\Http\Request;
use App\Mail\CoinStakingStart;
use Illuminate\Support\Carbon;
use App\Facades\ResponseFacade;
use App\Mail\CoinStakingSuccess;
use App\Mail\CoinStakingAutoStart;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Services\CoinService\CoinService;
use App\Services\ResponseService\Response;
use App\Services\WalletService\WalletService;
use App\Http\Requests\User\SubmitStakeRequest;
use App\Services\StakeService\AppStakeService;
use App\Http\Requests\Admin\CreateStakeRequest;
use App\Services\WalletService\WalletServiceTrait;
use App\Jobs\Sms\CoinStakingStart as SendSMSCoinStakingStart;
use App\Jobs\Sms\CoinStakingComplete as SendSMSCoinStakingSuccess;
use App\Jobs\Sms\CoinStakingAutoStart as SendSMSCoinStakingAutoStart;

class StakeService implements AppStakeService
{
    use WalletServiceTrait;
    public static ?StakePlan $stakePlan;
    public static ?StakeSegment $stakeSegment;

    /**
     * getStakePlan function to get Stake Plan.
     *
     * @return ?StakePlan
     */
    public static function getStakePlan(): ?StakePlan
    {
        return self::$stakePlan ? self::$stakePlan : null;
    }

    /**
     * getStakeSegment function to get Stake Segment.
     *
     * @return ?StakeSegment
     */
    public static function getStakeSegment(): ?StakeSegment
    {
        return self::$stakeSegment ? self::$stakeSegment : null;
    }

    /**
     * getStakePlanById function to get Stake Plan by id.
     *
     * @param int $id
     * @param bool $throw
     * @param string $redirect
     * @return ?StakePlan
     */
    public function getStakePlanById(
        int $id,
        $throw    = false,
        $redirect = null
    ):  ?StakePlan
    {
        if(!self::$stakePlan = StakePlan::find($id)){
            if($throw) Response::throw(
                failed(_t("Stake plan not found")),
                $redirect
            );
        }
        return self::getStakePlan();
    }

    /**
     * getStakeSegmentById function to get Stake Segment by id.
     *
     * @param int $id
     * @param bool $throw
     * @param string $redirect
     * @return ?StakeSegment
     */
    public function getStakeSegmentById(
        int $id,
        $throw    = false,
        $redirect = null
    ):  ?StakeSegment
    {
        if(!self::$stakeSegment = StakeSegment::find($id)){
            if($throw) Response::throw(
                failed(_t("Stake duration segment not found")),
                $redirect
            );
        }
        return self::getStakeSegment();
    }
    
    /**
     * getFullStakePlanById function to get Stake Segment by id.
     *
     * @param int $id
     * @param bool $throw
     * @param string $redirect
     * @return ?StakePlan
     */
    public function getFullStakePlanById(
        int $id,
        $throw    = false,
        $redirect = null
    ):  ?StakePlan
    {
        if(!self::$stakePlan = StakePlan::where('id', $id)->with(['segments','plan_coin'])->first()){
            if($throw) Response::throw(
                failed(_t("Stake plan not found")),
                $redirect
            );
        }
        return self::getStakePlan();
    }

    /**
     * saveStakePlan function to create new Stake Plan.
     *
     * @param CreateStakeRequest $request
     * @return array
     */
    public function saveStakePlan(CreateStakeRequest $request): array
    {
        $findCoin = safe_code(fn() => CoinService::getCoinByUid($request->coin) );
        if(!is_success($findCoin)) ResponseFacade::failed(_t("Coin not found"))->throw();
        /** @var Coin $coin */
        $coin = $findCoin['data']['result'] ?? null;

        $stakePlane = [
            "coin_id"  => $coin->id,
            "coin"     => $coin->coin,
            "min"      => $request->min,
            "max"      => $request->max,
            "status"   => $request->status
        ];
        $stakeSegments = [];
        if(isset($request->duration[0])){
            $size = count($request->duration) - 1;
            for($i = 0; $i <= $size; $i++) {
                $stakeSegments[] = [
                    "duration" => $request->duration[$i] ?? 0,
                    "interest" => $request->interest[$i] ?? 0,
                ];
            }
        }

        if($this->createStackPlanWithSegment($stakePlane, $stakeSegments))
            return success(_t("Stake plan created successfully"));
        return failed(_t("Stake plan failed to create"));
    }
    
    /**
     * updateStakePlanById function to update Stake Plan by id.
     *
     * @param CreateStakeRequest $request
     * @return array
     */
    public function updateStakePlanById(CreateStakeRequest $request): array
    {
        /** @var StakePlan $stakePlan */
        $stakePlan = StakePlan::with('plan_coin')->find($request->id);

        /** @var ?Coin $coin */
        $coin = $stakePlan->plan_coin ?? null;
        if(!$coin) ResponseFacade::failed(_t("Coin not found"))->throw();

        $stakePlane = [
            "coin_id"  => $coin->id ?? 0,
            "coin"     => $coin->coin ?? '',
            "min"      => $request->min,
            "max"      => $request->max,
            "status"   => $request->status
        ];

        $stakeSegments = [];
        if(isset($request->duration[0])){
            $size = count($request->duration) - 1;
            for($i = 0; $i <= $size; $i++) {
                $stakeSegments[] = [
                    "duration" => $request->duration[$i] ?? 0,
                    "interest" => $request->interest[$i] ?? 0,
                ];
            }
        }
        DB::beginTransaction();
        try {
            $oldSegments = StakeSegment::where('stake_plan_id', $stakePlan->id);

            if(
                $oldSegments->delete() &&
                $stakePlan->update($stakePlane) &&
                $this->createSegments($stakePlan->id, $stakeSegments)
            )  {
                DB::commit();
                return success(_t("Stake plan updated successfully"));
            }
            return failed(_t("Stake plan failed to update"));
        } catch (Exception $e) {
            DB::rollBack();
            logStore("updateStakePlanById", $e->getMessage());
            return failed(_t("Stake plan failed to update"));
        }
    }


    /**
     * deleteStakePlan function to delete Stake Plan.
     *
     * @param string $id
     * @return array
     */
    public function deleteStakePlan(string $id): array
    {
        if(!is_numeric($id))
            return success(_t("Stake plan is invalid"));

        /**  @var StakePlan $stakePlan */
        $stakePlan = $this->getStakePlanById((int) $id, throw: true);
        if($stakePlan->delete()) return success(_t("Stake plan deleted successfully"));
        return success(_t("Stake plan failed to delete"));
    }
    
    /**
     * changeStatusStakePlan function to change status of Stake Plan.
     *
     * @param string $id
     * @return array
     */
    public function changeStatusStakePlan(string $id): array
    {
        if(!is_numeric($id))
            return success(_t("Stake plan is invalid"));

        /**  @var StakePlan $stakePlan */
        $stakePlan = $this->getStakePlanById((int) $id, throw: true);
        $stakePlan->status = !$stakePlan->status;
        if($stakePlan->save()) return success(_t("Stake plan status update"));
        return success(_t("Stake plan failed to update status"));
    }

    /**
     * stake function to start staking.
     *
     * @param SubmitStakeRequest $request
     * @return array
     */
    public function stake(SubmitStakeRequest $request): array
    {
        $this->checkCoinStakePlanSegment($request);

        /**  @var StakePlan $stakePlan */
        $stakePlan = self::$stakePlan;
        
        /**  @var StakeSegment $stakeSegment */
        $stakeSegment = self::$stakeSegment;

        if($stakePlan->id !== $stakeSegment->stake_plan_id)
            return failed(_t('Invalid stake plan or duration'));

        if($stakePlan->min > $request->amount)
            return failed(_t("Staking minimum amount :min :coin", ["coin" => $stakePlan->coin, "min" => $stakePlan->min]));
        
        if($stakePlan->max < $request->amount)
            return failed(_t("Staking maximum amount :max :coin", ["coin" => $stakePlan->coin, "max" => $stakePlan->max]));

        $walletCheckResponse = WalletService::checkWalletBalanceOrThrow(
            amount: $request->amount,
            wallet: WalletService::getAuthUserWallet(
                coin   : CoinService::$coin->coin ?? "", 
                user_id: $request->user_id ?? null // StakeJob will send user_id and null for user side
            ),
        );

        if(!is_success($walletCheckResponse))
            return failed(_t("Wallet dose not have enough balance to staking"));

        $wallet = $walletCheckResponse['data'][0] ?? null;
        if(!$user = User::find($wallet->user_id ?? 0))
            return failed(_t("User Not Found"));

        try{
            DB::beginTransaction();
            $stake = $this->saveStake($request);
            if(
                $stake &&
                $this->decrementBalance($request->amount)
            ){
                DB::commit();
                Mail::to($user)->queue(new CoinStakingStart($user, $stake));
                SendSMSCoinStakingStart::dispatch($user, $stake)->onQueue("high");
                return success(_t("Staking successfully"));
            }
            return failed(_t("Staking failed"));
        } catch (Exception $e) {
            DB::rollBack();
            logStore("stake", $e->getMessage());
            return failed(_t("Staking failed"));
        }
    }

    /**
     * getStakePreSubmitDetails function to get Stake Plan details before start staking.
     *
     * @param int $stake_id
     * @param bool $return_html
     * 
     * @return array
     */
    public function getStakePreSubmitDetails(int $stake_id, bool $return_html = true): array
    {
        /**  @var StakePlan $stakePlan */
        $stakePlan =
        $this->getFullStakePlanById(
            $stake_id, 
            throw: true
        );

        $data['stake'] = $stakePlan;
        $data['coin']  = Coin::find($stakePlan->coin_id);
        $data['wallet']= WalletService::createAndGetUserWallet(
            $stakePlan->coin, 
            $createIfNotFound = true, 
            throw: true
        );
        
        if($return_html) {
            $data['html'] = view('user.stake.components.stake_modal', $data);
                
            if ($data['html'] instanceof View){
                $data['html'] = $data['html']->render();
            }
        }

        return success(_t('Stack details found successfully'), $data);
    }

    /**
     * runStakingJob function to run staking in background (Cron Job).
     *
     * @return void
     */
    public function runStakingJob(): void
    {
        $stakingList = Stake::where('status', StakingStatus::IMMATURE->value)->get();

        foreach ($stakingList as $staking) {
            $end_at = Carbon::createFromFormat('Y-m-d H:i:s', $staking->end_at);
            if (Carbon::now()->gte($end_at)) {
                DB::beginTransaction();
                try {
                    $wallet = WalletService::getAuthUserWallet(
                        $staking->coin,
                        $staking->user_id
                    );

                    if($staking->auto_stake){
                        dispatch(new AutoStakingJob($staking))->onQueue('high');
                        // $this->autoStake($staking);
                    }

                    if($wallet && $this->incrementBalance($staking->amount + $staking->interest)){
                        if(!$user = User::find($staking->user_id)) die("StakingJob User not found");
                        $staking->status = StakingStatus::MATURE->value;
                        $staking->save();
                        DB::commit();
                        Mail::to($user)->send(new CoinStakingSuccess($user, $staking));
                        SendSMSCoinStakingSuccess::dispatch($user, $staking)->onQueue("high");
                        if($staking->auto_stake){
                            Mail::to($user)->send(new CoinStakingAutoStart($user, $staking));
                            SendSMSCoinStakingAutoStart::dispatch($user, $staking)->onQueue("high");
                        }
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logStore("runStakingJob service", $e->getMessage(). $e->getTraceAsString());
                }
            }
        }
    }

    /**
     * autoStake function to start staking if current staking done and auto status enable.
     *
     * @return void
     */
    public function autoStake(Stake $stake): void
    {
        $request = new SubmitStakeRequest([
            "plan"    => $stake->stake_plan_id,
            "amount"  => $stake->amount,
            "segment" => $stake->stake_segment_id,
            "auto"    => true,
            "user_id" => $stake->user_id,
            "auto_mail" => true,
        ]);
        logStore("auto staking request prepared");

        $response = $this->stake($request);
        logStore("rsp auto staking",$response);
    }

    /**
     * createStackPlanWithSegment function to create staking plan and segments.
     *
     * @param array<string, string> $newStackPlaneData
     * @param array<int, array<string, string>> $segments
     * @return ?StakePlan
     */
    protected function createStackPlanWithSegment(
        array $newStackPlaneData,
        array $segments
    ):  ?StakePlan
    {
        try{
            DB::beginTransaction();
            if(
                ($stakePlan = StakePlan::create($newStackPlaneData)) &&
                $segments &&
                $this->createSegments($stakePlan->id, $segments)
            ){
                DB::commit();
                return $stakePlan;
            }
            return null;
        } catch (Exception $e){
            DB::rollBack();
            logStore("createStackPlanWithSegment", $e->getMessage());
            return null;
        }
    }

    /**
     * Create New Stake Plan Segments
     * @param int $stakePlanId
     * @param array<int, array<string>> $segments
     * @return bool
     */
    protected function createSegments(int $stakePlanId, array $segments): bool
    {
        try{
            foreach($segments as $segment){
                $segment['stake_plan_id'] =$stakePlanId;
                if(!StakeSegment::create($segment)) return false;
            }
            return true;
        } catch (Exception $e){
            DB::rollBack();
            logStore("createSegments", $e->getMessage());
            return false;
        }
    }

    /**
     * updateStakePlan function to update staking plan.
     *
     * @param array<string, string> $newStackPlaneData
     * @return ?StakePlan
     */
    protected function updateStakePlan(array $newStackPlaneData): ?StakePlan
    {
        try{
            return StakePlan::create($newStackPlaneData);
        } catch (Exception $e){
            logStore("updateStakePlan", $e->getMessage());
            return null;
        }
    }

    /**
     * checkCoinStakePlanSegment function to check stake plan has segments.
     *
     * @param SubmitStakeRequest $request
     * @return void
     */
    protected function checkCoinStakePlanSegment(SubmitStakeRequest $request): void
    {
        /** @var StakePlan $stakePlan */
        $stakePlan = $this->getStakePlanById(
            $request->plan,
            throw: true
        );

        $this->getStakeSegmentById(
            $request->segment,
            throw: true
        );

        CoinService::getCoinByCoin(
            $stakePlan->coin,
            throw: true
        );
    }

    /**
     * saveStake function to save stake plan.
     *
     * @param SubmitStakeRequest $request
     * @return ?Stake
     */
    protected function saveStake(SubmitStakeRequest $request): ?Stake
    {
        /** @var Coin $coin */
        $coin = CoinService::$coin;

        /** @var StakePlan $stakePlan */
        $stakePlan = self::$stakePlan;
        
        /** @var StakeSegment $stakeSegment */
        $stakeSegment = self::$stakeSegment;

        $stakeData = [
            "user_id"          => $request->user_id ?? Auth::id(),
            "coin_id"          => $coin->id,
            "stake_plan_id"    => $stakePlan->id,
            "stake_segment_id" => $stakeSegment->id,
            "coin"             => $coin->coin,
            "duration"         => $stakeSegment->duration,
            "interest"         => $stakeSegment->interest,
            "amount"           => $request->amount,
            "interest_amount"  => return_number(fn() => ($request->amount / 100) * $stakeSegment->interest ),
            "auto_stake"       => isset($request->auto),
            "end_at"           => Carbon::now()->addDays($stakeSegment->duration ?? 0),
        ];

        try {
            return Stake::create($stakeData);
        } catch (Exception $e) {
            logStore("saveStake service", $e->getMessage());
            return null;
        }
    }

    /**
     * Stop Auto Stake
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function stopAutoStake(Request $request): array
    {
        if(
            !$stake = Stake::where('id', $request->id)
            ->where('user_id', Auth::id())
            ->where('status', 'Immature')->first()
        ) return failed(_t("Staking not found"));

        $stake->auto_stake = !$stake->auto_stake;

        if($stake->save()) return success(_t("Auto Staking status updated successfully"));
        return failed(_t("Auto Staking status update failed"));
    }
}