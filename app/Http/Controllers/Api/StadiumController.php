<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SportResource;
use App\Http\Resources\StadiumResoure;
use App\Models\GameMatch;
use App\Models\Sport;
use App\Models\Stadium;
use Illuminate\Http\Request;

class StadiumController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = \request()->user();
        $userLongitude = $user->longitude;
        $userLatitude = $user->latitude;
//        $radius = 100000; km

        $stadiums = Stadium::with(['stadiumType','sports','facilities'])->select('*')
            ->selectRaw(
                '( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) )
            * cos( radians( longitude ) - radians(?) ) + sin( radians(?) )
            * sin( radians( latitude ) ) ) ) AS distance',
                [$userLatitude, $userLongitude, $userLatitude]
            )
//            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->get();

        return $this->handleResponse('',new StadiumResoure($stadiums));
//        return StadiumResoure::collection($stadiums);
//        return $this->handleResponse('',['stadiums'=>new StadiumResoure($stadiums)]);

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
    public function store(Request $request)
    {
//        $request->is_fullteam;
        $start = $request->start;
        $end = $request->end;
        if($request->is_fullteam){

        }else{
            $request->age_category;
            $request->sport_id;
            $request->audience;
            $request->special_note;
        }

        $match = GameMatch::


    }

    /**
     * Display the specified resource.
     */
    public function show(Stadium $stadium)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stadium $stadium)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stadium $stadium)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stadium $stadium)
    {
        //
    }
}
