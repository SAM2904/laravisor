<?php

namespace Sam\Laravisor\Support;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class Notifier
{
    /**
     * Send notification based on policy
     * NEVER throws exception
     */
    public static function send(array $payload): void
    {
        try {
            if (empty($payload['notify_emails'])) {
                return;
            }

            $content = $payload;
            $subject = Str::limit($payload['message'], 120);

            // if (config('laravisor.queue_notifications')) {}

            Mail::send(
                'laravisor::emails.exception',
                ['content' => $content],
                function ($m) use ($payload, $subject) {
                    $env = strtoupper($payload['environment'] ?? 'UNKNOWN');

                    $m->to($payload['notify_emails'])->subject("[Laravisor][$env] {$subject}");
                }
            );
        } catch (Throwable $ignored) {
            // NEVER break client app
        }
    }
}
