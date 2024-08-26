<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        foreach (static::getModelEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->logActivity($event);
            });
        }
    }

    protected function logActivity($event)
    {
       
        ActivityLog::create([
            'log_name' => $this->getLogName(),
            'description' => $this->getActivityDescription($event),
            'subject_id' => $this->id,
            'subject_type' => get_class($this),
            'causer_id' => auth()->id(),
            'causer_type' => auth()->user() ? get_class(auth()->user()) : null,
            'properties' => $this->activityProperties(),
        ]);
    }

    protected static function getModelEvents()
    {
        return ['created', 'updated', 'deleted'];
    }

    protected function getLogName()
    {
        return property_exists($this, 'logName') ? $this->logName : null;
    }

    protected function getActivityDescription($event)
    {
        return "{$event} a " . strtolower(class_basename($this));
    }

    protected function activityProperties()
    {
        return $this->getChanges();
    }

    protected function getSpecificFieldsChanges()
    {
        if (!property_exists($this, 'logFields') || empty($this->logFields)) {
            return $this->getChanges(); // Log all changes if no specific fields are defined
        }

        return array_intersect_key($this->getChanges(), array_flip($this->logFields));
    }
}
