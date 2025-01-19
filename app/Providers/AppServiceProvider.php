<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Services\SiteSettingService\SiteSetting;
use App\Services\SiteSettingService\SiteSettingService;
use App\Services\SiteSettingService\SiteSettingInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->configSiteSetting();
        // if(env('APP_ENV') == "production")
        // URL::forceScheme('https');
		Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (isset($_REQUEST['cache']) && $_REQUEST['cache'] == "clear") {
            Cache::forget('siteSettings');
        }
        Collection::macro('toSlugValue', function () {
            $array = [];
            /** @var Collection $this */
            $this->map(function ($value) use (&$array) {
                $array[$value->slug] = $value->value;
            });
            return (Object) $array;
        });
        if(
            file_exists(storage_path('installed')) &&
            ($hasSetting = Schema::hasTable('site_settings')) && 
            !Cache::has('siteSettings')
        ){
            $settings = DB::table("site_settings")->get()->toSlugValue();
            Cache::put('siteSettings', $settings, (60 * 60));
        }
        if(isset($hasSetting) && $hasSetting)
            SiteSetting::setAppConfigure(Cache::get('siteSettings'));
        SiteSetting::loadAppService($this->app);
    }

    /**
     * Start Config The App.
     */
    private function configSiteSetting():void
    {
        $this->app->bind(SiteSettingInterface::class,function() {
            return new SiteSettingService();
        });
    }
}
