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
            $items = [];
            foreach ($trailer['trailer_no'] as $number) {
                $item = [
                    'number' => $number,
                    'chalan_received' => 0,
                ];
                $items[] = $item;
            }

            $trip = Trip::create([
                'delivery_date' => $data["delivery_date"],
                'party_id' => $data["party_id"],
                'factory_id' => $data["factory_id"],
                'is_cash' => $data["is_cash"],
            ]);
            dd($trip->companies);
        }
        return $trip;
    }
}
