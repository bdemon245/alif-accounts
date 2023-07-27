<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trailer extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    function trips(): BelongsToMany
    {
        return $this->belongsToMany(Trip::class);
    }
}