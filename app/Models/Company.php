<?php

namespace App\Models;

use App\Helpers\TranslateGPT;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Company extends Model
{
    use HasFactory, HasTranslations;
    protected $guarded = [];
    protected $translatable = ['name'];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (Company $company) {
            $gpt = new TranslateGPT;
            $content = json_decode($gpt->translate($company->name)->content);
            $translation = ['en' => $content->en, 'bn' => $content->bn];
            $company->name = $translation;
            $company->save();
        });
    }
}
