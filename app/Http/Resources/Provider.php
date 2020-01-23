<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Service as ServiceResource;

class Provider extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'mobile' => $this->mobile,
            'description' => $this->description,
            'responsible_name' => $this->responsible_name,
            'responsible_mobile' => $this->responsible_mobile,
            'order' => $this->order,
            'image' => $this->getFirstMediaUrl('image'),
            'services' => ServiceResource::collection($this->whenLoaded('services')),
        ];
    }
}
