<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Trip;
use Filament\Tables;
use App\Models\Party;
use App\Models\Company;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TripResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TripResource\RelationManagers;

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;

    protected static ?string $recordTitleAttribute = 'delivery_date';
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function getModelLabel(): string
    {
        return trans('Trip');
    }
    public static function getPluralModelLabel(): string
    {
        return trans('Trips');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('party_id')
                    ->relationship('parties', 'name')
                    ->required()
                    ->reactive()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                    ]),
                Forms\Components\Select::make('factory_id')
                    ->options(function (callable $get) {
                        $id = $get('party_id');
                        if ($id > 0) {
                            # code...
                            $trailers = Party::find($id)->factories;
                            return $trailers->pluck('address');
                        }
                        return [];
                    })
                    ->required(),
                Repeater::make('trailers')
                    ->schema([
                        Forms\Components\Select::make('companyId')
                            ->label(trans('Company'))
                            ->options(Company::all()->pluck('name', 'id'))
                            ->reactive()
                            // ->default(0)
                            // ->afterStateUpdated(fn (callable $set) => $set('trailerNo', null))
                            ->required(),
                        Forms\Components\Select::make('trailerNo')
                            ->label('Trailer')
                            ->multiple()
                            ->options(function (callable $get) {
                                $id = $get('companyId');
                                if ($id > 0) {
                                    # code...
                                    $trailers = Company::find($id)->trailers;
                                    return $trailers->pluck('number');
                                }
                                return [];
                            })
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\DatePicker::make('delivery_date')
                    ->required(),
                Forms\Components\Toggle::make('is_cash')
                    ->required(),
                // Forms\Components\TextInput::make('chalan_total'),
                // Forms\Components\TextInput::make('rent_total'), 
                // Forms\Components\TextInput::make('advance_total'),
                // Forms\Components\TextInput::make('due_total'),
                // Forms\Components\TextInput::make('commission_total'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_id'),
                Tables\Columns\TextColumn::make('party_id'),
                Tables\Columns\TextColumn::make('factory_id'),
                Tables\Columns\TextColumn::make('delivery_date')
                    ->date(),
                Tables\Columns\IconColumn::make('is_cash')
                    ->boolean(),
                Tables\Columns\TextColumn::make('chalan_total'),
                Tables\Columns\TextColumn::make('rent_total'),
                Tables\Columns\TextColumn::make('advance_total'),
                Tables\Columns\TextColumn::make('due_total'),
                Tables\Columns\TextColumn::make('commission_total'),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrips::route('/'),
            'create' => Pages\CreateTrip::route('/create'),
            'edit' => Pages\EditTrip::route('/{record}/edit'),
        ];
    }
}
