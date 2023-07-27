<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trip extends Model
{
    use HasFactory;
    protected $guarded = [];

    function companies(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    function parties(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }
    function factories(): BelongsTo
    {
        return $this->belongsTo(Factory::class);
    }
    function trailers(): BelongsToMany
    {
        return $this->belongsToMany(Trailer::class);
    }
}
