<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "seats" => $this->seats,
            "windows" => $this->windows,
            "building" => new BuildingResource($this->whenLoaded('building')),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
