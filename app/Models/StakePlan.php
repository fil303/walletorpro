<?php

namespace App\Models;

use App\Models\Coin;
use App\Models\StakeSegment;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StakePlan extends Model
{
    use HasFactory;
    protected $fillable = [
        "coin_id",
        "coin",
        "min",
        "max",
        "status",
    ];

    public function scopeActivePlan(Builder $builder): Builder|QueryBuilder
    {
        return $builder
            ->when(isset($GLOBALS['stake_status_scope']), function($q){
                return $q->where("status", $GLOBALS['stake_status_scope']);
            });
    }
    public function scopeActivePlanWithSegment(Builder $builder): Builder|QueryBuilder
    {
        return $builder
            ->when(isset($GLOBALS['stake_status_scope']), function($q){
                return $q->where("status", $GLOBALS['stake_status_scope']);
            })->with('segments');
    }
    public function segments(): HasMany
    {
        return $this->hasMany(StakeSegment::class, "stake_plan_id");
    }
  
    public function plan_coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class, "coin_id");
    }
}
