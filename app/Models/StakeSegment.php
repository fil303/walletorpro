<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StakeSegment extends Model
{
    use HasFactory;
    protected $fillable = [
        "stake_plan_id",
        "duration",
        "interest",
    ];
}
