<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Factory extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get all of the phones.
     */
    public function phones(): MorphMany
    {
        return $this->morphMany(Phone::class, 'phonable');
    }
    function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }
}
