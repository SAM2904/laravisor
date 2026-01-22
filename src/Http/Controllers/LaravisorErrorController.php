<?php

namespace Sam\Laravisor\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Sam\Laravisor\Models\LaravisorError;
use Sam\Laravisor\Support\StorageDetector;

class LaravisorErrorController
{
    public function index()
    {
        if (!StorageDetector::canStore()) {
            return response()->json([
                'message' => 'Error storage is disabled.'
            ], 404);
        }

        return LaravisorError::latest()
            ->limit(50)
            ->get([
                'error_id',
                'exception',
                'message',
                'occurred_at',
                'created_at',
            ]);
    }

    public function show(string $errorId)
    {
        return LaravisorError::where('error_id', $errorId)->firstOrFail();
    }
}
