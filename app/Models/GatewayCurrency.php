<?php

namespace App\Models;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GatewayCurrency extends Model
{
    use HasFactory;

    /**
     * Fillable property for this model
     * @var array<int, string>
     */
    protected $fillable = [
        "payment_gateway_uid",
        "currency_code",
        "min_amount",
        "max_amount",
        "fees",
        "fees_type",
    ];

    /**
     * Currency Relation from gateway currency model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, "currency_code", "code");
    }
}
