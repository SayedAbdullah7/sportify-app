<?php

namespace App\Http\Resources;

use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'image' => $this->image,
            'point' => (int)$this->point,
            'name' => $this->name,
            'username' => $this->username,
            'gender' => $this->gender?'male':'female',
            'age' => Carbon::parse($this->day_of_birth)->age,
            'day_of_birth' => Carbon::parse($this->day_of_birth)->toDateString(),
            'email' => $this->email,
            'phone' => $this->phone,
            'height' => $this->height,
            'address' => $this->address,
            'about' => $this->about,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString(),
            'teams'=> TeamResource::collection($this->whenLoaded('teams')),
            'team_users'=> TeamUserResource::collection($this->whenLoaded('teamUsers')),
//            'friends'=> [],
            'friends'=> self::collection($this->whenLoaded('friends')),
            'sports'=> SportResource::collection($this->whenLoaded('sports')),
        ];
    }
}
