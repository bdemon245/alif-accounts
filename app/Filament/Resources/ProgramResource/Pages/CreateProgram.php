<?php

namespace App\Filament\Resources\ProgramResource\Pages;

use App\Models\Trip;
use App\Models\Program;
use Filament\Pages\Actions;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProgramResource;

class CreateProgram extends CreateRecord
{
    protected static string $resource = ProgramResource::class;
}
