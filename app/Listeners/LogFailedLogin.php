<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Failed;
use App\Models\ActivityLog;

class LogFailedLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
        $username = $event->credentials['email'] ?? 'unknown';

        ActivityLog::create([
            'user_id' => null,
            'action' => 'failed_login',
            'module' => 'auth',
            'new_data' => json_encode([
                'username' => $username,
                'ip' => request()->ip(),
            ]),
        ]);
    }
}
