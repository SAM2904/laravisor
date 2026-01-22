<?php

namespace Sam\Laravisor\Support;

class ErrorFingerprint
{
    public static function make(array $payload): string
    {
        return sha1(
            ($payload['exception'] ?? '') .
                ($payload['message'] ?? '') .
                ($payload['file'] ?? '') .
                ($payload['line'] ?? '') .
                ($payload['environment'] ?? '')
        );
    }
}
