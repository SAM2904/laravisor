<?php

namespace Sam\Laravisor\Support;

use Illuminate\Support\Facades\Http;

class PolicyClient
{
    public static function fetch(array $payload, $fingerprint = null): array
    {
        try {
            $response = Http::timeout(2)->withHeaders([
                'X-Laravisor-Key' => config('laravisor.project_key'),
            ])
                ->post(
                    rtrim(config('laravisor.server'), '/') . '/api/v1/policy',
                    [
                        'fingerprint' => $fingerprint,
                        'environment' => $payload['environment'],
                        'emails' => $payload['notify_emails'],
                    ]
                );

            return $response->json() ?? ['notify' => false];
        } catch (\Throwable $e) {
            return ['notify' => false];
        }
    }
}
