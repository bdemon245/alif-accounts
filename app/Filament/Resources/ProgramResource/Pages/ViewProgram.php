<?php

namespace App\Filament\Resources\ProgramResource\Pages;

use App\Filament\Resources\ProgramResource;
use App\Models\Program;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProgram extends ViewRecord
{
    protected static string $resource = ProgramResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // $trips = Program::find($data['id'])->trips->toArray();
        // $data['trips'] = $trips;


        return $data;
    }
}
