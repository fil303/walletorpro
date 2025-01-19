<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentGateway extends Model
{
    use HasFactory;
    protected $fillable = [
        "uid",
        "title",
        "slug",
        "icon",
        "status"
    ];

    public function scopeByCurrency(Builder $builder, string $currency): Builder|QueryBuilder
    {
        return $builder
            ->join("gateway_currencies", "gateway_currencies.payment_gateway_uid", "=", "payment_gateways.uid")
            ->where("gateway_currencies.currency_code", "=", $currency)
            ->where("payment_gateways.status", "=", enum(Status::ENABLE))
            ->select("payment_gateways.*");
    }

    public function scopeFirstByUidAndCurrency(Builder $builder, string $uid, string $currency): Builder|QueryBuilder
    {
        return $builder
            ->join("gateway_currencies", "gateway_currencies.payment_gateway_uid", "=", "payment_gateways.uid")
            ->where("payment_gateways.uid", "=", $uid)
            ->where("gateway_currencies.currency_code", "=", $currency)
            ->select("payment_gateways.*", "gateway_currencies.payment_gateway_uid","gateway_currencies.currency_code","gateway_currencies.min_amount","gateway_currencies.max_amount","gateway_currencies.fees","gateway_currencies.fees_type");
    }

    public function scopeFirstByUid(Builder $builder, string $uid): Builder|QueryBuilder
    {
        return $builder
            ->join("gateway_currencies", "gateway_currencies.payment_gateway_uid", "=", "payment_gateways.uid")
            ->where("payment_gateways.uid", "=", $uid)
            ->select("payment_gateways.*", "gateway_currencies.payment_gateway_uid","gateway_currencies.currency_code","gateway_currencies.min_amount","gateway_currencies.max_amount","gateway_currencies.fees","gateway_currencies.fees_type");
    }
    
    public function scopeGetAll(Builder $builder): Builder|QueryBuilder
    {
        return $builder
            ->join("gateway_currencies", "gateway_currencies.payment_gateway_uid", "=", "payment_gateways.uid")
            ->where("payment_gateways.status", "=", enum(Status::ENABLE))
            ->select("payment_gateways.*", "gateway_currencies.payment_gateway_uid","gateway_currencies.currency_code","gateway_currencies.min_amount","gateway_currencies.max_amount","gateway_currencies.fees","gateway_currencies.fees_type");
    }
}
