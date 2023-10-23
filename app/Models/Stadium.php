<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Stadium extends Model  implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;


    public function sports(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Sport::class);
    }

    public function stadiumOwner()
    {
        return $this->belongsTo(StadiumOwner::class, 'stadium_owner_id');
    }

    public function stadiumType()
    {
        return $this->belongsTo(StadiumType::class);
    }

}
