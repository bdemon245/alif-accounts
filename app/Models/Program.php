<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory;
    protected $guarded = [];


    function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
    function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }
    function factory(): BelongsTo
    {
        return $this->belongsTo(Factory::class);
    }
}
