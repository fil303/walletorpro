<?php

namespace App\Models;

use App\Enums\Status;
use App\Enums\FaqPages;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory;
    protected $fillable = [
        "uid",
        "page",
        "question",
        "answer",
        "lang",
        "status",
    ];

    /**
     * Casts db value to original type
     * @var array<string, string>
     */
    protected $casts = [
        "status" => Status::class,
        "page"   => FaqPages::class,
    ];

    /**
     * Scope for active crypto buy page
     * @return \Illuminate\Support\Collection
     */
    public function scopeActiveCryptoBuyPage(): Collection
    {
        return $this->query()
            ->where('status', enum(Status::ENABLE))
            ->where('page'  , enum(FaqPages::CRYPTO_BUY))
            ->get();
    }
}
