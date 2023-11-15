<?php

namespace App\Http\Controllers\Api;

use App\DataTables\SportDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSportsRequest;
use App\Http\Requests\UpdateSportsRequest;
use App\Http\Resources\SportResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserResource;
use App\Models\Sport;
use App\Models\Sports;
use Illuminate\Support\Facades\Validator;

class SportController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sports = Sport::with('positions')->get();
        return SportResource::collection($sports);
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
    public function store(StoreSportsRequest $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'sport_id' => 'required|array',
            ]);

        if($validateUser->fails()){
            return $this->handleError('validation error',$validateUser->errors()->toArray());
        }

        $sports_count = Sport::find($request->sport_id)->count();

        if($sports_count != count($request->sport_id)){
            return $this->handleError('sport not found');
        }

        $user = $request->user();
        $user->sports()->sync($request->sport_id);
        $user->load('sports');

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
    public function update(UpdateSportsRequest $request, Sports $sports)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sports $sports)
    {
        //
    }
}
