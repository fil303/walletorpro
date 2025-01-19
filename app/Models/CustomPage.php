<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomPage extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'title',
        'slug',
        'order',
        'content',
        'status',
    ];

        /**
     * Casts db value to original type
     * @var array<string, string>
     */
    protected $casts = [
        "status" => Status::class,
    ];
}
