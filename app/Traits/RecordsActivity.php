<?php

namespace App\Traits;

use App\Activity;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($eventType)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($eventType),
        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    protected function getActivityType($eventType)
    {
        $class = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$eventType}_{$class}";
    }
}
