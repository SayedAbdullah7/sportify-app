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
        $image = $this->getFirstMedia('team_image');

        return [
                'id' => $this->id,
                'image' => !empty($image)?asset('/storage/'.$image->id.'/'.$image->file_name):null,
                'name' => $this->name,
                'sport'=> new SportResource($this->whenLoaded('sport')),
                'user'=> UserResource::collection($this->whenLoaded('user')),
                'captain'=> new TeamUserResource($this->whenLoaded('captain')),
                'team_users'=> TeamUserResource::collection($this->whenLoaded('teamUsers')),

        ];
    }
}
