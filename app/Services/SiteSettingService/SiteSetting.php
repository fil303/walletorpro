<?php

namespace App\Services\SiteSettingService;

use Illuminate\Support\Facades\Facade;
use App\Services\SiteSettingService\SiteSettingService;

/**
 * Site Setting Facade
 * @method static void setAppConfigure($settings)
 * @method static void loadAppService($app)
 * 
 * @see SiteSettingService
 */
class SiteSetting extends Facade
{
    /**
     * Get the registered name of the site setting component.
     *
     * @return string 
     */
    protected static function getFacadeAccessor()
    {
        return SiteSettingInterface::class;
    }
}
