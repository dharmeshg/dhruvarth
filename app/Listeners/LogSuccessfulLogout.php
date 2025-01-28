<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Logout;
use App\Models\ActivityLog;

class LogSuccessfulLogout
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
        $ipAddress = request()->ip();
        ActivityLog::create([
            'user_id' => $event->user->id,
            'action' => 'logout',
            'module' => 'auth',
            'new_data' => json_encode(['ip' => $ipAddress]),
        ]);
    }
}
