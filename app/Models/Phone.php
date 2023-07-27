<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Phone extends Model
{
    use HasFactory;
    protected $guarded = [];

     /**
     * Get the parent phonable model (factory or cnf).
     */
    public function phonable(): MorphTo
    {
        return $this->morphTo();
    }
}
