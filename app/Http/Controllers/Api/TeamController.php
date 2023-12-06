<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserResource;
use App\Models\Position;
use App\Models\Sport;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TeamController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $user->load(['teams.teamUsers.position','teams.teamUsers.user','teams.sport','teams.captain.user','teams.captain.position']);
        return $this->handleResponse('',['teams'=>TeamResource::collection($user->teams)]);
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
    public function store(StoreTeamRequest $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'name' => 'required|string|regex:/(^[A-Za-z0-9 ]+$)+/|max:255',
                'sport_id' => 'required|exists:sports,id',
//                'position_id' => 'required|exists:positions,id',
                'position_id' => 'required',
                'members_id' => 'required|array',
                'positions_id' => 'required|array',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // Adjust max file size as needed
            ]);

        if($validateUser->fails()){
            return $this->handleError('validation error',$validateUser->errors()->toArray());
        }
        $position_id = $request->position_id;
        $sport_id = $request->sport_id;

        $user = $request->user();
        $members_id = $request->members_id;
        $positions_id = $request->positions_id;

        $position = Position::where('id',$position_id)->whereHas('sport', function (\Illuminate\Database\Eloquent\Builder $query) use($sport_id) {
            $query->where('id', $sport_id);
        })->first();

        if(!$position){
            return $this->handleError('position not found');
        }

        DB::beginTransaction();
        $team = $user->teamsMade()->create(['name'=>$request->name,'sport_id'=>$sport_id]);
        $team->users()->attach($user,['position_id' => $position->id,'is_cap'=>true]);

        if ($request->hasFile('image')) {
            $team->addMediaFromRequest('image')->toMediaCollection('team_image');
        }

        $team_id = $team->id;
        $res = $this->executeAddingMember($team_id,$members_id,$positions_id);
        if(!$res['status']){
            return $this->handleError($res['msg']);
        }
        DB::commit();
        $team = Team::find($team_id);
        $team->load(['teamUsers.position','teamUsers.user','sport','captain.user','captain.position']);

        return $this->handleResponse('',['team'=>new TeamResource($team)]);
    }

    private function executeAddingMember($team_id,array $members_id,array $positions_id): array
    {
        $user = request()->user();
        $team = $user->teamsMade()->where('id',$team_id)->first();

        if(!$team){
            return ['status'=>false,'msg'=>'team not found'];
        }

        $friends_count = $user->friends()->whereIn('id',$members_id)->count();
        if($friends_count != count($members_id)){
            return ['status'=>false,'msg'=>'friend not found'];
        }

        $teamUserCount = $team->teamUsers()->whereIn('user_id',$members_id)->count();
        if($teamUserCount > 0){
            return ['status'=>false,'msg'=>'member already joined before'];
        }

        $available_positions_count = $team->sport->positions()->whereIn('id',$positions_id)->count();

        if($available_positions_count != count(array_unique($positions_id))){
            return ['status'=>false,'msg'=>'position not found'];
        }

        foreach ($members_id as $index=>$member_id){
            $team->users()->attach($member_id,['position_id' => $positions_id[$index]]);
        }

        return ['status'=>true,'msg'=>'members added successfully'];
    }
    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }
    public function removeMember(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
//                'members_id' => 'array',
                'team_id' => 'required',
            ]);

        if($validateUser->fails()){
            return $this->handleError('validation error',$validateUser->errors()->toArray());
        }

        $user = $request->user();
        $team_id = $request->team_id;
        $user_id = $user->id;
        $member_id = $request->member_id;

        if ($member_id && $member_id != $user_id){ // remove another member
            $member = User::find($member_id);

            $team = $user->teamsMade()->where('id',$team_id)->first();
            if(!$team){
                return $this->handleError('team not found');
            }

            $teamUser = $team->teamUsers()->where('user_id',$member_id)->first();
            if(!$teamUser){
                return $this->handleError('user not found in team');
            }

            $teamUser->delete();
        }else{
            $user_id = $user->id;
            $team =$user->teams()->where('teams.id',$team_id)->first();
            if(!$team){
                return $this->handleError('team not found');
            }
            $is_captain = $user->teamsMade()->where('id',$team_id)->first();
            if($is_captain){
                return $this->handleError('you cant remove yourself');
            }
            $teamUser = $team->teamUsers()->where('user_id',$user_id)->delete();

        }
        $team->load(['teamUsers.position','teamUsers.user','sport','captain.user','captain.position']);
        return $this->handleResponse('',['team'=>new TeamResource($team)]);

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function addMember(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'members_id' => 'required|array',
                'positions_id' => 'required|array',
                'team_id' => 'required',
            ]);

        if($validateUser->fails()){
            return $this->handleError('validation error',$validateUser->errors()->toArray());
        }
        $user = $request->user();
        $team_id = $request->team_id;
        $members_id = $request->members_id;
        $positions_id = $request->positions_id;
//        $team = $user->teamsMade()->where('id',$team_id)->first();
//
//        if(!$team){
//            return $this->handleError('team not found');
//        }
//
//        $member = $user->friends()->where('id',$member_id)->first();
//        if(!$member){
//            return $this->handleError('member not found');
//        }
//
//        $teamUser = $team->teamUsers()->where('user_id',$member->id)->first();
//        if(!$teamUser){
//            return $this->handleError('member already joined before');
//        }
//
//        $position = $team->sport->positions()->where('id',$position_id)->first();
//        if(!$position){
//            return $this->handleError('position not found');
//        }
//
//        $team->users()->attach($member,['position_id' => $position->id]);
        $res = $this->executeAddingMember($team_id,$members_id,$positions_id);
        if(!$res['status']){
            return $this->handleError($res['msg']);
        }
        $team = Team::find($team_id);
        $team->load(['teamUsers.position','teamUsers.user','sport','captain.user','captain.position']);

        return $this->handleResponse('member added successfully',['team'=>new TeamResource($team)]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request)
    {
        $user = $request->user();
        $team_id = $request->team_id;

        $validate = Validator::make($request->all(),
        [
            'team_id' => [
                'required',
                Rule::exists('teams', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],
            'name' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // Adjust max file size as needed
        ]);

        if($validate->fails()){
            return $this->handleError('validation error',$validate->errors()->toArray());
        }

        $team = $user->teamsMade()->where('id',$team_id)->first();

        if(!$team){
            return $this->handleError('team not found');
        }
        $team->update(['name'=>$request->name]);

        if ($request->hasFile('image')) {
            $team->clearMediaCollection('team_image');
            $team->addMediaFromRequest('image')->toMediaCollection('team_image');
        }elseif($request->deleteImage){
            $team->clearMediaCollection('team_image');
        }
        $team->load(['teamUsers.position','teamUsers.user','sport','captain.user','captain.position']);
        return $this->handleResponse('successfully updated',['team'=> new TeamResource($team)]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user = $request->user();
        $team_id = $request->team_id;

        $validate = Validator::make($request->all(),
            [
                'team_id' => [
                    'required',
                    Rule::exists('teams', 'id')->where(function ($query) {
                        $query->where('user_id', auth()->id());
                    }),
                ],
            ]);


        if($validate->fails()){
            return $this->handleError('validation error',$validate->errors()->toArray());
        }

        $team = $user->teamsMade()->where('id',$team_id)->first();

        if(!$team){
            return $this->handleError('team not found');
        }

        $team->delete();

        return $this->handleResponse('team deleted successfully',['teams'=>TeamResource::collection($user->teams)]);
    }
}
