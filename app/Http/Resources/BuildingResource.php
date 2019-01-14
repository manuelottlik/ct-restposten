<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BuildingResource extends JsonResource
{
 public function toArray($request)
 {
  return [
   "id" => $this->id,
   "name" => $this->name,
   "another_value" => "Irgendwelche anderen Daten...",
   "rooms" => RoomResource::collection($this->whenLoaded("rooms")),
   "created_at" => $this->created_at,
   "updated_at" => $this->updated_at,
  ];
 }
}