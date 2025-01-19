<?php

namespace App\Services\StakeService;

use App\Models\Stake;
use App\Models\StakePlan;
use App\Models\StakeSegment;
use Illuminate\Http\Request;
use App\Http\Requests\User\SubmitStakeRequest;
use App\Http\Requests\Admin\CreateStakeRequest;

interface AppStakeService{

    /**
     * getStakePlan function to get Stake Plan.
     *
     * @return ?StakePlan
     */
    public static function getStakePlan(): ?StakePlan;

    /**
     * stake function to start staking.
     *
     * @param SubmitStakeRequest $request
     * @return array
     */
    public function stake(SubmitStakeRequest $request): array;

    /**
     * Get Stake Plan By Id
     * @param int $id
     * @param bool $throw
     * @param ?string $redirect
     * @return ?StakePlan
     */
    public function getStakePlanById(int $id, bool $throw = false, ?string $redirect = null): ?StakePlan;

    /**
     * Get Full Stake Plan By Id
     * @param int $id
     * @param bool $throw
     * @param ?string $redirect
     * @return ?StakePlan
     */
    public function getFullStakePlanById(int $id, bool $throw = false, ?string $redirect = null): ?StakePlan;

    /**
     * getStakePreSubmitDetails function to get Stake Plan details before start staking.
     *
     * @param int $stake_id
     * @param bool $return_html
     * 
     * @return array
     */
    public function getStakePreSubmitDetails(int $stake_id, bool $return_html = true): array;

    /**
     * saveStakePlan function to create new Stake Plan.
     *
     * @param CreateStakeRequest $request
     * @return array
     */
    public function saveStakePlan(CreateStakeRequest $request): array;

    /**
     * updateStakePlanById function to update Stake Plan by id.
     *
     * @param CreateStakeRequest $request
     * @return array
     */
    public function updateStakePlanById(CreateStakeRequest $request): array;

    /**
     * deleteStakePlan function to delete Stake Plan.
     *
     * @param string $id
     * @return array
     */
    public function deleteStakePlan(string $id): array;

    /**
     * changeStatusStakePlan function to change status of Stake Plan.
     *
     * @param string $id
     * @return array
     */
    public function changeStatusStakePlan(string $id): array;

    /**
     * runStakingJob function to run staking in background (Cron Job).
     *
     * @return void
     */
    public function runStakingJob(): void;

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
    ):  ?StakeSegment;

    /**
     * Stop Auto Stake
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function stopAutoStake(Request $request): array;

    /**
     * autoStake function to start staking if current staking done and auto status enable.
     *
     * @return void
     */
    public function autoStake(Stake $stake): void;
}