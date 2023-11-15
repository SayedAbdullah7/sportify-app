<?php

namespace App\Http\Controllers;

use App\DataTables\SportDataTable;
use App\Http\Requests\StoreSportsRequest;
use App\Http\Requests\UpdateSportsRequest;
use App\Models\Sports;

class SportsController extends Controller
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
    public function store(StoreSportsRequest $request)
    {

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
