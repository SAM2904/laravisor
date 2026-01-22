<?php

namespace Sam\Laravisor\Support;

use Illuminate\Support\Facades\Schema;

class StorageDetector
{
    public static function canStore(): bool
    {
        try {
            return Schema::hasTable('laravisor_errors');
        } catch (\Throwable $e) {
            return false;
        }
    }
}
