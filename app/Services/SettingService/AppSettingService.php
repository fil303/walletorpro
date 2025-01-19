<?php

namespace App\Services\SettingService;

use Illuminate\Http\Request;

interface AppSettingService
{
    /**
     * Save Settings
     * @param array<string, string> $data
     * @return array
     */
    public function saveSettings(array $data):array;

    /**
     * Clear Setting Cache
     * @return bool
     */
    public function clearCacheSetting():bool;

    /**
     * Update Logo
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function updateLogo(Request $request): array;

    /**
     * Save Landing Settings
     * @param array<string> $data
     * @return array
     */
    public function saveLandingSettings(array $data):array;
}
