<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
//        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
//        'password',
//        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
//        'password' => 'hashed',
    ];

    /**
     * @return MorphMany
     */
    public function verificationCodes(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(VerificationCode::class, 'verifiable');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class)->withPivot('position_id');
    }
    public function teamUsers()
    {
        return $this->hasMany(TeamUser::class);
    }
    public function sports()
    {
        return $this->belongsToMany(Sport::class);
    }
    public function friendsTo(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
            ->withPivot('accepted')
            ->withTimestamps();
    }

    public function friendsFrom(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
            ->withPivot('accepted')
            ->withTimestamps();
    }

    public function pendingFriendsTo(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->friendsTo()->wherePivot('accepted', false);
    }

    public function pendingFriendsFrom(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->friendsFrom()->wherePivot('accepted', false);
    }

    public function acceptedFriendsTo(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->friendsTo()->wherePivot('accepted', true);
    }

    public function acceptedFriendsFrom(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->friendsFrom()->wherePivot('accepted', true);
    }


    public function friends(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
            ->withPivot('accepted')
            ->withTimestamps();
    }
}
