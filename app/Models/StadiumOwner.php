<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StadiumOwner extends Authenticatable
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','phone'];

//    public array $web_routes = ['store'=>'stadium.owner.store','update'=>'stadium.owner.update',];

    /**
     * @return MorphMany
     */
    public function verificationCodes(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany('App\VerificationCode', 'verifiable');
    }

}
