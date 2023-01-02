<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'details' => $this->details,
            'price' => $this->price,
            'userId' => $this->userId,
            'sold' => $this->sold,
            'picture' => $this->picture,
            'soldTo' => $this->soldTo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
