<?php

namespace App\Services\TableActionGeneratorService;

use App\Services\TableActionGeneratorService\GeneratorService;

class Render
{
    public function render(): GeneratorService
    {
        return new GeneratorService;
    }
}
