<?php

namespace App\Services\TableActionGeneratorService;

use App\Models\Coin;
use App\Services\TableActionGeneratorService\GeneratorService;

interface Generator
{
    public static function getInstance(mixed $item): Generator;
    public function set(mixed $item): self;
    public function render(): GeneratorService;
    public function button(bool $subClass = true):string;
    public function option(bool $subClass = true):string;
}
