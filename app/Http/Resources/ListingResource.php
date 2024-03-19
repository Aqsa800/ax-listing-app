<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'type' => $this->type,
            'bed' => $this->bedroomData ? $this->bedroomData->name : null,
            'bath' => $this->bathroomData ? $this->bathroomData->name : null,
            'portals' => $this->portals()->pluck('name')->implode(', ')
        ];
    }
}
