<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Party extends Model
{
    use HasFactory;
    function factories(): HasMany
    {
        return $this->hasMany(Factory::class);
    }
    function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
    
}
