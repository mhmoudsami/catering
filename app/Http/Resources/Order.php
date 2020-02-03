<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
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
            'status' => $this->status,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'date' => $this->date,
            'persons_count' => $this->persons_count,
            'address' => $this->address,
            'notes' => $this->notes,

            'subtotal' => $this->subtotal,
            'total' => $this->total,

            'user' => new User($this->user),
            'city' => new City($this->city),
            'provider' => new Provider($this->provider),
            'service' => new Service($this->service),
        ];
    }
}
