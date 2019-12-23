<?php

namespace App\Http\Resources\Events;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'country_id' => $this->country_id,
            'title' => $this->title,
            'description' => $this->description,
            'image_path' => $this->image_path,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'locked' => $this->locked,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'comments_count' => $this->comments_count,
            'visitsCount' => $this->visitsCount,
            'favoritesCount' => $this->favoritesCount,
            'subscribersCount' => $this->subscribersCount,
            'isFavorited' => $this->isFavorited,
            'creator' => new UserResource($this->whenLoaded('creator')),
            'favorites' => $this->whenLoaded('favorites'),
            'subscription' => $this->whenLoaded('subscription'),
            'country' => $this->whenLoaded('country', function() {
                return [
                    'id' => $this->country->id,
                    'name' => $this->country->name,
                ];
            }),
        ];
    }
}
