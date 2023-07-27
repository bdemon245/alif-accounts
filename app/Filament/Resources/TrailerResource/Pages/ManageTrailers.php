<?php

namespace App\Filament\Resources\TrailerResource\Pages;

use App\Filament\Resources\TrailerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTrailers extends ManageRecords
{
    protected static string $resource = TrailerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
