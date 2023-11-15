<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamUserResource extends JsonResource
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
            'is_cap' => $this->is_cap,
            'position'=> new PositionResource($this->whenLoaded('position')),
            'user'=> new AnotherUserResource($this->whenLoaded('user')),
        ];
    }
}
