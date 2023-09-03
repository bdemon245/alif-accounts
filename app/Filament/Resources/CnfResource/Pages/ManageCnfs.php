<?php

namespace App\Filament\Resources\CnfResource\Pages;

use App\Filament\Resources\CnfResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCnfs extends ManageRecords
{
    protected static string $resource = CnfResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
