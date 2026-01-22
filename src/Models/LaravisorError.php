<?php

namespace Sam\Laravisor\Models;

use Illuminate\Database\Eloquent\Model;

class LaravisorError extends Model
{
    protected $table = 'laravisor_errors';

    protected $fillable = [
        'error_id',
        'exception',
        'message',
        'stack_trace',
        'request',
        'occurred_at',
    ];

    protected $casts = [
        'stack_trace' => 'array',
        'request' => 'array',
        'occurred_at' => 'datetime',
    ];
}
