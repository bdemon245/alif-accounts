<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Company;
use App\Models\Trailer;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CompanyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Filament\Resources\CompanyResource\RelationManagers\TrailersRelationManager;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getModelLabel(): string
    {
        return trans('Company');
    }
    public static function getPluralModelLabel(): string
    {
        return trans('Companies');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->hidden()
                    ->disabled()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('trailers')
                    ->multiple()
                    ->relationship('trailers', 'number')
                    ->columnSpan(3)
                    ->searchable()
                    ->options(function ($state, callable $get) {
                        $id = $get('id');
                        if ($id > 0) {
                            $exists = Company::find($id)->trailers->pluck('number')->toArray();
                            $filtered = Trailer::get()->whereNotIn('number', $exists)->pluck('number', 'id');

                            return $filtered->all();
                        }
                        return [];
                    })
                    ->createOptionForm([
                        Forms\Components\TextInput::make('number')
                            ->label(trans("New") . " " . trans('Trailer'))
                            ->autofocus(true)
                            ->required(),
                    ]),
            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),

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

    // public static function getRelations(): array
    // {
    //     return [
    //         RelationManagers\TrailersRelationManager::class,
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCompanies::route('/'),
        ];
    }
}
