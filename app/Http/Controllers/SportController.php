<?php

namespace App\Http\Controllers;

use App\DataTables\SportDataTable;
use App\Http\Requests\StoreSportRequest;
use App\Http\Requests\UpdateSportRequest;
use App\Models\Sport;

class SportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SportDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.sport.form',['action'=>route('sport.store')]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSportRequest $request)
    {
        $request->validate([
            'name' => 'required|unique:sports',
        ]);

        $sport = new Sport();
        $sport->name = $request->name;
        $sport->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Sport $sport)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sport $sport)
    {
        return view('pages.sport.form',['model'=>$sport,'action'=>route('sport.update',$sport->id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSportRequest $request, Sport $sport)
    {
        $request->validate([
            'name' => 'required|unique:sports,name,'.$sport->id,
        ]);

        $sport->name = $request->name;
        $sport->save();

        return response()->json(['status'=>true,'msg'=>'successfully updated']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sport $sport)
    {
        $sport->delete();
//        $sport->
        return response()->json(['status'=>true,'msg'=>'successfully deleted']);
//        return $sport;
    }
}
