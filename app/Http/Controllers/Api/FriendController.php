<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnotherUserResource;
use App\Http\Resources\UserResource;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;

class FriendController extends BaseController
{
    public function index(Request $request){
        $user = $request->user();
        $user->load('friends','friends.sports','friends.teams','friends.teams.sport');
        return $this->handleResponse('',AnotherUserResource::collection($user->friends));
    }

    public function getPendingRequests(Request $request){
        $user = $request->user();
        $sentRequests = $user->pendingFriendsTo()->get();
        return $this->handleResponse('',UserResource::collection($sentRequests));
    }

    public function getSentRequests(Request $request){
        $user = $request->user();
        $sentRequests = $user->pendingFriendsFrom()->get();
        return $this->handleResponse('',UserResource::collection($sentRequests));
    }

    public function send(Request $request)
    {
        $user = $request->user();
        $friend_id = $request->friend_id;
        $friend = User::find(1);

        if (!$user || !$friend) {
            return $this->handleError('user not found');
        }

        // Check if the users are already friends
        if ($user->friendsTo->contains($friend)) {
            return $this->handleError('You are already friends with this user');
        }

        // Check if a pending friend request has already been sent
        if ($user->pendingFriendsTo->contains($friend)) {
            return $this->handleError('You have already sent a friend request to this user');
        }
//        return $user->friends;
        $r = $user->friendsTo()->attach($friend_id);

        return $this->handleResponse('request sent successfully',['user'=>new UserResource($user->load('friends','pendingFriendsTo','pendingFriendsFrom'))]);
    }


    public function accept(Request $request)
    {
        $user = $request->user();
        $friend_id = $request->friend_id;
        $friend = User::find($friend_id);

        if (!$friend) {
            return $this->handleError('user not found');
        }
        if (!$user->isPendingFriendsFrom($friend->id)) {
            return $this->handleError('request not found');
        }

        $user->friendsFrom()->updateExistingPivot($friend->id, ['accepted' => true]);

        return $this->handleResponse('accepted successfully',['user'=>new UserResource($user->load('friends','pendingFriendsTo','pendingFriendsFrom'))]);
    }

    public function reject(Request $request)
    {
        $user = $request->user();
        $user_id = $user->id;
        $friend_id = $request->friend_id;
        $relation = Friend::where('user_id', $friend_id)
            ->where('friend_id',  $user_id)->first();


        if (!$relation) {
            return $this->handleError('request not found');
        }
        $relation->delete();

        return $this->handleResponse('rejected successfully',['user'=>new UserResource($user->load('friends','pendingFriendsTo','pendingFriendsFrom'))]);
    }

    public function cancel(Request $request)
    {
        $user = $request->user();
        $friend_id = $request->friend_id;
        $user_id = $user->id;
//        $friend_request = $user->friendsTo()->where('friend_id',$friend_id)->first();
        $relation = Friend::where('user_id', $user_id)
                ->where('friend_id',  $friend_id)->first();

        if (!$relation) {
            return $this->handleError('request not found');
        }
        $relation->delete();

        return $this->handleResponse('cancel successfully',['user'=>new UserResource($user->load('friends','pendingFriendsTo','pendingFriendsFrom'))]);
    }

    public function delete(Request $request)
    {
        $user = $request->user();
        $user_id = $user->id;

        $friend_id = $request->friend_id;
        $friend = User::find($friend_id);
        if (!$friend) {
            return $this->handleError('friend not found');
        }

        $relation = Friend::where(function ($query) use($user_id,$friend_id) {
            $query->where('user_id', $user_id)
                ->where('friend_id',  $friend_id);
        })->orWhere(function ($query) use($user_id,$friend_id) {
            $query->where('user_id', $friend_id)
                ->where('friend_id', $user_id);
        })->first();

        if (!$relation) {
            return $this->handleError('the user in not your friend');
        }

        $relation->delete();

        return $this->handleResponse('deleted successfully',['user'=>new UserResource($user->load('friends','pendingFriendsTo','pendingFriendsFrom'))]);
    }

    public function available(Request $request){
        $users = User::where('id','!=',$request->user()->id)->get();
        return $this->handleResponse('updated successfully',AnotherUserResource::collection($users));
    }
}
