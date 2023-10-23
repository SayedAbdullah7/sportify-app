<?php

namespace App\Http\Controllers;

use App\DataTables\SportDataTable;
use App\Http\Requests\StoreStadiumTypeRequest;
use App\Http\Requests\UpdateStadiumTypeRequest;
use App\Models\StadiumType;

class StadiumTypeController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStadiumTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StadiumType $stadiumType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StadiumType $stadiumType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStadiumTypeRequest $request, StadiumType $stadiumType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StadiumType $stadiumType)
    {
        //
    }
}
