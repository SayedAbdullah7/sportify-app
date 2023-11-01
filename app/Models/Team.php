<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('position_id','is_cap');
//        return $this->belongsToMany(User::class,'team_user','user_id', 'team_id');

    }
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function teamUsers()
    {
        return $this->hasMany(TeamUser::class);
    }


    public function captain()
    {
        return $this->hasOne(TeamUser::class)->where('is_cap',1);
    }

}
