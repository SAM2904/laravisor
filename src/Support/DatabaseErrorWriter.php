<?php

namespace Sam\Laravisor\Support;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Throwable;

class DatabaseErrorWriter
{
    public static function write(Throwable $e): void
    {
        DB::table('laravisor_errors')->insert([
            'uuid'       => (string) Str::uuid(),
            'exception'  => get_class($e),
            'message'    => $e->getMessage(),
            'file'       => $e->getFile(),
            'line'       => $e->getLine(),
            'trace'      => json_encode($e->getTrace()),
            'created_at' => now(),
        ]);
    }

    public static function writeFromPayload(array $payload): void
    {
        DB::table('laravisor_errors')->insert([
            'uuid'       => $payload['error_id'],
            'exception'  => $payload['exception'],
            'message'    => $payload['message'],
            'created_at' => now(),
        ]);
    }
}
