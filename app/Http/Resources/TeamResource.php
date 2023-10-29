<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
                'id' => $this->id,
                'name' => $this->name,
                'sport'=> new SportResource($this->whenLoaded('sport')),
                'user'=> UserResource::collection($this->whenLoaded('user')),
                'team_users'=> TeamUserResource::collection($this->whenLoaded('teamUsers')),
        ];
    }
}
