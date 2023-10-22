<?php

namespace App\Http\Controllers;

use App\DataTables\AdminsDataTable;
use App\DataTables\StadiumOwnerDataTable;
use App\Http\Requests\StadiumOwnerRequest;
use App\Models\StadiumOwner;
use Illuminate\Http\Request;

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
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);

        return response()->json(['filename' => $filename]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StadiumOwnerRequest $request)
    {
        StadiumOwner::create($request->all());
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
        return view('pages.stadium_owner.form',['model'=>$stadiumOwner,'action'=>route('stadium-owner.update',$stadiumOwner->id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StadiumOwner $stadiumOwner)
    {
        $stadiumOwner->update($request->all());
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
