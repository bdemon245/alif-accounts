<?php

namespace App\Filament\Resources;

use App\Models\Cnf;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CnfResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CnfResource\RelationManagers;

class CnfResource extends Resource
{
    protected static ?string $model = Cnf::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $recordTitleAttribute = 'name';


    public static function getModelLabel(): string
    {
        return trans('C&F');
    }
    public static function getPluralModelLabel(): string
    {
        return trans('C&Fs');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('party_id')
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
                Tables\Columns\TextColumn::make('party_id'),
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
            'index' => Pages\ManageCnfs::route('/'),
        ];
    }
}
