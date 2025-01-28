<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->logActivity('created');
        });

        static::updated(function ($model) {
            $model->logActivity('updated', $model->getOriginal());
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted');
        });
    }

    protected function logActivity($action, $oldData = null)
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'module' => $this->getTable(),
            'old_data' => $oldData ? json_encode($oldData) : null,
            'new_data' => json_encode($this->attributesToArray()),
        ]);
    }
}
