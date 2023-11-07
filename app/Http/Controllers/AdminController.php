<?php

namespace App\Http\Controllers;

use App\DataTables\AdminsDataTable;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AdminsDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.index');
//        return $admins = Admin::all();
//        return view('pages.admin.index',compact('admins'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        return view('pages.admin.form',['model'=>$admin,'action'=>route('admin.update',$admin->id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|unique:users,username,'.$admin->id,
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin->name =$request->name;
        $admin->username =$request->username;
        $admin->password = Hash::make($request->password);
        $admin->save();

        return response()->json(['status'=>true,'msg'=>'successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
