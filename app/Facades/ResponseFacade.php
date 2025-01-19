<?php

namespace App\Facades;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Facade;
use App\Services\ResponseService\ResponseService;

/**
 * This facade has response functionality
 * 
 * @method static JsonResponse|RedirectResponse|View send()
 * @method static void throw()
 * @method static ResponseService result(array $result)
 * @method static ResponseService next(string $route)
 * @method static ResponseService back(string $route)
 * @method static ResponseService query(array $query)
 * @method static ResponseService success(mixed $messageOrData = null, mixed $data = [], array $topLevelData = [])
 * @method static ResponseService failed(mixed $messageOrData = null, mixed $data = [], array $topLevelData = [])
 * 
 * @see ResponseService
 */
class ResponseFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "response_facade";
    }

}
