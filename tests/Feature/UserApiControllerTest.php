<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_generateOtp()
    {
        // Case 1: Invalid Parameter
        $response = $this->postJson('/api/user/generate-otp', []);
        $response->assertJson(['status'=>false,'msg' => 'invalid parameter','data'=>[],'errors'=>[]]);

        // Case 2: User Exists and Blocked (login)
        $user = User::factory()->create(['phone' => '1234567890']);
        // Create more than 2 verification codes within an hour
        VerificationCode::factory(3)->create([
            'phone' => $user->phone,
            'verifiable_id' => $user->id,
            'verifiable_type' => get_class($user),
            'created_at' => now()->subMinutes(30),
            'otp'=>'123456',
            'expire_at' => Carbon::now()->addMinutes(3),
        ]);
        $response = $this->postJson('/api/user/generate-otp', ['phone' => '1234567890']);
        $response->assertJson(['status'=>false,'msg' =>'blocked','data'=>[],'errors'=>[]]);


        // Case 3: User Exists and Can Generate OTP (login)
        $response = $this->postJson('/api/user/generate-otp', ['phone' => '0987654321']);
        $response->assertJson(['status'=>true,'msg' =>'done','data'=>[],'errors'=>[]]);

        // Case 4: User Doesn't Exist and Blocked (register)
        // Create more than 2 verification codes within an hour
        VerificationCode::factory( 3)->create([
            'phone' => '0987654321',
            'verifiable_id' => null,
            'verifiable_type' => App\Models\User::class,
            'created_at' => now()->subMinutes(30),
            'otp'=>'123456',
            'expire_at' => Carbon::now()->addMinutes(3),
        ]);

        $response = $this->postJson('/api/user/generate-otp', ['phone' => '0987654321']);
        $response->assertJson(['status'=>false,'msg' =>'blocked','data'=>[],'errors'=>[]]);

        // Case 5: User Doesn't Exist and Can Generate OTP (register)
        $response = $this->postJson('/api/user/generate-otp', ['phone' => '9876543210']);
        $response->assertJson(['status'=>true,'msg' =>'done','data'=>[],'errors'=>[]]);
    }

    public function test_verifyOtp()
    {
        // Case 1: Invalid Parameter
        $response = $this->postJson('/api/user/verify-otp', []);
        $response->assertJson(['status'=>false,'msg' =>  'invalid parameter']);

        // Case 2: User Doesn't Exist (register)
        $response = $this->postJson('/api/user/verify-otp', [
            'phone' => '0987654321',
            'device_token' => 'test_device_token',
            'otp' => '123456'
        ]);
        $response->assertJson(['status'=>false,'msg' =>  'not valid']);

        // Case 3: OTP Verification Success (login)
        $user = User::factory()->create(['phone' => '1234567890']);
        $verificationCode = VerificationCode::factory()->create([
            'phone' => $user->phone,
            'verifiable_id' => $user->id,
            'verifiable_type' => get_class($user),
            'otp' => '123456',
            'expire_at' => Carbon::now()->addMinutes(3),
        ]);
        $response = $this->postJson('/api/user/verify-otp', [
            'phone' => $user->phone,
            'device_token' => 'test_device_token',
            'otp' => '123456'
        ]);
        $response->assertJson(['status'=>true,'msg' =>  'verified successfully']);

        // Case 4: OTP Verification Success (register)
        $user = User::factory()->create(['phone' => '0987654321']);
        $verificationCode = VerificationCode::factory()->create([
            'phone' => $user->phone,
            'verifiable_id' => null,
            'verifiable_type' => App\Models\User::class,
            'otp' => '123456',
            'expire_at' => Carbon::now()->addMinutes(3),

        ]);
        $response = $this->postJson('/api/user/verify-otp', [
            'phone' => '0987654321',
            'device_token' => 'test_device_token',
            'otp' => '123456'
        ]);
        $response->assertJson(['status'=>true,'msg' =>  'verified successfully']);
    }

    public function test_register()
    {
        // Case 1: Invalid Parameter
        $response = $this->postJson('/api/user/register', []);
        $response->assertJson(['status'=>false,'msg' =>  'invalid parameter']);

        // Case 2: Phone Not Verified
        $verificationCode = VerificationCode::factory()->create([
            'phone' => '1234567890',
            'verifiable_id' => null,
            'verifiable_type' => App\Models\User::class,
            'device_token' => 'test_device_token',
            'verified_at' => null,
            'otp' => '123456',
            'expire_at' => Carbon::now()->addMinutes(3),
        ]);
        $response = $this->postJson('/api/user/register', [
            'name' => 'Test User',
            'username' => 'test_user',
            'gender' => 1,
            'day_of_birth' => '1990-01-01',
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'device_token' => 'test_device_token'
        ]);
        $response->assertJson(['status'=>false,'msg' =>  'phone not verified']);

        // Case 3: Validation Error
        $response = $this->postJson('/api/user/register', ['phone' => '1234567890']);
        $response->assertJson(['status'=>false,'msg' =>  'validation error']);

        // Case 4: Registration Success
        $verificationCode = VerificationCode::factory()->create([
            'phone' => '1234567890',
            'verifiable_id' => null,
            'verifiable_type' => App\Models\User::class,
            'device_token' => 'test_device_token',
            'verified_at' => now(),
            'otp' => '123456',
            'expire_at' => Carbon::now()->addMinutes(3),
        ]);
        $response = $this->postJson('/api/user/register', [
            'name' => 'Test User',
            'username' => 'test_user',
            'gender' => 1,
            'day_of_birth' => '1990-01-01',
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'device_token' => 'test_device_token'
        ]);
        $response->assertJson(['status'=>true,'msg' =>  'successfully logged in']);
    }

}
