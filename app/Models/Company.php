<?php

namespace App\Models;

use App\Helpers\TranslateGPT;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
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
    function trailers(): BelongsToMany
    {
        return $this->belongsToMany(Trailer::class);
    }
    function trips(): HasMany
    {
        return $this->HasMany(Trip::class);
    }
    /**
     * The "booted" method of the model.
     */
    // protected static function booted(): void
    // {
    //     static::created(function (Company $company) {
    //         $gpt = new TranslateGPT;
    //         $content = json_decode($gpt->translate($company->name)->content);
    //         $translation = ['en' => $content->en, 'bn' => $content->bn];
    //         $company->name = $translation;
    //         $company->save();
    //     });
    // }
}
