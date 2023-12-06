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
        $image = $this->getFirstMedia('profile');
//        $image = asset('/storage/'.$image->id.'/'.$image->file_name);
        return [
            'id' => $this->id,
            'image' => !empty($image)?asset('/storage/'.$image->id.'/'.$image->file_name):null,
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
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString(),
            'teams'=> TeamResource::collection($this->whenLoaded('teams')),
            'team_users'=> TeamUserResource::collection($this->whenLoaded('teamUsers')),
//            'friends'=> [],
            'sports'=> SportResource::collection($this->whenLoaded('sports')),
            'positions'=> PositionResource::collection($this->whenLoaded('positions')),

            'friends_count' => $this->whenCounted('friends'),
            'friends'=> AnotherUserResource::collection($this->whenLoaded('friends')),
            'pending_friends_to'=> AnotherUserResource::collection($this->whenLoaded('pendingFriendsTo')),
            'pending_friends_from'=> AnotherUserResource::collection($this->whenLoaded('pendingFriendsFrom')),
        ];
    }
}
