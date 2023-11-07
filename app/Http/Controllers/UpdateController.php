<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Staudenmeir\LaravelMergedRelations\Facades\Schema;

class UpdateController extends Controller
{
    public function database(){
        Schema::createMergeView(
            'friends_view',
            [(new \App\Models\User())->acceptedFriendsTo(), (new \App\Models\User())->acceptedFriendsFrom()]
        );
    }
}
