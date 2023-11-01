<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function send(Request $request)
    {
        $user = $request->user();
        $friend_id = $request->friend_id;
        $friend = User::find($friend_id);

        if (!$user || !$friend) {
            return response()->json(['message' => 'Invalid user or friend'], 404);
        }

        // Check if the users are already friends
        if ($user->friendsTo->contains($friend)) {
            return response()->json(['message' => 'You are already friends with this user'], 400);
        }

        // Check if a pending friend request has already been sent
        if ($user->pendingFriendsTo->contains($friend)) {
            return response()->json(['message' => 'You have already sent a friend request to this user'], 400);
        }
//        return $user->friends;
//        $r = $user->friendsTo()->attach($friend_id, ['accepted' => false]);

        return response()->json(['data'=>$user->pendingFriendsTo]);


    }
}
