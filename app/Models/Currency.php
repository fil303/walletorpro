<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "code",
        "symbol",
        "rate",
        "status",
        "primary",
    ];

    public function scopeActiveCurrency(): Builder|QueryBuilder
    {
        return $this->query()
            ->where('status', Status::ENABLE->value);
    }
}
