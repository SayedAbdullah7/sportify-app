<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class StadiumOwner extends Model
{
    use HasFactory;

    /**
     * @return MorphMany
     */
    public function verificationCodes(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany('App\VerificationCode', 'verifiable');
    }

}
