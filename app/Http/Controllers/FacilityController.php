<?php

namespace App\Http\Controllers;

use App\DataTables\FacilityDataTable;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FacilityDataTable $dataTable)
    {
        return $dataTable->render('pages.facility.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.facility.form',['action'=>route('facility.store')]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:facilities',
        ]);

        $facility = new Facility();
        $facility->name = $request->name;
        $facility->save();

        return response()->json(['status'=>true,'msg'=>'successfully created']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility)
    {
        return view('pages.facility.form',['model'=>$facility,'action'=>route('facility.update',$facility->id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facility $facility)
    {

        $request->validate([
            'name' => 'required|unique:facilities,name,'.$facility->id,
        ]);

        $facility->name = $request->name;
        $facility->save();

        return response()->json(['status'=>true,'msg'=>'successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        $facility->delete();
//        $facility->
        return response()->json(['status'=>true,'msg'=>'successfully deleted']);
//        return $facility;
    }
}
