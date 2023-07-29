<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Party;
use App\Models\Company;
use App\Models\Program;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProgramResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProgramResource\RelationManagers;
use Filament\Forms\Components\Grid;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $recordTitleAttribute = 'delivery_date';
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function getModelLabel(): string
    {
        return trans('Program');
    }
    public static function getPluralModelLabel(): string
    {
        return trans('Programs');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()->columns(4)->schema([
                    Forms\Components\DatePicker::make('delivery_date')
                        ->label(trans("Delivery's") . " " . trans('Date'))
                        ->default(today())
                        ->displayFormat('d/m/Y')
                        ->required(),
                    Forms\Components\TextInput::make('weight')
                        ->label('Weight')
                        ->default(0)
                        ->prefix('kg')
                        ->required(),
                    Forms\Components\TextInput::make('fare')
                        ->label(trans("Rent"))
                        ->default(0)
                        ->prefix(html_entity_decode('&#2547;'))
                        ->required(),
                    Forms\Components\Toggle::make('is_cash')
                        ->label(trans("Cash"))
                        ->default(false)
                        ->inline(false)
                        ->required(),
                ]),
                Forms\Components\Grid::make()
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('party_id')
                            ->label('Party')
                            ->default(1)
                            ->options(Party::all()->pluck('name', 'id'))
                            ->required()
                            ->reactive()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label(trans("Party's") . " " . trans('Name'))
                                    ->required(),
                            ]),
                        Forms\Components\Select::make('factory_id')
                            ->label('Factory')
                            ->default(1)
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


                        Forms\Components\TextInput::make('job_no')
                            ->label(trans("Job") . " " . trans('No.')),
                    ]),
                Repeater::make('trips')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('company_id')
                            ->label(trans('Company'))
                            ->options(Company::all()->pluck('name', 'id'))
                            ->reactive()
                            ->searchable()
                            ->afterStateUpdated(fn (callable $set) => $set('trailer_no', null)),
                        Forms\Components\Select::make('trailer_no')
                            ->label(trans('Trailer\'s') . " " . trans('Number'))
                            ->searchable()
                            ->multiple()
                            ->options(function (callable $get) {
                                $id = $get('company_id');
                                if ($id > 0) {
                                    # code...
                                    $trailers = Company::find($id)->trailers;
                                    return $trailers->pluck('number', 'number');
                                }
                                return [];
                            }),

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
                            ->default(0)
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
                Tables\Columns\TextColumn::make('party_id'),
                Tables\Columns\TextColumn::make('factory_id'),
                Tables\Columns\TextColumn::make('delivery_date')
                    ->date(),
                Tables\Columns\IconColumn::make('type')
                    ->boolean(),
                Tables\Columns\TextColumn::make('job_no'),
                Tables\Columns\TextColumn::make('weight'),
                Tables\Columns\TextColumn::make('fare'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'view' => Pages\ViewProgram::route('/{record}'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
