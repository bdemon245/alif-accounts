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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // $trips = [];
        // dd($data);
        // foreach ($data['trips'] as $key => $trip) {
        //     foreach ($trip['trailer_no'] as $number) {
        //         $trip = [
        //             'company_id' => $trip['company_id'],
        //             'trailer_no' => $number,
        //             'chalan' => Arr::get($trip, 'chalan', null),
        //             'advance' => Arr::get($trip, 'advance', null),
        //             'due' => Arr::get($trip, 'due', null),
        //             'commission' => Arr::get($trip, 'commission', null),
        //             'chalan_collected' => Arr::get($trip, 'chalan_collected', null),
        //         ];
        //         $trips[] = $trip;
        //     }
        // }
        // $data['trips'] = $trips;
        // dd($data);
        return $data;
    }
    // protected function handleRecordCreation(array $data): Model
    // {
    //     dd($data);
    //     $trips = array_pop($data);
    //     $program = Program::create($data);

    //     return Program::with('trips')->find($program->id);
    // }
}
