<?php

namespace App\Http\Resources\Events;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'title' => $this->title,
      'description' => $this->description,
      'start_at' => $this->start_at,
      'end_at' => $this->end_at,
      'available_slots' => $this->available_slots,
      'aacc_hours' => $this->aacc_hours,
      'location' => $this->location,
      'photo' => $this->photo,
      'parent' => new EventResource($this->whenLoaded('parent')),
      'children' => EventResource::collection($this->whenLoaded('children'))
    ];
  }
}
