<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trip extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'trailers' => 'array'
    ];

    function parties(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }
    function factories(): BelongsTo
    {
        return $this->belongsTo(Factory::class);
    }

    function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }
}
