<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Staudenmeir\LaravelMergedRelations\Eloquent\HasMergedRelationships;

class Team extends Model  implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasMergedRelationships;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','sport_id'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('position_id','is_cap');
//        return $this->belongsToMany(User::class,'team_user','user_id', 'team_id');

    }
    public function user() // team creator
    {
        return $this->belongsTo(User::class);
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
