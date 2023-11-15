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
    public function facilities(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Facility::class);
    }

    public function stadiumOwner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(StadiumOwner::class, 'stadium_owner_id');
    }

    public function stadiumType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(StadiumType::class);
    }

}
