<?php

namespace Sam\Laravisor\Exception;

use Illuminate\Support\Facades\Log;
use Throwable;
use Sam\Laravisor\Support\DatabaseErrorWriter;
use Sam\Laravisor\Support\Notifier;
use Sam\Laravisor\Support\PayloadBuilder;
use Sam\Laravisor\Support\StorageDetector;

class LaravisorExceptionHandler
{
    public static function report(Throwable $e): void
    {
        try {
            if (!config('laravisor.enabled')) return;

            if (!in_array(app()->environment(), config('laravisor.environments'), true)) {
                return;
            }

            foreach (config('laravisor.ignore_exceptions', []) as $ignored) {
                if ($e instanceof $ignored) return;
            }

            $payload = PayloadBuilder::build($e);

            // 1️⃣ Optional storage
            if (StorageDetector::canStore()) {
                DatabaseErrorWriter::writeFromPayload($payload);
            }

            // 2️⃣ Fingerprint
            // $fingerprint = ErrorFingerprint::make($payload);

            // 3️⃣ Client-side flood protection
            // if (!ThrottleGuard::shouldNotify($fingerprint)) {
            //     return;
            // }

            // 5️⃣ Final notify
            Notifier::send($payload);
        } catch (Throwable $ignored) {
            // NEVER break client app
        }
    }
}
