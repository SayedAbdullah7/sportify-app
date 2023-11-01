<?php

namespace App\Services;

use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;

class OtpService
{
    public function generateOtp($phone, $user = null)
    {
        $now = Carbon::now();
        $verificationCodes = $user ? $user->verificationCodes : VerificationCode::where('phone', $phone)->get();

        if ($verificationCodes->count() >= 3 && $now->subHour()->isBefore($verificationCodes->last()->created_at)) {
            return 'blocked';
        }

        // Generate OTP with gateway
        $otp = '123456';

        return $otp;
    }

    public function verifyOtp($phone, $otp, $user = null)
    {
        $verificationCode = $user ?
            $user->verificationCodes()->where('otp', $otp)->first() :
            VerificationCode::where('otp', $otp)
                ->where('expire_at', '>', now())
                ->where('verifiable_type', User::class)
                ->where('phone', $phone)
                ->where('verified_at', null)
                ->first();

        return $verificationCode ? 'verified' : 'not valid';
    }
}
