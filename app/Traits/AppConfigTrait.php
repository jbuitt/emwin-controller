<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Models\AppConfig;

/**
 * Trait AppConfigTrait
 *
 * @package App
 */
trait AppConfigTrait
{
    /**
     * Gets a value from the App Config table
     *
     * @return mixed
     */
    public function getAppConfigValue($variable, $default = ''): mixed
    {
        // Check to make sure the app_configs table exists
        if (!Schema::hasTable('app_configs')) {
            Log::error("The 'app_configs' table has not been initialized. Please run 'artisan migrate'.");
            return $default;
        }
        if (AppConfig::count() === 0) {
            return $default;
        }
        return AppConfig::first()->jsondata->$variable ?? $default;
    }

    /**
     * Sets a value in the App Config table
     *
     * @return void
     */
    public function setAppConfigValue($variable, $value): void
    {
        if (!Schema::hasTable('app_configs')) {
            Log::error("The 'app_configs' table has not been initialized. Please run 'artisan migrate'.");
            return;
        }
        if (AppConfig::count() === 0) {
            AppConfig::create([
                'jsondata' => json_encode([$variable => $value]),
            ]);
        } else {
            $appConfig = AppConfig::first();
            $appConfig->update([
                'jsondata->' . $variable => $value,
            ]);
        }
    }

}
