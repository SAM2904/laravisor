<?php

namespace Sam\Laravisor\Support;

use Throwable;
use Illuminate\Support\Str;

class PayloadBuilder
{
    public static function build(Throwable $e): array
    {
        return [
            'error_id'    => (string) Str::uuid(),
            'environment' => app()->environment(),

            // Exception core
            'message'   => $e->getMessage(),
            'exception' => get_class($e),
            'file'      => $e->getFile(),
            'line'      => $e->getLine(),
            'trace'     => self::safeTrace($e),

            // Request context (SAFE)
            'url'  => self::requestUrl(),
            'body' => self::requestBody(),
            'ip'   => self::requestIp(),

            'occurred_at' => now()->toISOString(),

            // Optional
            'view_url' => null,

            // Notification intent
            'notify_emails' => config('laravisor.notify_emails'),

            // Extra context
            'context' => [
                'user_id' => optional(auth())->id(),
            ],
        ];
    }

    /**
     * Limit & sanitize stack trace
     */
    protected static function safeTrace(Throwable $e): array
    {
        return collect($e->getTrace())
            ->take(15) // 🔒 prevent huge payloads
            ->map(fn($t) => [
                'file'     => $t['file'] ?? null,
                'line'     => $t['line'] ?? null,
                'function' => $t['function'] ?? null,
                'class'    => $t['class'] ?? null,
            ])
            ->toArray();
    }

    protected static function requestUrl(): ?string
    {
        try {
            return request()->fullUrl();
        } catch (\Throwable) {
            return null;
        }
    }

    protected static function requestBody(): array
    {
        try {
            return request()->except(['password', 'password_confirmation', 'token']);
        } catch (\Throwable) {
            return [];
        }
    }

    protected static function requestIp(): ?string
    {
        try {
            return request()->ip();
        } catch (\Throwable) {
            return null;
        }
    }
}
