<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FactoryResource\Pages;
use App\Filament\Resources\FactoryResource\RelationManagers;
use App\Models\Factory;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Split;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FactoryResource extends Resource
{
    protected static ?string $model = Factory::class;

    protected static ?string $navigationIcon = 'heroicon-o-office-building';
    protected static ?string $recordTitleAttribute = 'name';


    public static function getModelLabel(): string
    {
        return trans('Factory');
    }
    public static function getPluralModelLabel(): string
    {
        return trans('Factories');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('party_id')
                    ->relationship('party', 'name')
                    ->required(),
                Forms\Components\Textarea::make('name')
                    ->label(__('Factory'))
                    ->maxLength(65535),
                Repeater::make('phones')
                    ->label(__('Phone') . " " . __('Number'))
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('number')
                            ->label(trans('Number'))
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('party.name')
                    ->searchable()
                    ->weight('bold')
                    ->size('lg'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TagsColumn::make('phones.number')
                    ->label(__('Phone') . " " . __('Number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->visibleFrom('md')
                    ->alignEnd(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFactories::route('/'),
        ];
    }
}
