<?php
namespace App\Traits;

trait ActivityLogTrait
{
    public function logActivity($activityName, $model, $event, $message)
    {
        activity($activityName)
        ->causedBy(auth()->user())
        ->performedOn($model)
        ->withProperties(['ip' => request()->ip(), 'user-agent' => request()->userAgent()])
        ->event($event)
        ->log($message);
    }
    
}