<?php

use App\Models\SiteSettings;

if (!function_exists('GlobalSiteSettings')) {
    function GlobalSiteSettings()
    {
        return SiteSettings::first();
    }
}
