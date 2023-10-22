<?php

namespace App\Http\Controllers\Api;

use App\DataTables\AdminsDataTable;
use App\DataTables\StadiumOwnerDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StadiumOwnerRequest;
use App\Http\Resources\StadiumOwnerResource;
use App\Models\StadiumOwner;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StadiumOwnerController extends Controller
{
    public function generateOtpAvailability(Request $request)
    {
        // Check parameters
        if(!$request->phone){
            return response()->error('invalid parameter');
        }

        // Check model exited
        $stadiumOwner = StadiumOwner::where('phone',$request->phone)->first();
        if (!$stadiumOwner){
            return response()->error('not registered');
        }

        // Check availability to generate OTP
        $now = Carbon::now();
        $verificationCodes = $stadiumOwner->verificationCodes;
        if ($verificationCodes->count() >= 3 && $now->subHour()->isBefore($verificationCodes->last()->created_at)){
            return response()->error('blocked');
        }


        return response()->success('available');
    }
    /*
     *
     */
    public function generateOtp(Request $request)
    {
        // Check parameters
        if(!$request->phone){
            return response()->error('invalid parameter');
        }

        // Check model exited
        $stadiumOwner = StadiumOwner::where('phone',$request->phone)->first();
        if (!$stadiumOwner){
            return response()->error('not registered');
        }

        // Check availability to generate OTP
        $now = Carbon::now();
        $verificationCodes = $stadiumOwner->verificationCodes;
        if ($verificationCodes->count() >= 3 && $now->subHour()->isBefore($verificationCodes->last()->created_at)){
            return response()->error('blocked');
        }

        // Generate OTP with gateway
        $otp = '1234';


        // Store the OTP
        $stadiumOwner->verificationCodes()->create([
            'otp' => $otp,
            'expire_at' => Carbon::now()->addMinutes(3)
        ]);


        return response()->success('done');
    }
    /*
     *
    */
    public function verifyOtp(Request $request)
    {
        // Check parameters
        if(!$request->phone || strlen($request->otp) !== 6){
            return response()->error('invalid parameter');
        }

        // Check model exited
        $stadiumOwner = StadiumOwner::where('phone',$request->phone)->first();
        if (!$stadiumOwner){
            return response()->error('not registered');
        }

        // Verify the OTP
        $verificationCode = $stadiumOwner->verificationCodes()->where('otp',$request->otp)->first();
        if(!$verificationCode ){
            return response()->error('not valid');
        }

        // Delete all the old OTPs for this stadiumOwner
        $stadiumOwner->verificationCodes()->delete();
        $array = new StadiumOwnerResource($stadiumOwner);


        return response()->success('verified successfully',$array);
    }

    /*
    * Display a listing of the resource.
    */
    public function index()
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
    public function show(string $id)
    {
        //
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
