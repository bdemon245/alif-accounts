<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TripResource\Pages;
use App\Filament\Resources\TripResource\RelationManagers;
use App\Models\Trip;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Forms\Components\Select::make('company_id')
                    ->relationship('companies','name')
                    ->required(),
                Forms\Components\Select::make('party_id')
                    ->relationship('parties','name')
                    ->required(),
                Forms\Components\Select::make('factory_id')
                    ->relationship('factories','name')
                    ->required(),
                Forms\Components\DatePicker::make('delivery_date')
                    ->required(),
                Forms\Components\Toggle::make('is_cash')
                    ->required(),
                Forms\Components\TextInput::make('chalan_total'),
                Forms\Components\TextInput::make('rent_total'), 
                Forms\Components\TextInput::make('advance_total'),
                Forms\Components\TextInput::make('due_total'),
                Forms\Components\TextInput::make('commission_total'),
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
