<?php

namespace App\Http\Controllers\Api;

use App\DataTables\SportDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSportRequest;
use App\Http\Requests\UpdateSportRequest;
use App\Http\Resources\SportResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserResource;
use App\Models\Position;
use App\Models\Sport;
use App\Models\Sports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SportController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( $user = Request()->user()){
            $query = function (Builder $query) use($user) {
                $query->whereRelation('users','user_id',$user->id);
            };
            $sports = Sport::with(['positions','mypositions'=> $query])->get();
//            $sports = Sport::with('positions')->get();

//            $user = $this->getUserData($user);
//            $sports = $user->sports;
        }else{
            $sports = Sport::with('positions')->get();
        }
        return $this->handleResponse('',['user'=> SportResource::collection($sports)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSportRequest $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'sport_id' => 'required|array',
                'position_id' => 'required|array',
            ]);

        if($validateUser->fails()){
            return $this->handleError('validation error',$validateUser->errors()->toArray());
        }

        $sports_count = Sport::find($request->sport_id)->count();

        if($sports_count != count($request->sport_id)){
            return $this->handleError('sport not found');
        }

        $positions_count = Position::where('sport_id',$request->sport_id)->whereIn('id',$request->position_id)->count();

        if($positions_count != count($request->position_id)){
            return $this->handleError('position not found');
        }

        $user = $request->user();
        $user->sports()->syncWithoutDetaching($request->sport_id);
        $user->positions()->syncWithoutDetaching($request->position_id);

        $remove_positions = Position::whereIn('sport_id',$request->sport_id)->whereNotIn('id',$request->position_id)->pluck('id');
        $user->positions()->detach($remove_positions);
        $user = $this->getUserData($user);
//        $user->load([
//            'sports.positions'=> function (Builder $query) use($user) {
//                $query->whereRelation('users','user_id',$user->id);
//            },
//        ]);

        return $this->handleResponse('sports successfully updated',['user'=> new UserResource($user)]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Sports $sports)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sports $sports)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSportRequest $request, Sports $sports)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'sport_id' => 'required|array',
//                'position_id' => 'required|array',
            ]);

        if($validateUser->fails()){
            return $this->handleError('validation error',$validateUser->errors()->toArray());
        }

        $sports_count = Sport::find($request->sport_id)->count();

        if($sports_count != count($request->sport_id)){
            return $this->handleError('sport not found');
        }

//        $positions_count = Position::where('sport_id',$request->sport_id)->whereIn('id',$request->position_id)->count();
//
//        if($positions_count != count($request->position_id)){
//            return $this->handleError('position not found');
//        }

        $user = $request->user();
        $user->sports()->detach($request->sport_id);
        $remove_positions = Position::whereIn('sport_id',$request->sport_id)->pluck('id');
        $user->positions()->detach($remove_positions);
        $user->load('sports.positions');
        $user = $this->getUserData($user);
//        $user->load('sports','positions');
//        $user->load([
//            'sports.positions'=> function (Builder $query) use($user) {
//                $query->whereRelation('users','user_id',$user->id);
//            },
//        ]);

        return $this->handleResponse('sports successfully updated',['user'=> new UserResource($user)]);

    }

    private function getUserData($user){
        $query = function (Builder $query) use($user) {
            $query->whereRelation('users','user_id',$user->id);
        };
        $user->load(['sports.positions','sports.mypositions'=> $query]);
        return $user;
    }
}
