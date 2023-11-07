<?php

namespace App\Http\Controllers;

use App\DataTables\AdminsDataTable;
use App\DataTables\UserDataTable;
use App\Models\StadiumOwner;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('pages.user.index');

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
        ////        save
//      $service = new service()->login($id)
//        $service->status? true false
//       $response = $service->store($user)
//      $response['status']? true : 'false;


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('pages.user.form',['model'=>$user,'action'=>route('user.update',$user->id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
