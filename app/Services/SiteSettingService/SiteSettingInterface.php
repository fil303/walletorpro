<?php

namespace App\Services\SiteSettingService;

use Illuminate\Foundation\Application;

interface SiteSettingInterface
{
    /**
     * Set the site from this method services.
     *
     * @return void
     */
    public static function setAppConfigure(object $settings):void ;
    public static function loadAppService(Application $app): void;
}
