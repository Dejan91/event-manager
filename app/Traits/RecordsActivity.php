<?php

namespace App\Traits;

use App\Activity;
use ReflectionException;

/**
 * Trait RecordsActivity
 * @package App\Traits
 */
trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }

    /**
     * @return array
     */
    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    /**
     * @param $eventType
     *
     * @throws ReflectionException
     */
    protected function recordActivity($eventType)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($eventType),
        ]);
    }

    /**
     * @return mixed
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    /**
     * @param $eventType
     * @return string
     * @throws ReflectionException
     */
    protected function getActivityType($eventType)
    {
        $class = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$eventType}_{$class}";
    }
}
