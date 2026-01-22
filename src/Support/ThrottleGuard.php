<?php

namespace Sam\Laravisor\Support;

use Illuminate\Support\Facades\Cache;

class ThrottleGuard
{
    public static function shouldNotify(string $fingerprint): bool
    {
        if (!config('laravisor.throttle.enabled')) {
            return true;
        }

        $key = "laravisor:throttle:{$fingerprint}";
        $window = config('laravisor.throttle.window_seconds', 300);

        if (Cache::has($key)) {
            // Cache::forget($key);
            return false;
        }

        Cache::put($key, true, $window);
        return true;
    }
}
