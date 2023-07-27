<?php

namespace App\Filament\Resources\TripResource\Pages;

use Filament\Pages\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\TripResource;
use App\Models\Trip;
use Filament\Resources\Pages\CreateRecord;

class CreateTrip extends CreateRecord
{
    protected static string $resource = TripResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $trip = '';
        foreach ($data['trailers'] as $key => $trailer) {
            // dd($data['party_id']);
            $trip = Trip::create([
                'delivery_date' => $data["delivery_date"],
                'party_id' => $data["party_id"],
                'factory_id' => $data["factory_id"],
                'company_id' => $trailer["company_id"],
                'is_cash' => $data["is_cash"],
            ]);
            foreach ($trailer['trailer_no'] as $trailer_id) {
                $trip->trailers()->attach($trailer_id, [
                    "chalan" => $trailer['chalan'],
                    "advance" => $trailer['advance'],
                    "due" => $trailer['due'],
                ]);
            }
        }
        return $trip;
    }
}
