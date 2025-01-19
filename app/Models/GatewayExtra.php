<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GatewayExtra extends Model
{
    use HasFactory;
    protected $fillable = [
        "payment_gateway_uid",
        "title",
        "slug",
        "value",
        "type",
        "required",
        "readonly",
    ];
}
