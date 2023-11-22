<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
