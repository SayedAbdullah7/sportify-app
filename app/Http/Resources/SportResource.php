<?php

namespace App\Http\Resources;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        $array = [
            'id' => $this->id,
            'name' => $this->name,
            'positions'=> PositionResource::collection($this->whenLoaded('positions')),
        ];
        if ( $this->whenLoaded('positions') && ($user = Request()->user())){
            $available_positions = ['available_positions'=> PositionResource::collection(Position::where('sport_id',$this->id)->whereNotIn('id',$user->positions()->pluck('positions.id'))->get() )];
//            $available_positions = ['available_positions'=> self::collection(Position::where('sport_id',$this->id)->take(1)->get() )];
        }else{
            $available_positions=[];

        }
        return $array + $available_positions;
    }
}
