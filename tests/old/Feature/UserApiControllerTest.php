<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VerificationCode;
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
        $response->assertJson(['error' => 'invalid parameter']);

        // Case 2: User Exists (login)
        $user = factory(App\Models\User::class)->create(['phone' => '1234567890']);
        $response = $this->postJson('/api/user/generate-otp', ['phone' => '1234567890']);
        $response->assertJson(['error' => 'blocked']);

        // Case 3: OTP Generation Success
        $response = $this->postJson('/api/user/generate-otp', ['phone' => '0987654321']);
        $response->assertJson(['message' => 'done']);
    }

    public function test_verifyOtp()
    {
        // Case 1: Invalid Parameter
        $response = $this->postJson('/api/user/verify-otp', []);
        $response->assertJson(['error' => 'invalid parameter']);

        // Case 2: User Doesn't Exist (register)
        $response = $this->postJson('/api/user/verify-otp', [
            'phone' => '0987654321',
            'device_token' => 'test_device_token',
            'otp' => '123456'
        ]);
        $response->assertJson(['error' => 'not valid']);

        // Case 3: OTP Verification Success (login)
        $user = factory(User::class)->create(['phone' => '1234567890']);
        $verificationCode = factory(VerificationCode::class)->create([
            'phone' => $user->phone,
            'verifiable_id' => $user->id,
            'verifiable_type' => get_class($user),
            'otp' => '123456'
        ]);
        $response = $this->postJson('/api/user/verify-otp', [
            'phone' => $user->phone,
            'device_token' => 'test_device_token',
            'otp' => '123456'
        ]);
        $response->assertJson(['message' => 'verified successfully']);

        // Case 4: OTP Verification Success (register)
        $user = factory(App\Models\User::class)->create(['phone' => '0987654321']);
        $verificationCode = factory(App\Models\VerificationCode::class)->create([
            'phone' => $user->phone,
            'verifiable_id' => null,
            'verifiable_type' => App\Models\User::class,
            'otp' => '123456'
        ]);
        $response = $this->postJson('/api/user/verify-otp', [
            'phone' => '0987654321',
            'device_token' => 'test_device_token',
            'otp' => '123456'
        ]);
        $response->assertJson(['message' => 'verified successfully']);
    }

    public function test_register()
    {
        // Case 1: Invalid Parameter
        $response = $this->postJson('/api/user/register', []);
        $response->assertJson(['error' => 'invalid parameter']);

        // Case 2: Phone Not Verified
        $verificationCode = factory(App\Models\VerificationCode::class)->create([
            'phone' => '1234567890',
            'verifiable_id' => null,
            'verifiable_type' => App\Models\User::class,
            'device_token' => 'test_device_token',
            'verified_at' => null
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
        $response->assertJson(['error' => 'phone not verified']);

        // Case 3: Validation Error
        $response = $this->postJson('/api/user/register', ['phone' => '1234567890']);
        $response->assertJson(['error' => 'validation error']);

        // Case 4: Registration Success
        $verificationCode = factory(App\Models\VerificationCode::class)->create([
            'phone' => '1234567890',
            'verifiable_id' => null,
            'verifiable_type' => App\Models\User::class,
            'device_token' => 'test_device_token',
            'verified_at' => now()
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
        $response->assertJson(['message' => 'successfully logged in']);
    }

}
