<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Media as MediaResource;
use App\Http\Resources\Requirement as RequirementResource;

class Service extends JsonResource
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
            'provider_id' => $this->provider_id,
            'name' => $this->name,
            'description' => $this->description,
            'video' => $this->video_url,
            'price' => $this->price,
            'extra_person_cost' => $this->extra_person_cost,
            'capacity' => $this->capacity,
            'max_persons' => $this->getMaxPersons(),
            'duration' => $this->duration,
            'prepare_time' => $this->prepare_time,
            'gender' => $this->getGenderLabel(),
            'image' => $this->getFirstMediaUrl('image'),
            'gallery' => MediaResource::collection($this->getMedia('gallery')),
            'requirements' => RequirementResource::collection($this->requirements),
        ];
    }
}
