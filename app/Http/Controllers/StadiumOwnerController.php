<?php

namespace App\Http\Controllers;

use App\DataTables\AdminsDataTable;
use App\DataTables\StadiumOwnerDataTable;
use App\Http\Requests\StadiumOwnerRequest;
use App\Models\Sport;
use App\Models\Stadium;
use App\Models\StadiumOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StadiumOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StadiumOwnerDataTable $dataTable)
    {
        return $dataTable->render('pages.stadium_owner.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.stadium_owner.form',['action'=>route('stadium-owner.store')]);
    }

    public function uploadImage(Request $request)
    {
        $file = $request->file('image');
        $filename = Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);

        return response()->json(['filename' => $filename]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StadiumOwnerRequest $request)
    {
        $stadiumOwner = new StadiumOwner();
        $stadiumOwner->name = $request->name;
        $stadiumOwner->phone = $request->phone;
        $stadiumOwner->email = $request->email;
        $stadiumOwner->save();


        // Create a new Stadium
        $stadium = new Stadium();
        $stadium->stadium_type_id = $request->stadia_type_id;
        $stadium->location_link = $request->location_link;
//        $stadium->email = $request->email;
        $stadium->longitude = $request->longitude;
        $stadium->latitude = $request->latitude;
        $stadium->name = $request->stadium_name;
        $stadium->stadium_owner_id =  $stadiumOwner->id;
        $stadium->save();
        if ($request->image){
            foreach ($request->image as $image){
                $pathToMedia = public_path('uploads/'.$image);
                $media = $stadium->addMedia($pathToMedia)->toMediaCollection();
                $media->save();
            }
        }


        if ($request->sports) {

            foreach ($request->sports as $sport) {
                $stadium->sports()->attach($sport);
            }
        }

        return response()->json(['status'=>true,'msg'=>'successfully created']);
    }

    /**
     * Display the specified resource.
     */
    public function show(StadiumOwner $stadiumOwner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StadiumOwner $stadiumOwner)
    {
        $stadiumOwner->load(['stadium.sports']);
//        return $stadiumOwner->stadium->getMedia();
        return view('pages.stadium_owner.form',['model'=>$stadiumOwner,'action'=>route('stadium-owner.update',$stadiumOwner->id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StadiumOwnerRequest $request, StadiumOwner $stadiumOwner)
    {
//        $stadiumOwner->update($request->all());
//        $stadiumOwner = new StadiumOwner();
        $stadiumOwner->name = $request->name;
        $stadiumOwner->phone = $request->phone;
        $stadiumOwner->email = $request->email;
        $stadiumOwner->save();


        // Create a new Stadium
        $stadium = $stadiumOwner->stadium;
        $stadium->stadium_type_id = $request->stadia_type_id;
        $stadium->location_link = $request->location_link;
        $stadium->longitude = $request->longitude;
        $stadium->latitude = $request->latitude;
        $stadium->name = $request->stadium_name;
        $stadium->stadium_owner_id =  $stadiumOwner->id;
        $stadium->save();

        if ($request->image) {
            foreach ($request->image as $image) {
                $pathToMedia = public_path('uploads/' . $image);
                $media = $stadium->addMedia($pathToMedia)->toMediaCollection();
                $media->save();
            }
        }



//        foreach ($request->sports as $sport) {
            $stadium->sports()->sync($request->sports);
//        }
        return response()->json(['status'=>true,'msg'=>'successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StadiumOwner $stadiumOwner)
    {
        //
    }
}
