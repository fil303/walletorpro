<?php

namespace App\Services\PaginationService;

use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class PaginationService
{
    private int $size = 20;
    public function __construct(){}

    /**
     * Set Size
     * @param int $size
     * @return void
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * Paginate
     * @param \Illuminate\Database\Query\Builder $builder
     * @param mixed $data
     * @param int $page
     * @param int $offset
     * @return \Illuminate\Support\Collection
     */
    public function paginate(
        Builder $builder,
        mixed $data,
        int $page = 1,
        int $offset = null
    ):  Collection
    {
        $response = [
            "total"        => 100,
            "size"         => $this->size,
            "to_offset"    => 0,
            "from_offset"  => $this->size,
            "last_page"    => 100,
            "current_page" => 100,
            "data"         => [$data, $builder->get()],
        ];
        $builder = $builder->where("coin", "BTC");
        return $builder->get();
    }

}
