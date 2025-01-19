<?php

namespace App\Services\SettingService;

use Exception;
use App\Facades\FileFacade;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Enums\FileDestination;
use App\Models\LandingSetting;
use Illuminate\Support\Facades\Cache;
use App\Services\SettingService\AppSettingService;

class SettingService implements AppSettingService
{
    public function __construct(){}

    /**
     * Save Settings
     * @param array<string, string> $data
     * @return array
     */
    public function saveSettings(array $data): array
    {
       try {
            foreach( $data as $key => $value ) {
                SiteSetting::updateOrCreate(["slug" => $key],["value" => $value]);
            }
            $this->clearCacheSetting();
            return success(_t("Setting updated successfully"));
       } catch (Exception $e) {
            $this->clearCacheSetting();
            logStore("SettingService saveSettings", $e->getMessage());
            return failed(_t("Error : "). $e->getMessage());
       }
    }

    /**
     * Save Landing Settings
     * @param array<string> $data
     * @return array
     */
    public function saveLandingSettings(array $data):array
    {
       try {
            foreach( $data as $key => $value ) {
                LandingSetting::updateOrCreate(["slug" => $key],["value" => $value]);
            }
            return success(_t("Landing setting updated successfully"));
       } catch (Exception $e) {
            logStore("SettingService saveLandingSettings", $e->getMessage());
            return failed(_t("Error : "). $e->getMessage());
       }
    }

    /**
     * Clear Setting Cache
     * @return bool
     */
    public function clearCacheSetting():bool
    {
        if(Cache::has('siteSettings'))
        Cache::forget('siteSettings');
        return true;
    }

    /**
     * Update Logo
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function updateLogo(Request $request): array
    {
        $logo = get_settings("app_logo") ?? "";
        $fav  = get_settings("app_fav") ?? "";

        // App Logo
        if($request->hasFile('logo')){
            $file = $request->file('logo');

            if(filled($logo))
                FileFacade::removePublicFile($logo);

            $image = FileFacade::saveImage(
                file: $file,
                destination: FileDestination::APP_LOGO_PATH,
                prefix: "",
                name: "app-logo"
            );

            if(filled($image)){
                $res = $this->saveSettings([ "app_logo" => $image ]);
            }
        }

        // App Favicon
        if($request->hasFile('fav')){
            $file = $request->file('fav');

            if(filled($fav))
                FileFacade::removePublicFile($fav);

            $image = FileFacade::saveImage(
                file: $file,
                destination: FileDestination::APP_LOGO_PATH,
                prefix: "",
                name: "app-favicon"
            );

            if(filled($image)){
                $res = $this->saveSettings([ "app_fav" => $image ]);
            }
        }

        return success(__("Logo setting updated successfully"));
    }
}
