<?php

namespace App\Models;

use App\Enums\FileDestination;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "image",
        "feedback",
        "status",
    ];

    public function getImage(): string
    {
        return $this->image
            ? asset_bind($this->image)
            : asset_bind(Storage::url("profile/user.png"));
    }
}
