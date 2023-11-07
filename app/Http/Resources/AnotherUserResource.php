<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnotherUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        $image = $this->getFirstMedia('profile');
//        $image = asset('/storage/'.$image->id.'/'.$image->file_name);
        $user_id = auth()->user()->id;
        return [
            'id' => $this->id,
            'image' => !empty($image)?asset('/storage/'.$image->id.'/'.$image->file_name):null,
//            'point' => (int)$this->point,
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
            'is_friend' => $is_friend = $this->isFriend($user_id),
            'is_pending_friends_to' => $is_pending_friends_to = !$is_friend?$this->isPendingFriendsTo($user_id):false,
            'is_pending_friends_from' => !$is_pending_friends_to? $this->isPendingFriendsFrom($user_id):false,

//            'is_friend' => request()->user(),
//            'is_friend' => $this->isFriend(request()->user()),
//            where('id',request()->user()->id)->first(),

            'teams'=> TeamResource::collection($this->whenLoaded('teams')),
            'team_users'=> TeamUserResource::collection($this->whenLoaded('teamUsers')),
            'sports'=> SportResource::collection($this->whenLoaded('sports')),
        ];
    }
}
