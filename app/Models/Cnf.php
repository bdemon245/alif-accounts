<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cnf extends Model
{
    use HasFactory;

    /**
     * Get all of the phones.
     */
    public function phones(): MorphMany
    {
        return $this->morphMany(Phone::class, 'phonable');
    }
}
