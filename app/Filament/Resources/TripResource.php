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
use Filament\Forms\Components\Grid;

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
        return $form->make([
            'default' => 3,
        ])
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\DatePicker::make('delivery_date')
                            ->label(trans("Delivery's") . " " . trans('Date'))
                            ->default(today())
                            ->displayFormat('d/m/Y')
                            ->required(),
                        Forms\Components\Toggle::make('is_cash')
                            ->label('Cash')
                            ->inline(false)
                            ->required(),
                        Forms\Components\Select::make('party_id')
                            ->label('Party')
                            ->relationship('parties', 'name')
                            ->required()
                            ->reactive()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label(trans("Party's") . " " . trans('Name'))
                                    ->required(),
                            ]),
                        Forms\Components\Select::make('factory_id')
                            ->label('Factory')
                            ->options(function (callable $get) {
                                $id = $get('party_id');
                                if ($id > 0) {
                                    # code...
                                    $trailers = Party::find($id)->factories;
                                    return $trailers->pluck('name', 'id');
                                }
                                return [];
                            })
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label(trans("Factory's") . " " . trans('Name'))
                                    ->required(),
                                Forms\Components\Textarea::make('address')
                                    ->label(trans("Factory's") . " " . trans('Address'))
                                    ->required(),
                            ]),

                    ]),
                Repeater::make('trailers')
                    ->schema([
                        Forms\Components\Select::make('company_id')
                            ->label(trans('Company'))
                            ->options(Company::all()->pluck('name', 'id'))
                            ->reactive()
                            ->searchable()
                            ->afterStateUpdated(fn (callable $set) => $set('trailer_no', null))
                            ->required(),
                        Forms\Components\Select::make('trailer_no')
                            ->label(trans('Trailer\'s') . " " . trans('Number'))
                            ->multiple()
                            ->searchable()
                            ->options(function (callable $get) {
                                $id = $get('company_id');
                                if ($id > 0) {
                                    # code...
                                    $trailers = Company::find($id)->trailers;
                                    return $trailers->pluck('number', 'id');
                                }
                                return [];
                            })
                            ->required(),

                        Forms\Components\TextInput::make('chalan')
                            ->default(0)
                            ->numeric()
                            ->placeholder(trans('Advance'))
                            ->prefix(html_entity_decode('&#2547;')),
                        Forms\Components\TextInput::make('advance')
                            ->default(0)
                            ->numeric()
                            ->placeholder(trans('Advance'))
                            ->prefix(html_entity_decode('&#2547;')),
                        Forms\Components\TextInput::make('due')
                            ->numeric()
                            ->placeholder(trans('Due'))
                            ->prefix(html_entity_decode('&#2547;')),

                    ])
                    ->columns(5),
            ])->columns(1);
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

    public function create(): void
    {
        dd('hello');
        // Post::create();
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
