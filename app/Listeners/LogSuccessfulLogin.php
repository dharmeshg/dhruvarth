<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use App\Models\ActivityLog;

class LogSuccessfulLogin
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
        ActivityLog::create([
            'user_id' => $event->user->id,
            'action' => 'login',
            'module' => 'auth',
            'new_data' => json_encode(['ip' => request()->ip()]),
        ]);
    }
}
