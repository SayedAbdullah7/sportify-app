<?php

namespace App\Http\Controllers\Api;

use App\DataTables\AdminsDataTable;
use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Resources\StadiumOwnerResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {

    }


    public function generateOtp(Request $request)
    {
        // Check parameters
        if(!$request->phone){
            return response()->error('invalid parameter');
        }

        // Check model exited to determine its login or register
        $user = User::where('phone',$request->phone)->first();
//        if ($user){
//            return response()->error('already registered');
//        }

        // Check availability to generate OTP
        $now = Carbon::now();
        if($user){  // login
            $verificationCodes = $user->verificationCodes;
        }else{      // register
            $verificationCodes = VerificationCode::where('phone',$request->phone)->get();
        }
        if ($verificationCodes->count() >= 3 && $now->subHour()->isBefore($verificationCodes->last()->created_at)){
            return response()->error('blocked');
        }

        // Generate OTP with gateway
        $otp = '1234';


        // Store the OTP
        if($user) {  // login
            $user->verificationCodes()->create([
                'otp' => $otp,
                'expire_at' => Carbon::now()->addMinutes(3)
            ]);
        }else{  //register
            VerificationCode::create([
                'otp' => $otp,
                'expire_at' => Carbon::now()->addMinutes(3),
                'verifiable_type' => User::class,
                'phone' => $request->phone
            ]);

        }


        return response()->success('done');
    }

    public function verifyOtp(Request $request)
    {
        // Check parameters
        if(!$request->phone || !$request->device_token || strlen($request->otp) !== 4){
            return response()->error('invalid parameter');
        }

        // Check model exited to determine its login or register
        $user = User::where('phone',$request->phone)->first();


        // Verify the OTP
        if($user){  // login
            $verificationCode = $user->verificationCodes()->where('otp',$request->otp)->first();

        }else{      //register
            $verificationCode = VerificationCode::
            where('otp',$request->otp)->
            where('expire_at', '>', now())->
            where('verifiable_type', User::class)->
            where('phone',$request->phone)->
            where('verified_at', null)->
            first();
        }
        if(!$verificationCode){
            return response()->error('not valid');
        }

        if($user) {  //login
            // Delete all the old OTPs for this stadiumOwner
            $user->verificationCodes()->delete();

        }else{      //register
            // update verificationCode
            $verificationCode->update([
                'device_token' => $request->device_token,
                'verified_at' => now()
            ]);
            // Delete all the old OTPs for this number
            VerificationCode::where('phone',$request->phone)->whereNot('id',$verificationCode->id)->delete();
        }



        return response()->success('verified successfully',$user?new UserResource($user):[]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        // Check parameters
        if(!$request->phone || !$request->device_token){
            return response()->error('invalid parameter');
        }

        // check phone verify
        $verificationCode = VerificationCode::
        where('verifiable_id', null)->
        where('verifiable_type', User::class)->
        where('phone',$request->phone)->
        where('device_token',$request->device_token)->
        where('verified_at','!=', null)->
        latest()->first();

        if(!$verificationCode){
            return response()->error('phone not verified');
        }

        $validateUser = Validator::make($request->all(),
        [
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|unique:users|max:255',
            'gender' => 'required|boolean',
            'day_of_birth' => 'required|date',
            'email' => 'email|unique:users|max:255',
            'phone' => 'required|unique:users|max:25',
        ]);

        if($validateUser->fails()){
            return response()->error('validation error',$validateUser->errors()->toArray());
        }

        // Create new model
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->gender = $request->gender;
        $user->day_of_birth = $request->day_of_birth;
        $user->email = $request->email;
        $user->phone = $request->phone;
        // $user->password = bcrypt($request->password); //
        $user->save();


        // Delete all the OTPs for this number
        VerificationCode::where('phone',$verificationCode->phone)->delete();


        return response()->success('successfully logged in',new UserResource($user));
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
