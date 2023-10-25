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

class UserController extends BaseController
{
    public function index()
    {

    }


    public function generateOtp(Request $request)
    {
        // Check parameters
        if(!$request->phone){
            return $this->handleError('invalid parameter');
        }

        // Check model exited to determine its login or register
        $user = User::where('phone',$request->phone)->first();

        // Check availability to generate OTP
        $now = Carbon::now();
        if($user){  // login
            $verificationCodes = $user->verificationCodes;
        }else{      // register
            $verificationCodes = VerificationCode::where('phone',$request->phone)->get();
        }
        if ($verificationCodes->count() >= 3 && $now->subHour()->isBefore($verificationCodes->last()->created_at)){
//            return $this->handleError('blocked');
            return $this->handleError('blocked');
        }

        // Generate OTP with gateway
        $otp = '123456';


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


        return $this->handleResponse('done');
    }

    public function verifyOtp(Request $request)
    {
        // Check parameters
        if(!$request->phone || !$request->device_token || strlen($request->otp) !== 6){
            return $this->handleError('invalid parameter');
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
            return $this->handleError('not valid');
        }

        if($user) {  //login
            // Delete all the old OTPs for this stadiumOwner
            $user->verificationCodes()->delete();

            $token = $user->createToken('app-token')->plainTextToken;
            $response = [
                'user'=>new UserResource($user),
                'token'=>$token
            ];

        }else{      //register
            // update verificationCode
            $verificationCode->update([
                'device_token' => $request->device_token,
                'verified_at' => now()
            ]);
            // Delete all the old OTPs for this number
            VerificationCode::where('phone',$request->phone)->whereNot('id',$verificationCode->id)->delete();
            $response = [];
        }



        return $this->handleResponse('verified successfully',$response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        // Check parameters
        if(!$request->phone || !$request->device_token){
            return $this->handleError('invalid parameter');
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
            return $this->handleError('phone not verified');
        }

        $validateUser = Validator::make($request->all(),
        [
            'name' => 'required|string|regex:/(^[A-Za-z0-9 ]+$)+/|max:255',
            'username' => 'nullable|string|unique:users|max:255',
            'gender' => 'required|boolean',
            'day_of_birth' => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(16)->format('Y-m-d') . '|after_or_equal:' . \Carbon\Carbon::now()->subYears(80)->format('Y-m-d'),
            'email' => 'email|unique:users|max:255',
            'phone' => 'required|unique:users|max:25',
        ]);

        if($validateUser->fails()){
            return $this->handleError('validation error',$validateUser->errors()->toArray());
        }

        // Create new model
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->gender = $request->gender;
        $user->day_of_birth = $request->day_of_birth;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();


        // Delete all the OTPs for this number
        VerificationCode::where('phone',$verificationCode->phone)->delete();

        $token = $user->createToken('app-token')->plainTextToken;
        $response = [
            'user'=>new UserResource($user),
            'token'=>$token
        ];
        return $this->handleResponse('successfully logged in',$response);
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
